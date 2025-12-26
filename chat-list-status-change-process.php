<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    if (isset($_GET["customerEmail"])) {
        $email = $_GET["customerEmail"];

        $userResult = Database::search("SELECT * FROM `user` WHERE `email` = '$email'");
        if ($userResult->num_rows > 0) {

            $messageResult = Database::search("SELECT * FROM `message` WHERE `customer`='$email' AND `status`='0' AND `type`='1'");
            if ($messageResult->num_rows > 0) {
                
               Database::iud("UPDATE `message` SET `status`='1' WHERE `customer`='$email' AND `type`='1'");
               echo "success";
            }

        }else{
            echo "User Not Found";
        }
    } else {
        echo "Something went wrong";
    }
}
