<?php 

include "connection.php";
session_start();

if(isset($_SESSION["NexxoTechUser"])){
   
$productId = $_POST["productId"];
$action = $_POST["action"];
$productQuantity = $_POST["quantity"];

$ebagResult = Database::search("SELECT * FROM `ebag` WHERE `product_product_id`='$productId'");
$ebagNum = $ebagResult->num_rows;

if ($ebagNum > 0) {

    $ebagData = $ebagResult->fetch_assoc();
    $ebagId = $ebagData["ebag_id"];
    
    if ($action == "1") {
        
        if ($ebagData["ebag_quantity"] <= 1) {
            Database::iud("UPDATE `ebag` SET `ebag_quantity`='1' WHERE `ebag_id`=' $ebagId'");
            echo "success";
        }else{

            $newQuantity = $ebagData["ebag_quantity"] -1;
            Database::iud("UPDATE `ebag` SET `ebag_quantity`='$newQuantity' WHERE `ebag_id`=' $ebagId'");
            echo "success";
            
        }
        
    }

    if ($action == "2") {
        
        if ($ebagData["ebag_quantity"] >= $productQuantity) {
            Database::iud("UPDATE `ebag` SET `ebag_quantity`='$productQuantity' WHERE `ebag_id`=' $ebagId'");
            echo "success";
        }else{

            $newQuantity = $ebagData["ebag_quantity"] +1;
            Database::iud("UPDATE `ebag` SET `ebag_quantity`='$newQuantity' WHERE `ebag_id`=' $ebagId'");
            echo "success";

        }
        
    }
    
}else{
    echo "eBag Product Not Found";
}

}else{

    echo "login";

}

?>