<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $productId =  $_POST["productId"];
    $color =  $_POST["color"];

    if ($color != 0) {
        $colorResult = Database::search("SELECT * FROM `product_has_color` WHERE `product_product_id`='$productId' AND `color_color_id`='$color'");
        if ($colorResult->num_rows > 0) {
            echo "This color already exists";
        } else {
            Database::iud("INSERT INTO `product_has_color` (`product_product_id`,`color_color_id`) VALUES('$productId','$color')");
            echo "success";
        }
    }else{
        echo "Please select a color";
    }

}
