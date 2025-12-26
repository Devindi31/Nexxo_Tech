<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];
    $productId = $_GET["id"];
    $colorId = $_GET["colorId"];

    $productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$productId'");

    if ($productResult->num_rows > 0) {

        if ($colorId != 0) {

            $eBagResult = Database::search("SELECT * FROM `ebag` WHERE `user_email` = '$email' AND `product_product_id` = '$productId' AND `color_color_id` = '$colorId'");
            $eBagNum = $eBagResult->num_rows;

            if ($eBagNum > 0) {
                $eBagData = $eBagResult->fetch_assoc();

                $newQuantity = $eBagData["ebag_quantity"] + 1;
                
                Database::iud("UPDATE `ebag` SET `ebag_quantity` = '$newQuantity' WHERE `ebag_id` = '".$eBagData["ebag_id"]."'");
                echo("updated");
                
            }else{

                Database::iud("INSERT INTO `ebag`(`ebag_quantity`, `user_email`, `product_product_id`, `color_color_id`) 
                VALUES ('1','$email','$productId','$colorId')");
                echo("added");

            }

        } else {
            echo "Please select a color, or this product has no colors";
        }
    } else {
        echo "Product Not Found";
    }
} else {
    echo "login";
}
