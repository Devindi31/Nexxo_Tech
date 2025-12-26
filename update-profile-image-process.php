<?php
include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];

    $userResult = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

    if ($userResult->num_rows > 0) {

        $userData = $userResult->fetch_assoc();
        $image = $_FILES["profileImage"];

        $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $file_extention = $image["type"];

        if (!in_array($file_extention, $allowed_image_extentions)) {
            echo ("Please select a valid file. Allowed file extensions are: .jpg, .jpeg, .png, .svg");
        } else {

            $new_file_extention;

            if ($file_extention == "image/jpg") {
                $new_file_extention = ".jpg";
            } else if ($file_extention == "image/jpeg") {
                $new_file_extention = ".jpeg";
            } else if ($file_extention == "image/png") {
                $new_file_extention = ".png";
            } else if ($file_extention == "image/svg+xml") {
                $new_file_extention = ".svg";
            }

            if (isset($userData["profile_image_path"]) && !empty($userData["profile_image_path"])) {
                unlink($userData["profile_image_path"]);
            }

            $imageName = "images/profile_images/" . $userData["fname"] . "_" . uniqid() . "_" . $new_file_extention;
            move_uploaded_file($image["tmp_name"], $imageName);

            Database::iud("UPDATE `user` SET `profile_image_path`='" . $imageName . "' WHERE `email`='" . $email . "'");

            echo ("Your profile image has been updated successfully.");
        }
    } else {

        echo ("User Not Found");
    }
} else {
    echo ("Please Login First");
    exit();
}
