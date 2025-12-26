<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $productName = $_POST['productName'];
    $categoryId = $_POST['categoryId'];
    $brandId = $_POST['brandId'];
    $modelName = $_POST['modelName'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $deliveryFee = $_POST['deliveryFee'];

    if (empty($productName)) {
        echo "Enter a product title";
    } else if (strlen($productName) > 100) {
        echo "Product title should be less than 100 characters";
    } else if ($categoryId == 0) {
        echo "Select a category";
    } else if ($brandId == 0) {
        echo "Select a brand";
    } else if (empty($modelName)) {
        echo "Enter a Model name";
    } else if (strlen($modelName) > 50) {
        echo "Model name should be less than 50 characters";
    } else if ($condition == 0) {
        echo "Select a condition";
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
    } else if (empty($_FILES["productImage"]["name"])) {
        echo "Select a product image";
    } else if (empty($_FILES["productBackgroundImage"]["name"])) {
        echo "Select a product background image";
    } else {

        $productImage = $_FILES["productImage"];
        $productBackgroundImage = $_FILES["productBackgroundImage"];

        $check_category_has_brand_result = Database::search("SELECT * FROM `category_has_brand` WHERE `category_category_id` = '$categoryId' AND `brand_brand_id` = '$brandId'");
        if ($check_category_has_brand_result->num_rows == 0) {

            Database::iud("INSERT INTO `category_has_brand`(`category_category_id`, `brand_brand_id`) VALUES ('$categoryId','$brandId')");
        }



        $modelResult = Database::search("SELECT * FROM `model` WHERE `model_name` = '$modelName'");
        $modelId = 0;
        if ($modelResult->num_rows > 0) {
            $modelData = $modelResult->fetch_assoc();
            $modelId = $modelData['model_id'];
        } else {
            Database::iud("INSERT INTO `model`(`model_name`) VALUES ('$modelName')");
            $modelResult2 = Database::search("SELECT * FROM `model` WHERE `model_name` = '$modelName'");
            $modelData2 = $modelResult2->fetch_assoc();
            $modelId = $modelData2['model_id'];
        }


        $model_has_brand_result = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id` = '$modelId' AND `brand_brand_id` = '$brandId'");
        $model_has_brandId = 0;
        if ($model_has_brand_result->num_rows > 0) {
            $model_has_brand_data = $model_has_brand_result->fetch_assoc();
            $model_has_brandId = $model_has_brand_data['id'];
        } else {
            Database::iud("INSERT INTO `model_has_brand`(`model_model_id`, `brand_brand_id`) VALUES ('$modelId','$brandId')");
            $model_has_brand_result2 = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id` = '$modelId' AND `brand_brand_id` = '$brandId'");
            $model_has_brand_data2 = $model_has_brand_result2->fetch_assoc();
            $model_has_brandId = $model_has_brand_data2['id'];
        }


        $product_result = Database::search("SELECT * FROM `product` WHERE `category_category_id` = '$categoryId' AND `model_has_brand_id`='$model_has_brandId'");
        if ($product_result->num_rows > 0) {
            echo "This product already exists";
        } else {

            $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
            $background_image_file_extention = $productBackgroundImage["type"];

            if (!in_array($background_image_file_extention, $allowed_image_extentions)) {
                echo ("Please select a valid file. Allowed file extensions are: .jpg, .jpeg, .png, .svg");
            } else {

                $new_background_image_file_extention;

                if ($background_image_file_extention == "image/jpg") {
                    $new_background_image_file_extention = ".jpg";
                } else if ($background_image_file_extention == "image/jpeg") {
                    $new_background_image_file_extention = ".jpeg";
                } else if ($background_image_file_extention == "image/png") {
                    $new_background_image_file_extention = ".png";
                } else if ($background_image_file_extention == "image/svg+xml") {
                    $new_background_image_file_extention = ".svg";
                }

                $imageName = "images/background_images/" . $productName . "_" . uniqid() . $new_background_image_file_extention;
                move_uploaded_file($productBackgroundImage["tmp_name"], $imageName);

                $date = new DateTime();
                $timeZoon = new DateTimeZone("Asia/Colombo");
                $date->setTimezone($timeZoon);
                $newDateTime = $date->format('Y-m-d H:i:s');

                Database::iud("INSERT INTO `product` (`price`,`quantity`,`description`,`title`,`datetime_added`,`delivery_fee`,`category_category_id`,`model_has_brand_id`,`condition_condition_id`,`status_status_id`,`background_image`) VALUES ('" . $price . "', '" . $quantity . "', '" . $description . "', '" . $productName . "', '" . $newDateTime . "', '" . $deliveryFee . "', '" . $categoryId . "', '" . $model_has_brandId . "', '" . $condition . "', '1' , '" . $imageName . "')");

                $product_result2 = Database::search("SELECT * FROM `product` WHERE `category_category_id` = '$categoryId' AND `model_has_brand_id`='$model_has_brandId'");
                if ($product_result2->num_rows > 0) {
                    $productData = $product_result2->fetch_assoc();
                    $productId = $productData['product_id'];

                    $allowed_image_extentions2 = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                    $product_image_file_extention = $productImage["type"];

                    if (!in_array($product_image_file_extention, $allowed_image_extentions2)) {
                        echo ("Please select a valid product image file. Allowed file extensions are: .jpg, .jpeg, .png, .svg");
                    } else {
                        $new_product_image_file_extention;

                        if ($product_image_file_extention == "image/jpg") {
                            $new_product_image_file_extention = ".jpg";
                        } else if ($product_image_file_extention == "image/jpeg") {
                            $new_product_image_file_extention = ".jpeg";
                        } else if ($product_image_file_extention == "image/png") {
                            $new_product_image_file_extention = ".png";
                        } else if ($product_image_file_extention == "image/svg+xml") {
                            $new_product_image_file_extention = ".svg";
                        }

                        $product_imageName = "images/product/" . $productName . "_" . uniqid() . "_" . $new_product_image_file_extention;
                        move_uploaded_file($productImage["tmp_name"], $product_imageName);

                        Database::iud("INSERT INTO `product_image` (`product_image_path`,`product_product_id`) VALUES ('$product_imageName','$productId')");
                        echo "success";
                    }
                } else {
                    "Product Not Added";
                }
            }
        }
    }
}
