<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    if (isset($_GET["eBagId"])) {

        $email = $_SESSION["NexxoTechUser"]["email"];
        $eBagId = $_GET["eBagId"];

        $eBagResult = Database::search("SELECT * FROM `ebag` WHERE `ebag_id` = '$eBagId' AND `user_email`='$email'");

        if ($eBagResult->num_rows > 0) {
            $eBagData = $eBagResult->fetch_assoc();

            Database::iud("DELETE FROM `ebag` WHERE `ebag_id` = '".$eBagData["ebag_id"]."'");
            echo "success";
            
        }else{
            echo "eBag Product Not Found";
        }


    } else {
        echo "eBag Product Not Found";
    }
} else {
    echo "login";
}
