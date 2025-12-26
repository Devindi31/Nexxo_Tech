<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $brandName = $_POST['brandName'];


    if (empty($brandName)) {

        echo "Enter Brand Name";
    } else if (sizeof($_FILES) == 0) {

        echo "Please Select Brand Image";
    } else {

        $brandResult = Database::search("SELECT * FROM `brand` WHERE `brand_name` = '$brandName'");
        $brandResultNum = $brandResult->num_rows;

        if ($brandResultNum > 0) {
            echo "This Brand already exists.";
        } else {

        $image = $_FILES["brandImage"];

            $allowed_image_extentions = array("image/svg+xml");
            $file_extention = $image["type"];

            if (!in_array($file_extention, $allowed_image_extentions)) {
                echo ("Please select a valid file. Only .svg is allowed");
            } else {

                $new_file_extention;

                if ($file_extention == "image/svg+xml") {
                    $new_file_extention = ".svg";
                }

                $imageName = "images/icon/" . $brandName . $new_file_extention;
                move_uploaded_file($image["tmp_name"], $imageName);

                Database::iud("INSERT INTO `brand` (`brand_name`,`icon_path`) VALUES('$brandName','$imageName')");

                echo ("success");
            }
        }
    }
}
