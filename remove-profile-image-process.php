<?php 

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {
    $email = $_SESSION["NexxoTechUser"]["email"];

    $userResult = Database::search("SELECT * FROM `user` WHERE `email`='$email'");

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();

        if (isset($userData["profile_image_path"]) && !empty($userData["profile_image_path"])) {
            unlink($userData["profile_image_path"]);
            Database::iud("UPDATE `user` SET `profile_image_path`=NULL WHERE `email`='$email'");
            echo "success";
        }

    }else{
        echo "User Not Found";
    }


}else{
    echo "login";
}

?>