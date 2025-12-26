<?php

include "connection.php";
session_start();


if (isset($_SESSION["NexxoTechUser"])) {

    $orderIdOrName = $_GET["orderIdOrName"];

    $orderResults = Database::search("SELECT * FROM `order` INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id`
    WHERE `order_id` LIKE '%$orderIdOrName%' OR `title` LIKE '%$orderIdOrName%'");

    $orderNum = $orderResults->num_rows;

    if ($orderNum > 0) {

        for ($o = 0; $o < $orderNum; $o++) {
            $orderData = $orderResults->fetch_assoc();

            $date = date_create($orderData["date_time"]);
            $formatedDate = $date->format("Y-M-d");

?>

            <div class="rounded-4 shadow animate__animated animate__fadeIn" style="width: 30rem;min-height: 300px;">

                <div class="bg-light rounded-4 mt-3">
                    <label class="text-secondary mt-2" style="font-size: 14px;" for="">Date : <b class="text-dark"><?php echo $formatedDate; ?></b></label><br>
                    <label class="text-secondary" style="font-size: 14px;" for="">Order ID : <b class="text-dark"><?php echo $orderData["order_id"]; ?></b></label><br>
                </div>

                <hr>

                <div class="col-12">
                    <div class="row gap-2 justify-content-center align-items-center">

                        <div class="row col-7 col-lg-5 align-items-center justify-content-center">
                            <img src="<?php echo $orderData["product_image_path"]; ?>" alt="">
                        </div>

                        <div class="col-12 col-lg-6">

                            <div class="col-12 text-black">
                                <label class="text-secondary fw-bold" for=""><?php echo $orderData["title"]; ?></label><br>
                                <label class="text-secondary" style="font-size: 13px;" for="">Rs.
                                    <?php echo number_format($orderData["price"]); ?>.00 x
                                    <?php echo $orderData["qty"]; ?></label><br>
                                <label class="fw-bold text-black fs-5" for="">Rs.
                                    <?php echo number_format($orderData["price"] * $orderData["qty"]); ?>.00</label><br>
                            </div>

                            <?php

                            if ($orderData["status"] != "5") {
                            ?>
                                <label for="" class="mt-2 fw-bold" style="color: #facc15;">Incomplete</label>
                            <?php
                            } else {
                            ?>
                                <label for="" class="mt-2 fw-bold" style="color: #22c55e;">Complete</label>
                            <?php
                            }

                            ?>

                            <div class="col-12 mt-3 mb-4 text-end">

                                <a href="order-more-details.php?id=<?php echo $orderData["item_id"]; ?>" class="text-secondary">More Details<i class="bi bi-chevron-double-right"></i></a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php
        }
    } else {

        ?>

        <div class="col-12 text-center animate__animated animate__fadeIn mt-5">
            <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-1" alt="">
            <h4 class="text-secondary fw-bold mt-3">This product is currently unavailable. Please explore similar items.</h4>
        </div>

<?php



    }
} else {
    echo "login";
}
