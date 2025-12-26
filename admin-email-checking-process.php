<?php

include "connection.php";

$email = $_POST["email"];

if (!empty($email)) {

    $serviceResult = Database::search("SELECT * FROM `service` WHERE `service_email`='" . $email . "'");
    $seviceNum = $serviceResult->num_rows;

    if ($seviceNum > 0) {
        echo "yes";
    } else {
        echo "no";
    }
} else {

    echo "Please enter service email";

}
