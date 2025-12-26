<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $email = $_POST["email"];
    $status = $_POST["status"];

    $userResult = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();

        if ($status == "true") {

            Database::iud("UPDATE `user` SET `status_status_id`='1' WHERE `email`='$email'");
        } else {
            Database::iud("UPDATE `user` SET `status_status_id`='2' WHERE `email`='$email'");
        }

        echo "success";
    } else {
        echo "User Not Found";
    }
} else {
    echo "login";
}
