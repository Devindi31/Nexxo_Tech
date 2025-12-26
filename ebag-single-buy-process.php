<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    if (isset($_GET["ebagId"])) {

        $email = $_SESSION["NexxoTechUser"]["email"];
        $ebagId = $_GET["ebagId"];

        $addressResult = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '$email'");
        $addressNum = $addressResult->num_rows;

        if ($addressNum > 0) {

            $addressData = $addressResult->fetch_assoc();
            $address = $addressData["line_1"] . ", " . $addressData["district"] . ", " . $addressData["city"] . ", " . $addressData["postal_code"];

            $ebagResult = Database::search("SELECT * FROM `ebag` INNER JOIN `product` ON `ebag`.`product_product_id`=`product`.`product_id`  
            WHERE `ebag_id` = '$ebagId'");


            if ($ebagResult->num_rows > 0) {
                $ebagData = $ebagResult->fetch_assoc();

                $order_id = rand(1000000000, 9999999999);

                $item = $ebagData["title"];
                $amount = ((int)$ebagData["price"] * (int)$ebagData["ebag_quantity"]) + (int)$ebagData["delivery_fee"];

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
            } else {
                echo "eBag Product Not Found";
            }
        } else {
            echo "Please update your profile address book.";
        }
    } else {
        echo "eBag Product Not Found";
    }
} else {
    echo "login";
}
