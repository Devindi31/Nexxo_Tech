<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    if (isset($_GET["orderId"]) && isset($_GET["status"])) {

        $orderId = $_GET["orderId"];
        $status = $_GET["status"];

        $orderResult = Database::search("SELECT * FROM `order` WHERE `order_id`='$orderId'");
        if ($orderResult->num_rows > 0) {

            Database::iud("UPDATE `order` SET `status`='$status' WHERE `order_id`='$orderId'");
            echo "success";

        }else{
            echo "Order Not Found";
        }

    } else {
        echo "Something went wrong";
    }
} else {
    echo "login";
}
