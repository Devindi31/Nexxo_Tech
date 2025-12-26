<?php
include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    if (isset($_GET["colorName"])) {
        $colorName = $_GET["colorName"];

        $colorResults = Database::search("SELECT * FROM `color` WHERE `color_name` = '$colorName'");
        if ($colorResults->num_rows > 0) {
            echo "This Color already exists";
        } else {
            Database::iud("INSERT INTO `color` (`color_name`) VALUES('$colorName')");
            echo "success";
        }
    } else {
        echo "Something went wrong";
    }
}
