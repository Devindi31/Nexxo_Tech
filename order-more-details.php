<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/Logo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/full.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>Order More Details - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn" style="min-height: 100vh;">
        <div class="row vh-100" style="background: rgba(255,255,255,0.6);">

            <?php include "header.php";

            if (isset($_SESSION["NexxoTechUser"])) {
                $email = $_SESSION["NexxoTechUser"]["email"];

                if (isset($_GET["id"])) {

                    $itemId = $_GET["id"];

                    $orderDetails = Database::search("SELECT * FROM `order` 
                    INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
                    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` WHERE `item_id`='$itemId'");
                    $orderNum = $orderDetails->num_rows;


                    if ($orderNum > 0) {

                        $orderData = $orderDetails->fetch_assoc();

                        $date = date_create($orderData["date_time"]);
                        $formatedDate = date_format($date, "Y-M-d");

                        date_add($date, date_interval_create_from_date_string("8 days"));
                        $deliveryDate = date_format($date, "Y-M-d");

                        $addressResult = Database::search("SELECT * FROM `order_address` WHERE `order_item_id`='$itemId'");
                        $addressData = $addressResult->fetch_assoc();

            ?>

                        <div class="col-12" style="margin-top: 110px;">
                            <label for="" class="text-secondary fw-bold"><a href="my-order.php" class="text-decoration-none text-black"><i class="bi bi-chevron-double-left"></i>My Order</a> / <b>Order More Details</b></label>
                            <div class="row justify-content-center">



                                <div class="col-11 col-md-8 col-lg-11 main-content-div rounded-5" style="overflow: hidden;margin-bottom: 50px;backdrop-filter: blur(10px);">

                                    <div class="row align-items-center">

                                        <div class="col-12 col-lg-5 rounded-5" style="overflow: hidden;">
                                            <img src="<?php echo  $orderData["product_image_path"]; ?>" class="col-12" alt="">
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <label for="" class="fs-1 fw-bold mb-3 text-dark"><?php echo $orderData["title"]; ?></label><br>
                                            <label for="" class="fs-4 fw-bold text-secondary"><?php echo $_SESSION["NexxoTechUser"]["fname"] . " " . $_SESSION["NexxoTechUser"]["lname"]; ?></label><br>
                                            <label class="text-dark mt-4" style="font-size: 15px;" for="">Rs.
                                                <?php echo number_format($orderData["price"]); ?>.00 x
                                                <?php echo $orderData["qty"]; ?></label><br>
                                            <label for="" class="fs-3 fw-bold text-black">Rs.
                                                <?php echo number_format(($orderData["price"] * $orderData["qty"]) + $orderData["delivery_fee"]); ?>.00</label><br>

                                            <div class="col-12 text-start">
                                                <label class="text-dark mt-2" style="font-size: 13px;" for="">Date : <b class="text-dark"><?php echo $formatedDate; ?></b></label><br>
                                                <label class="text-dark" style="font-size: 13px;" for="">Order ID : <b class="text-dark"><?php echo $orderData["order_id"]; ?></b></label><br>
                                                <label class="text-dark" style="font-size: 13px;" for="">Quantity : <b class="text-dark"><?php echo $orderData["qty"]; ?></b></label><br>
                                                <label class="text-dark" style="font-size: 13px;" for="">Delivery Fee : <b class="text-dark">Rs.
                                                        <?php echo number_format($orderData["delivery_fee"]); ?>.00</b></label><br>
                                                <label class="text-dark mt-4 mb-4" style="font-size: 13px;" for="">Due date of
                                                    delivery : <b class="text-dark"><?php echo $deliveryDate; ?></b></label><br>
                                            </div>

                                            <div class="col-12 rounded-3" style="background: rgba(255,255,255,0.4);">
                                                <label class="fw-bold mt-3 mb-1 text-secondary" for="">Address</label><br>
                                                <label class="text-dark mb-1" style="font-size: 13px;" for=""><?php echo $addressData["line_1"]; ?>
                                                    <br><?php echo $addressData["district"] ?> - <?php echo $addressData["city"] ?>
                                                    - <?php echo $addressData["postal_code"] ?> <br> Sri
                                                    Lanka</label><br>
                                                <label for="" class="text-dark mb-3" style="font-size: 13px;"><?php echo $_SESSION["NexxoTechUser"]["mobile"]; ?></label><br>
                                            </div>



                                            <div class="col-12 mt-3 mb-2 mb-lg-4 rounded-3" style="background: rgba(255,255,255,0.4);">
                                                <label for="" class="fw-bold mt-3 text-secondary">Status</label><br>
                                                <label for="" class="mt-1 mb-3 text-dark" style="font-size: 13px;"><?php

                                                                                                                    if ($orderData["status"] == "0") {
                                                                                                                    ?>Pending<?php
                                                                                                                    } else if ($orderData["status"] == "1") {
                                                                ?>Confirm Order<?php
                                                                                                                    } else if ($orderData["status"] == "2") {
                                                                    ?>Packing<?php
                                                                                                                    } else if ($orderData["status"] == "3") {
                                                                    ?>Dispatch<?php
                                                                                                                    } else if ($orderData["status"] == "4") {
                                                                ?>Shipping<?php
                                                                                                                    } else if ($orderData["status"] == "5") {
                                                                ?>Delivered<?php
                                                                                                                    }

                                                                ?></label>

                                            </div>

                                            <?php

                                            if ($orderData["confirm_status"] == "0") {
                                            ?>
                                                <button class="btn btn-secondary fw-bold text-white rounded-5 mb-3 col-6 col-lg-5" onclick="confirmDelivery('<?php echo $orderData['item_id']; ?>');">Confirm Delivery</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-dark text-white fw-bold rounded-5 mb-3 col-6 col-lg-5">Confirmed</button>
                                            <?php
                                            }

                                            ?>

                                        </div>

                                    </div>

                                </div>



                            </div>

                        <?php
                    } else {

                        ?>

                            <div class="col-12">
                                <div class="row d-flex justify-content-center align-items-center vh-100" style="backdrop-filter: blur(15px);">
                                    <div class="col-12 text-center">
                                        <img src="images/icon/404.png" class="col-8 col-md-4 col-lg-2" alt="">
                                    <h4 class="fw-bold text-secondary mt-5">Product is not available at the moment.</h4>
                                        <a href="index.php" class="btn btn-dark rounded-5 shadow fw-bold mt-3">&nbsp;&nbsp;&nbsp;Return to
                                            Home&nbsp;&nbsp;&nbsp;</a>
                                    </div>
                                </div>
                            </div>

                        <?php

                    }
                } else {

                        ?>

                        <div class="col-12 text-center">
                            <div class="row d-flex justify-content-center align-items-center vh-100">
                                <div class="col-12">
                                    <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-2" alt="">
                                    <h4 class="fw-bold text-secondary mt-5">Unauthorized Access.</h4>

                                    <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy;
                                        <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>
                                </div>
                            </div>
                        </div>

                    <?php
                }
            } else {

                    ?>

                    <div class="col-12">
                        <div class="row d-flex justify-content-center align-items-center vh-100" style="backdrop-filter: blur(15px);">

                            <div class="col-12 text-center">

                                <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                                <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view this page.</h4>
                                <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow mt-3 fw-bold">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                                <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy;
                                    <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

                            </div>

                        </div>
                    </div>

                <?php

            }

                ?>

                        </div>
        </div>

        <script src="js/script.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script src="js/sweetalert2.js"></script>
</body>

</html>