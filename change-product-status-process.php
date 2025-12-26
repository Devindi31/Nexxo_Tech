<?php 

include "connection.php";
session_start();

if (isset($_SESSION["service"])) { 

$productId = $_POST['productId'];
$status = $_POST['status'];

$productResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$productId'");

if ($productResult->num_rows > 0) {
    $productData = $productResult->fetch_assoc();
    $product_id = $productData["product_id"];

    if ($status == "true") {
        Database::iud("UPDATE `product` SET `status_status_id` = '1' WHERE `product`.`product_id` = '$product_id'");
    }else{
        Database::iud("UPDATE `product` SET `status_status_id` = '2' WHERE `product`.`product_id` = '$product_id'");
    }

    echo "success";

    
}else{
    echo "Product Not Found";
}

}else{
    echo "login";
}

?>