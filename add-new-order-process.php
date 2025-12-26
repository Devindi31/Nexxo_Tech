<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_POST["email"];
    $product_id = $_POST["productId"];
    $product_color = $_POST["productColor"];
    $input_qty = $_POST["inputQty"];
    $orderId = $_POST["orderId"];
    $amount = $_POST["amount"];

    $productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$product_id'");

    if ($productResult->num_rows > 0) {

        $productData = $productResult->fetch_assoc();

        $currentQuantity = $productData["quantity"];
        $newQuantity = $currentQuantity - $input_qty;

        Database::iud("UPDATE `product` SET `quantity` = '$newQuantity' WHERE `product_id` = '" . $productData["product_id"] . "'");

        $date = new DateTime();
        $timeZoon = new DateTimeZone('Asia/Colombo');
        $date->setTimezone($timeZoon);
        $newDate = $date->format('Y-m-d H:i:s');

        Database::iud("INSERT INTO `order`(`user_email`, `product_product_id`, `color_color_id`, `order_id`, `qty`, `total`, `status`,`date_time`,`confirm_status`) 
        VALUES ('$email','$product_id','$product_color','$orderId','$input_qty','$amount','0','$newDate','0')");

        $oderResult = Database::search("SELECT * FROM `order` WHERE `order_id`='$orderId'");
        $orderNum = $oderResult->num_rows;
        if ($orderNum > 0) {

            $addressResult = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='$email'");
            if ($addressResult->num_rows > 0) {
                $addressData = $addressResult->fetch_assoc();

                $line_1 = $addressData["line_1"];
                $city = $addressData["city"];
                $district = $addressData["district"];
                $postal_code = $addressData["postal_code"];
            }

            for ($o = 0; $o < $orderNum; $o++) {
                $orderData = $oderResult->fetch_assoc();

                Database::iud("INSERT INTO `order_address` (`order_item_id`,`line_1`,`city`,`district`,`postal_code`) VALUES('" . $orderData["item_id"] . "','$line_1','$city','$district','$postal_code')");
            }
        } else {
            echo "Order Not Found";
        }

        echo "success";
    } else {

        echo "Product Not Found";
    }
} else {
    echo "login";
}
