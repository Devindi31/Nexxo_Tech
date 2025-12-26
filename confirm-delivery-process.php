<?php

include "connection.php";
session_start();


if (isset($_SESSION["NexxoTechUser"])) {

    $itemId = $_GET["itemId"];

    $orderResults = Database::search("SELECT * FROM `order` WHERE `item_id`='$itemId'");

    if ($orderResults->num_rows > 0) {

        Database::iud("UPDATE `order` SET `confirm_status`='1' WHERE `item_id`='$itemId'");
        echo "success";

    } else {
        echo "Item Not Found";
    }
} else {
    echo "login";
}
