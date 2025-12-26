<?php

include "connection.php";
session_start();

$signInEmail = $_POST["signInEmail"];
$signInPassword = $_POST["signInPassword"];
$rememberMe = $_POST["rememberMe"];

if (empty($signInEmail)) {
    echo ("Enter a your email address");
} else if (empty($signInPassword)) {
    echo ("Enter your password");
} else {

    $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $signInEmail . "' AND `password`='" . $signInPassword . "'");
    $numRows = $resultSet->num_rows;

    if ($numRows > 0) {

        $userData = $resultSet->fetch_assoc();

        $_SESSION["NexxoTechUser"] = $userData;

        if ($rememberMe == "true") {

            setcookie("email", $signInEmail, time() + (60 * 60 * 24 * 7));
            setcookie("password", $signInPassword, time() + (60 * 60 * 24 * 7));
        } else {

            setcookie("email", "", -1);
            setcookie("password", "", -1);
        }

        echo ("success");
    } else {
        echo ("Invalid email or password");
    }
}
