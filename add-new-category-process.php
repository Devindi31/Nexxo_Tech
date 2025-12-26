<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $categoryName = $_POST['categoryName'];
    $categoryIcon = $_POST['categoryIcon'];

    if (empty($categoryName)) {
        echo "Enter Category Name";
    } else if (empty($categoryIcon)) {
        echo "Enter Category Icon Name";
    }else{

        $categoryResult = Database::search("SELECT * FROM `category` WHERE `category_name` = '$categoryName'");
        $categoryResultNum = $categoryResult->num_rows;

        if ($categoryResultNum > 0) {

            echo "This category already exists.";
           
        }else{

            Database::iud("INSERT INTO `category` (`category_name`, `icon_name`) VALUES ('$categoryName', '$categoryIcon')");
            echo "success";
            
        }

    }
}
