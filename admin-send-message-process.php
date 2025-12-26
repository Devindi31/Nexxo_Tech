<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {
    $service = $_SESSION["service"]["service_email"];

    $email = $_POST["email"];
    $message = $_POST["message"];

    if (!empty($message)) {

        if (!empty($email) && isset($email)) {


            $date = new DateTime();
            $timeZoon = new DateTimeZone('Asia/Colombo');
            $date->setTimezone($timeZoon);
            $newDate = $date->format('Y-m-d H:i:s');

            Database::iud("INSERT INTO `message`(`message_content`,`date_time`,`status`,`service`,`customer`,`type`) VALUES('$message','$newDate','0','$service','$email','2')");
            echo "success";
        } else {
            echo "Customer Not Found";
        }
    }
}
