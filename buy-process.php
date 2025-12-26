<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];
    $product_id = $_POST["productId"];
    $product_color = $_POST["productColor"];
    $input_qty = $_POST["inputQty"];

    $addressResult = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '$email'");
    $addressNum = $addressResult->num_rows;

    if ($addressNum > 0) {
        $addressData = $addressResult->fetch_assoc();

        $address = $addressData["line_1"].", ".$addressData["district"].", ".$addressData["city"].", ".$addressData["postal_code"];


        $ProductResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$product_id'");
        $productNum = $ProductResult->num_rows;

        if ($productNum > 0) {
            $productData = $ProductResult->fetch_assoc();

            if ($input_qty > $productData["quantity"] || $input_qty <= 0) {
                echo "Invalid input quantity";
            } else if ($product_color == 0) {
                echo "Please select a color, or our product color is not available.";
            } else {

                $order_id = rand(1000000000, 9999999999);

                $item = $productData["title"];
                $amount = ((int)$productData["price"] * (int)$input_qty) + (int)$productData["delivery_fee"];

                $fname = $_SESSION["NexxoTechUser"]["fname"];
                $lname = $_SESSION["NexxoTechUser"]["lname"];
                $mobile = $_SESSION["NexxoTechUser"]["mobile"];
                $uaddress = $address;
                $city = $addressData["city"];

                $merchant_id = "1233302";
                $merchant_secret = "MzkyODMyMDA1MzQxNzk5MDYzODAzODAxMjU1NDM4MzU2MzA1MDg0Nw==";
                $currency = "LKR";

                $hash = strtoupper(
                    md5(
                        $merchant_id .
                            $order_id .
                            number_format($amount, 2, '.', '') .
                            $currency .
                            strtoupper(md5($merchant_secret))
                    )
                );

                $array["orderId"] = $order_id;
                $array["item"] = $item;
                $array["amount"] = $amount;
                $array["fname"] = $fname;
                $array["lname"] = $lname;
                $array["mobile"] = $mobile;
                $array["address"] = $address;
                $array["city"] = $city;
                $array["email"] = $email;
                $array["merchantId"] = $merchant_id;
                $array["msecret"] = $merchant_secret;
                $array["currency"] = $currency;
                $array["hash"] = $hash;

                echo json_encode($array);
            }

        } else {

            echo "Product Not Found";
        }
    } else {
        echo "Please update your profile address book.";
    }
} else {
    echo "login";
}
