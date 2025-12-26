<?php
include "connection.php";

$resetEmailOrMobile = $_POST["resetEmailOrMobile"];
$resetNewPassword = $_POST["resetNewPassword"];
$resetConfirmPassword = $_POST["resetConfirmPassword"];
$resetVerificationCode = $_POST["resetVerificationCode"];

if (empty($resetEmailOrMobile)) {
    echo ("Enter email address or mobile number");
} else if (empty($resetNewPassword)) {
    echo ("Create new password");
} else if (!preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$^", $resetNewPassword)) {
    echo ("Your password must contain at least eight characters, at least one capital letter, one lowercase letter, one number and one special character.");
} else if (empty($resetConfirmPassword)) {
    echo ("Please Comfirm your password");
} else if ($resetNewPassword != $resetConfirmPassword) {
    echo ("Your password and Confirm password do not match");
} else if (empty($resetVerificationCode)) {
    echo ("Enter verification code");
} else {

    $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $resetEmailOrMobile . "' OR `mobile`='" . $resetEmailOrMobile . "'");
    $numRows = $resultSet->num_rows;

    if ($numRows == 1) {
        $userData = $resultSet->fetch_assoc();

        if ($userData["verification_code"] == $resetVerificationCode) {

            Database::iud("UPDATE `user` SET `password`='" . $resetConfirmPassword . "', `verification_code`=NULL WHERE `email`='" . $userData["email"] . "'");
            echo ("Your password reset is successful.");
        } else {

            echo ("Incorrect verification code");
        }
    } else {

        echo ("An invalid email address or mobile phone number");
    }
}
