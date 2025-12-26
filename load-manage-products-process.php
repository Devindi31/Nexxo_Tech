<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $productsResults = Database::search("SELECT * FROM `product` 
    INNER JOIN `product_image` ON `product`.`product_id` = `product_image`.`product_product_id` ORDER BY `datetime_added` DESC");
    $productsResultsNum = $productsResults->num_rows;

    if ($productsResultsNum > 0) {

        for ($p = 0; $p < $productsResultsNum; $p++) {
            $productsData = $productsResults->fetch_assoc();

?>

            <div class="rounded-4" style="width:20rem;height: 450px;background-color: rgba(235, 235, 235, 0.712);">

                <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                    <img src="<?php echo $productsData["product_image_path"]; ?>" class="col-9 device-image" alt="">
                </div>

                <hr>

                <div class="col-12 text-black">
                    <label class="text-secondary" for=""><?php echo $productsData["title"]; ?></label>
                    <h4 class="fw-bold">Rs. <?php echo number_format($productsData["price"]); ?>.00</h4>
                    <div class="text-end">
                        <label for=""><?php echo $productsData["quantity"]; ?> items available</label>
                    </div>
                </div>

                <hr>


                <div class="col-12 mt-3 ">

                    <label class="p-form-switch">
                        <input type="checkbox" <?php

                                                if ($productsData["status_status_id"] == 1) {
                                                ?> checked <?php
                                                        }

                                                            ?> onchange="change_product_status('<?php echo $productsData['product_id'] ?>');" id="<?php echo $productsData['product_id'] ?>" />
                        <span></span>
                    </label>

                    <a href="update-product.php?id=<?php echo $productsData['product_id'] ?>" class="float-end me-2 text-dark">Edit</a>

                </div>

                <hr>

                <div class="col-12 text-center">
                    <a class="text-decoration-none text-dark fw-bold" style="cursor: pointer;" onclick="add_color_modal('<?php echo $productsData['product_id'] ?>');">Add Product Color</a>
                </div>

            </div>

        <?php

        }
    } else { 

        ?>

        <div class="col-12 text-center">
            <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-1" alt="">
            <h4 class="text-secondary fw-bold mt-3">Products are currently unavailable.</h4>
        </div>

<?php

    }
}

?>