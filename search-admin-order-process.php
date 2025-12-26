<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $search = $_GET["search"];

?>

    <div class="p-tabs-container bg-white border-0">
        <div class="p-tabs">
            <button class="p-tab p-is-active fw-bold" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">Incomplete Orders</button>
            <button class="p-tab fw-bold" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;">Complete Orders</button>
        </div>


        <div class="p-panels">

            <!-- Incomplete section -->
            <div class="p-panel p-is-active">

                <div class="col-12 mb-3">
                    <div class="row justify-content-center gap-4">

                        <?php

                        $orderResult_1 = Database::search("SELECT * FROM `order` 
                        INNER JOIN `user` ON `order`.`user_email`=`user`.`email` 
                        INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
                        WHERE `status`!='5' AND (`product`.`title` LIKE '%$search%' OR `user`.`fname` LIKE '%$search%' OR `user`.`lname` LIKE '%$search%')");
                        $orderResultsNum_1 = $orderResult_1->num_rows;

                        if ($orderResultsNum_1 > 0) {

                            for ($o = 0; $o < $orderResultsNum_1; $o++) {
                                $orderData_1 = $orderResult_1->fetch_assoc();

                                $date_1 = date_create($orderData_1["date_time"]);
                                $formatedDate_1 = date_format($date_1, "Y-M-d");

                                date_add($date_1, date_interval_create_from_date_string("8 days"));
                                $deliveryDate_1 = date_format($date_1, "Y-M-d");

                        ?>

                                <div class="rounded-4 animate__animated animate__fadeIn" style="width: 30rem; min-height: 300px;background-color: rgba(235, 235, 235, 0.712);">

                                    <div class="rounded-4 mt-3">
                                        <label class="text-secondary mt-2 float-end mx-2" style="font-size: 14px;" for=""><b>Date : <?php echo $formatedDate_1; ?></b></label><br>
                                        <label class="text-secondary mt-2 mx-2" style="font-size: 14px;" for="">Due date of delivery : <b><?php echo $deliveryDate_1; ?></b></label><br>
                                        <label class="text-secondary mx-2 mb-2" style="font-size: 14px;" for="">Order ID : <b><?php echo $orderData_1["order_id"]; ?></b></label><br>
                                    </div>

                                    <hr>

                                    <div class="col-12">
                                        <div class="row gap-2 justify-content-center align-items-center">

                                            <div class="row col-7 col-lg-5 align-items-center justify-content-center">
                                                <img src="<?php echo $orderData_1["product_image_path"]; ?>" alt="">
                                            </div>

                                            <div class="col-12 col-lg-6">

                                                <div class="col-12 text-black">
                                                    <label class="text-dark fs-4 fw-bold" for=""><?php echo $orderData_1["fname"] . " " . $orderData_1["lname"]; ?></label><br>
                                                    <label class="text-secondary" for="" style="font-size: 13.5px;"><?php echo $orderData_1["title"]; ?></label><br>
                                                    <label class="text-secondary" style="font-size: 12px;" for="">Rs. <?php echo number_format($orderData_1["price"]); ?>.00 x <?php echo $orderData_1["qty"]; ?></label><br>
                                                    <label class="fw-bold text-black fs-5" for="">Rs. <?php echo number_format($orderData_1["price"] * $orderData_1["qty"]); ?>.00</label><br>
                                                </div>

                                                <div class="col-12 mt-3 mb-4">

                                                    <a href="admin-order-more-details.php?id=<?php echo $orderData_1["item_id"]; ?>" class="text-secondary float-end">More Details<i class="bi bi-chevron-double-right"></i></a>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else {
                            ?>

                            <div class="col-12 animate__animated animate__fadeIn">
                                <div class="row justify-content-center">
                                    <div class="col-12  text-center mb-2 mt-4">
                                        <img src="images/icon/Empty-Order.png" class="col-8 col-md-4 col-lg-1" alt="">
                                        <h4 class="text-secondary fw-bold mt-3">There are no related incomplete orders.</h4>

                                    </div>
                                </div>
                            </div>

                        <?php
                        }

                        ?>
                    </div>
                </div>

            </div>
            <!-- Incomplete section -->

            <!-- Complete section -->
            <div class="p-panel">
                <div class="col-12">
                    <div class="row justify-content-center gap-4">

                    <?php

                        $orderResult_2 = Database::search("SELECT * FROM `order` 
                        INNER JOIN `user` ON `order`.`user_email`=`user`.`email` 
                        INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
                        WHERE `status`='5' AND (`product`.`title` LIKE '%$search%' OR `user`.`fname` LIKE '%$search%' OR `user`.`lname` LIKE '%$search%')");
                        $orderResultsNum_2 = $orderResult_2->num_rows;

                        if ($orderResultsNum_2 > 0) {

                            for ($o = 0; $o < $orderResultsNum_2; $o++) {
                                $orderData_2 = $orderResult_2->fetch_assoc();

                                $date_2 = date_create($orderData_2["date_time"]);
                                $formatedDate_2 = date_format($date_2, "Y-M-d");

                                date_add($date_2, date_interval_create_from_date_string("8 days"));
                                $deliveryDate_2 = date_format($date_2, "Y-M-d");

                        ?>

                                <div class="rounded-4 animate__animated animate__fadeIn" style="width: 30rem; min-height: 300px;background-color: rgba(235, 235, 235, 0.712);">

                                    <div class="rounded-4 mt-3">
                                        <label class="text-secondary mt-2 float-end mx-2" style="font-size: 14px;" for=""><b>Date : <?php echo $formatedDate_2; ?></b></label><br>
                                        <label class="text-secondary mt-2 mx-2" style="font-size: 14px;" for="">Due date of delivery : <b><?php echo $deliveryDate_2; ?></b></label><br>
                                        <label class="text-secondary mx-2 mb-2" style="font-size: 14px;" for="">Order ID : <b><?php echo $orderData_2["order_id"]; ?></b></label><br>
                                    </div>

                                    <hr>

                                    <div class="col-12">
                                        <div class="row gap-2 justify-content-center align-items-center">

                                            <div class="row col-7 col-lg-5 align-items-center justify-content-center">
                                                <img src="<?php echo $orderData_2["product_image_path"]; ?>" alt="">
                                            </div>

                                            <div class="col-12 col-lg-6">

                                                <div class="col-12 text-black">
                                                    <label class="text-dark fs-4 fw-bold" for=""><?php echo $orderData_2["fname"] . " " . $orderData_2["lname"]; ?></label><br>
                                                    <label class="text-secondary" for="" style="font-size: 13.5px;"><?php echo $orderData_2["title"]; ?></label><br>
                                                    <label class="text-secondary" style="font-size: 12px;" for="">Rs. <?php echo number_format($orderData_2["price"]); ?>.00 x <?php echo $orderData_2["qty"]; ?></label><br>
                                                    <label class="fw-bold text-black fs-5" for="">Rs. <?php echo number_format($orderData_2["price"] * $orderData_2["qty"]); ?>.00</label><br>
                                                </div>

                                                <div class="col-12 mt-3 mb-4">

                                                    <a href="admin-order-more-details.php?id=<?php echo $orderData_2["item_id"]; ?>" class="text-secondary float-end">More Details<i class="bi bi-chevron-double-right"></i></a>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else {
                            ?>

                            <div class="col-12 animate__animated animate__fadeIn">
                                <div class="row justify-content-center">
                                    <div class="col-12  text-center mb-2 mt-4">
                                        <img src="images/icon/Empty-Order.png" class="col-8 col-md-4 col-lg-1" alt="">
                                        <h4 class="text-secondary fw-bold mt-3">There are no related complete orders.</h4>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }

                        ?>

                    </div>
                </div>
            </div>
            <!-- Complete section -->
        </div>
    </div>

<?php

}

?>