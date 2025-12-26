<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    if (isset($_GET["id"])) {

        $productId = $_GET["id"];

        $prductResult = Database::search("SELECT * FROM `product` WHERE `product_id` = '$productId'");
        if ($prductResult->num_rows > 0) {
            $productData = $prductResult->fetch_assoc();

            $colorResult = Database::search("SELECT * FROM `product_has_color` 
            INNER JOIN `color` ON `product_has_color`.`color_color_id`=`color`.`color_id` WHERE `product_product_id`='" . $productData["product_id"] . "'");
            $colorResultsNum = $colorResult->num_rows;

            if ($colorResultsNum > 0) {

                for ($c = 0; $c < $colorResultsNum; $c++) {
                    $colorData = $colorResult->fetch_assoc();

?>
                    <li><?php echo $colorData["color_name"] ?></li>
                <?php
                }
            } else {
                ?>
                <li>There is no color in this product</li>
<?php
            }
        } else {
            echo "Product Not Found";
        }
    } else {
        echo "Something went wrong";
    }
}

?>