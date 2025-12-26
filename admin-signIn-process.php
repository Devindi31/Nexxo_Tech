<?php
session_start();
include "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

if (empty($email)) {
    echo "Please enter service email";
} else if (empty($password)) {
    echo "Please enter password";
} else {

    $serviceResult = Database::search("SELECT * FROM `service` WHERE `service_email`='" . $email . "' AND `password`='" . $password . "'");
    $serviceNum = $serviceResult->num_rows;

    if ($serviceNum > 0) {
        $serviceData = $serviceResult->fetch_assoc();

        $_SESSION["service"] = $serviceData;
        echo "success";
    } else {
        echo "Invalid email or password";
    }
}
