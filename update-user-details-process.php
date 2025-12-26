<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];

    if (empty($firstName)) {
        echo "Emter a First Name";
    } else if (empty($lastName)) {
        echo "Enter a Last Name";
    } else {

        $userResult = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

        if ($userResult->num_rows > 0) {

            Database::iud("UPDATE `user` SET `fname`='" . $firstName . "', `lname`='" . $lastName . "' WHERE `email`='" . $email . "'");
            echo "success";
        } else {

            echo "User Not Found";
        }
    }

} else {

    echo ("Please Login First");
}
