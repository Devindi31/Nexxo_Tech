<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $serviceResult = Database::search("SELECT * FROM `service`");
    $serviceData =  $serviceResult->fetch_assoc();

    $email = $_SESSION["NexxoTechUser"]["email"];
    $service_email = $serviceData["service_email"];

    $messageResult = Database::search("SELECT * FROM `message` WHERE `service`='" . $service_email . "' AND `customer`='" . $email . "' AND `status`='0' AND `type`='2'");
    $messageNum = $messageResult->num_rows;

    if ($messageNum > 0) {

        for ($m = 0; $m < $messageNum; $m++) {
            $messageData = $messageResult->fetch_assoc();

            Database::iud("UPDATE `message` SET `status`='1' WHERE `message_id`='" . $messageData["message_id"] . "'");
          
        }
    }
} else {
    echo "login";
}
