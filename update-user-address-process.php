<?php
include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];

    $addressLine = $_POST["addressLine"];
    $city = $_POST["city"];
    $district = $_POST["district"];
    $postalCode = $_POST["postalCode"];

    if (empty($addressLine)) {
        echo "Please Enter Address Line";
    } else if (strlen($addressLine) > 100) {
        echo "Address Line Must Be Less Than 100 Characters";
    } else if (empty($city)) {
        echo "Please Enter City";
    } else if (strlen($city) > 50) {
        echo "City Must Be Less Than 50 Characters";
    } else if (empty($district)) {
        echo "Please Enter District";
    } else if (strlen($district) > 45) {
        echo "District Must Be Less Than 45 Characters";
    } else if (empty($postalCode)) {
        echo "Please Enter Postal Code";
    } else if (!preg_match("^[0-9]+$^", $postalCode)) {
        echo "Postal Code Must Be Only Numbers";
    } else if (strlen($postalCode) > 10) {
        echo "Postal Code Must Be Less Than 10 Characters";
    } else {

        $addressResult = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $email . "'");

        if ($addressResult->num_rows > 0) {

            Database::iud("UPDATE `user_has_address` SET `line_1`='" . $addressLine . "', `city`='" . $city . "', `district`='" . $district . "', `postal_code`='" . $postalCode . "' WHERE `user_email`='" . $email . "'");
            echo "Address Updated Successfully";
        } else {

            Database::iud("INSERT INTO `user_has_address`(`user_email`, `line_1`, `city`, `district`, `postal_code`) VALUES ('" . $email . "','" . $addressLine . "','" . $city . "','" . $district . "','" . $postalCode . "')");
            echo "Address Added Successfully";
        }
    }
} else {
    echo "Please Login First";
}
