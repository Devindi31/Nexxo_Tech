<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];
    $productId = $_GET["id"];

    $productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$productId'");

    if ($productResult->num_rows > 0) {

        $watchlistResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='$email' AND `product_product_id`='$productId'");
        $watchlistNum = $watchlistResult->num_rows;

        if ($watchlistNum > 0) {

            Database::iud("DELETE FROM `watchlist` WHERE `user_email`='$email' AND `product_product_id`='$productId'");
        } else {

            Database::iud("INSERT INTO `watchlist` (`user_email`, `product_product_id`) VALUES ('$email','$productId')");
        }

        echo "success";
    } else {
        echo "Product Not Found";
    }
} else {
    echo "login";
}
