<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) { 

    $email = $_SESSION["NexxoTechUser"]["email"];
    $message = $_POST["message_text"];

    if (!empty($message)) {

        $serviceResult = Database::search("SELECT * FROM `service`");
        $serviceData =  $serviceResult->fetch_assoc();
        $service_email = $serviceData["service_email"];

        $date = new DateTime();
        $timeZoon = new DateTimeZone('Asia/Colombo');
        $date->setTimezone($timeZoon);
        $newDate = $date->format('Y-m-d H:i:s');

        Database::iud("INSERT INTO `message`(`message_content`,`date_time`,`status`,`service`,`customer`,`type`) 
        VALUES('$message','$newDate','0','$service_email','$email','1')");
        echo "success";
    }
} else {
    echo "login";
}
