<?php
include "connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$mobile = $_POST["mobile"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

if (empty($fname)) {
    echo ("Enter a first name.");
} else if (strlen($fname) > 32) {
    echo ("First name must be 32 characters or less.");
} else if (empty($lname)) {
    echo ("Enter a last name.");
} else if (strlen($lname) > 32) {
    echo ("Last name must be 32 characters or less.");
} else if (empty($email)) {
    echo ("Enter a your email address.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid email address.");
} else if (empty($mobile)) {
    echo ("Enter a mobile number.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid mobile number.");
} else if (strlen($mobile) != 10) {
    echo ("Mobile number should contain 10 characters");
} else if (empty($password)) {
    echo ("Create your password.");
} else if (!preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$^", $password)) {
    echo ("Your password must contain at least eight characters, at least one capital letter, one lowercase letter, one number and one special character.");
} else if (empty($confirmPassword)) {
    echo ("Please Comfirm your password");
} else if ($password != $confirmPassword) {
    echo ("Your password and Confirm password do not match");
} else {

    $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' OR `mobile`='" . $mobile . "'");
    $numRows = $resultSet->num_rows;

    if ($numRows > 0) {
        echo ("There is already an account with this email or phone number");
    } else {

        $dateTime = new DateTime();
        $timeZoon = new DateTimeZone("Asia/Colombo");
        $dateTime->setTimezone($timeZoon);
        $newDateTime = $dateTime->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user` (`email`,`fname`,`lname`,`password`,`mobile`,`joined_date`,`status_status_id`) 
        VALUES('" . $email . "','" . $fname . "','" . $lname . "','" . $confirmPassword . "','" . $mobile . "','" . $newDateTime . "','1')");

        echo ("success");
    }
}
