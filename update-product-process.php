<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $productId = $_POST['productId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $deliveryFee = $_POST['deliveryFee'];

    if (empty($title)) {
        echo "Enter a product title";
    } else if (strlen($title) > 100) {
        echo "Product title should be less than 100 characters";
    } else if (empty($description)) {
        echo "Enter a product description";
    } else if (strlen($description) > 400) {
        echo "Product description should be less than 400 characters";
    } else if (empty($price)) {
        echo "Enter a price";
    } else if (!preg_match("/^[0-9]+$/", $price)) {
        echo "Enter a valid price";
    } else if (empty($quantity)) {
        echo "Enter a product quantity";
    } else if (!preg_match("/^[0-9]+$/", $quantity)) {
        echo "Enter a valid quantity";
    } else if (empty($deliveryFee)) {
        echo "Enter a delivery fee";
    } else if (!preg_match("/^[0-9]+$/", $deliveryFee)) {
        echo "Enter a vali delivery fee";
    } else {

        $productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$productId'");

        if ($productResult->num_rows > 0) {
            $productData = $productResult->fetch_assoc();

            Database::iud("UPDATE `product` SET `price` = '$price', `quantity` = '$quantity', `description` = '$description', `title` = '$title', `delivery_fee` = '$deliveryFee' WHERE `product_id` = '$productId'");

            if (!empty($_FILES["backgroundImage"]["name"])) {

                $backgroundImage = $_FILES['backgroundImage'];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $background_file_extention = $backgroundImage["type"];

                if (!in_array($background_file_extention, $allowed_image_extentions)) {
                    echo ("Please select a valid file. Allowed file extensions are: .jpg, .jpeg, .png, .svg");
                } else {

                    $new_background_file_extention;

                    if ($background_file_extention == "image/jpg") {
                        $new_background_file_extention = ".jpg";
                    } else if ($background_file_extention == "image/jpeg") {
                        $new_background_file_extention = ".jpeg";
                    } else if ($background_file_extention == "image/png") {
                        $new_background_file_extention = ".png";
                    } else if ($background_file_extention == "image/svg+xml") {
                        $new_background_file_extention = ".svg";
                    }

                    if (isset($productData["background_image"]) && !empty($productData["background_image"])) {
                        unlink($productData["background_image"]);
                    }

                    $imageName = "images/background_images/" . $title . "_" . uniqid() . $new_background_file_extention;
                    move_uploaded_file($backgroundImage["tmp_name"], $imageName);

                    Database::iud("UPDATE `product` SET `background_image`='" . $imageName . "' WHERE `product_id`='" . $productData["product_id"] . "'");
                }
            }

            if (!empty($_FILES["productImage"]["name"])) {


                $productImage = $_FILES["productImage"];
                $imageResult = Database::search("SELECT * FROM `product_image` WHERE `product_product_id` = '$productId'");

                $allowed_image_extentions2 = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $product_file_extention = $productImage["type"];

                if (!in_array($product_file_extention, $allowed_image_extentions2)) {
                    echo ("Please select a valid file. Allowed file extensions are: .jpg, .jpeg, .png, .svg");
                } else {

                    $new_product_file_extention;

                    if ($product_file_extention == "image/jpg") {
                        $new_product_file_extention = ".jpg";
                    } else if ($product_file_extention == "image/jpeg") {
                        $new_product_file_extention = ".jpeg";
                    } else if ($product_file_extention == "image/png") {
                        $new_product_file_extention = ".png";
                    } else if ($product_file_extention == "image/svg+xml") {
                        $new_product_file_extention = ".svg";
                    }

                    $productImageName = "images/product/" . $title . "_" . uniqid() . $new_product_file_extention;

                    if ($imageResult->num_rows > 0) {
                        $imageData = $imageResult->fetch_assoc();

                        if (isset($imageData["product_image_path"]) && !empty($imageData["product_image_path"])) {
                            unlink($imageData["product_image_path"]);
                        }

                        Database::iud("UPDATE `product_image` SET `product_image_path`='" . $productImageName . "' WHERE `product_product_id`='" . $productData["product_id"] . "'");
                    } else {

                        Database::iud("INSERT INTO `product_image` (`product_image_path`, `product_product_id`) VALUES('$productImageName', '" . $productData["product_id"] . "')");
                    }

                    move_uploaded_file($productImage["tmp_name"], $productImageName);
                }
            }

            echo "success";
        } else {
            echo "Product not found";
        }
    }
}
