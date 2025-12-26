<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/Logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Order - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn bg-light">
        <div class="row">

            <?php include "header.php";

            if (isset($_SESSION["NexxoTechUser"])) {

                $email = $_SESSION["NexxoTechUser"]["email"];

                $userResult = Database::search("SELECT * FROM `user` WHERE `email`='$email'");
                $userData = $userResult->fetch_assoc();

                if ($userData["status_status_id"] == 2) {
                    echo "<script>window.location='access-denied.php';</script>";
                }

            ?>

                <div class="col-12 mb-4" style="margin-top: 110px;">

                    <label for="" class="text-dark"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b>My Order</b></label>
                    <h1 class="fw-bold text-center mb-3">My Order</h1>

                    <div class="row justify-content-center">

                        <?php

                        $orderResult = Database::search("SELECT * FROM `order` 
                        INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` WHERE `user_email`='$email'");
                        $orderNum = $orderResult->num_rows;

                        if ($orderNum > 0) {

                        ?>

                            <div class="col-11 col-lg-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control " placeholder="Search by order ID or product name" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;" id="orderIdOrName">
                                    <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="findOrder();"><i class="bi bi-search"></i></button>
                                </div>
                            </div>

                            <div class="col-11 mt-5 mb-5">
                                <div class="row gap-2 justify-content-center" id="loard-order-section">

                                    <?php

                                    for ($o = 0; $o < $orderNum; $o++) {
                                        $orderData = $orderResult->fetch_assoc();

                                        $date = date_create($orderData["date_time"]);
                                        $formatedDate = $date->format("Y-M-d");

                                    ?>

                                        <div class="rounded-4 shadow" style="width: 30rem;min-height: 300px;">

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
                                                            <label class="text-secondary" style="font-size: 13px;" for="">Rs. <?php echo number_format($orderData["price"]); ?>.00 x <?php echo $orderData["qty"]; ?></label><br>
                                                            <label class="fw-bold text-black fs-5" for="">Rs. <?php echo number_format($orderData["price"] * $orderData["qty"]); ?>.00</label><br>
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

                                    ?>

                                </div>
                            </div>
                        <?php

                        } else {
                        ?>

                            <div class="col-12 text-center mb-5">

                                <img src="images/icon/Empty-Order.png" class="col-8 col-md-4 mt-5 mb-5 col-lg-1" alt="">
                                <h4 class="text-secondary fw-bold">None of your orders are available. You can continue shopping and get products.</h4>
                                <a href="index.php" class="btn btn-dark mt-3 fw-bold rounded-5 shadow">Go to Shopping</a>

                            </div>

                        <?php
                        }

                        ?>


                    </div>
                </div>

                <?php include "footer.php"; ?>

            <?php

            } else {

            ?>

                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center vh-100">

                        <div class="col-12 text-center">

                            <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view this page.</h4>
                            <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow mt-3 fw-bold">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                            <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

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