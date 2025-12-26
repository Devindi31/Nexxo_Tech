<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];
    $product_id = $_POST["productId"];
    $feedback_text = $_POST["feedback"];

    if (empty($feedback_text)) {
        echo ("Please Enter Your Feedback");
    } else {

        $productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$product_id'");

        if ($productResult->num_rows > 0) {

            $dateTime = new DateTime();
            $timeZoon = new DateTimeZone("Asia/Colombo");
            $dateTime->setTimezone($timeZoon);
            $newDate = $dateTime->format("Y-m-d");


            Database::iud("INSERT INTO `feedback`(`user_email`, `product_product_id`, `feedback_text`,`date`) VALUES ('$email','$product_id','$feedback_text','$newDate')");
            echo ("success");
        } else {
            echo ("Product Not Found");
        }
    }
} else {
    echo "Please Login First";
}
