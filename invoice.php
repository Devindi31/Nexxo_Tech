<?php
session_start();
include "connection.php";

if (isset($_SESSION["NexxoTechUser"])) {
    $email = $_SESSION["NexxoTechUser"]["email"];

    if (isset($_GET["id"])) {
        $orderId = $_GET["id"];

        $orderResult = Database::search("SELECT * FROM `order` 
        INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` WHERE `order_id` = '$orderId' AND `user_email` = '$email'");
        $orderNum = $orderResult->num_rows;

        if ($orderNum > 0) {

            $totalAmount = 0;
            $discountAmount = 0;
            $totalItems = 0;
            $subTotal = 0;


            for ($i = 0; $i < $orderNum; $i++) {
                $orderData1 = $orderResult->fetch_assoc();

                $totalItems++;
                $subTotal += $orderData1["total"] - $orderData1["delivery_fee"];
            }

            if ($totalItems >= 5) {

                $discountAmount = $subTotal / 100 * 5;
                $totalAmount = $subTotal - $discountAmount + $orderData1["delivery_fee"];
            } else {

                $totalAmount = $subTotal + $orderData1["delivery_fee"];
            }

?>

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

                <title>Invoice - Nexxo Tech</title>
            </head>

            <body>

                <div class="container-fluid animate__animated animate__fadeIn">
                    <div class="row justify-content-center mb-5" id="invoice-content">

                        <div class="mt-3 d-flex row justify-content-between align-items-center">

                            <div class="col-3 mt-2 mb-2 text-start">
                                <img src="images/Icon.png" class="profile-image" alt="">
                            </div>
                            <div class="col-9">
                                <label class="fw-bold fs-1 float-end text-dark" for="">Invoice</label>
                            </div>

                        </div>


                        <div class="mt-4 row justify-content-between">

                            <div class="col-6 text-start">

                                <?php

                                $userResult = Database::search("SELECT * FROM `order_address` 
                            INNER JOIN `order` ON `order_address`.`order_item_id`=`order`.`item_id` 
                            INNER JOIN `user` ON `order`.`user_email`=`user`.`email` WHERE `email`='" . $email . "' AND `order_id`='" . $orderId . "'");
                                $userData = $userResult->fetch_assoc();

                                ?>

                                <label for="" style="font-size: 14px;"><?php echo $userData["fname"] . " " . $userData["lname"]; ?></label><br>
                                <label for="" style="font-size: 14px;" class="text-pink"><?php echo $userData["email"]; ?></label><br>
                                <label for="" style="font-size: 14px;"><?php echo $userData["line_1"]; ?>,</label><br>
                                <label for="" style="font-size: 14px;"><?php echo $userData["district"] . " - " . $userData["city"]; ?></label><br>
                                <label for="" style="font-size: 14px;"><?php echo $userData["mobile"]; ?></label>
                            </div>

                            <div class="col-6 text-end">
                                <label for="" style="font-size: 14px;">Nexxo Tech</label><br>
                                <label for="" style="font-size: 14px;" class="text-pink">info@nexxotech.com</label><br>
                                <label for="" style="font-size: 14px;">Horana Road, Agalawatta, Sri Lanka</label><br>
                                <label for="" style="font-size: 14px;">+(94) 74 011 7716</label>
                            </div>

                        </div>

                        <div class="col-12 mt-4" style="color: #71717a;">
                            <label for="" class="fs-4 mx-2 fw-bold text-black">Order Details</label><br><br>

                            <?php

                            $date = date_create($orderData1["date_time"]);
                            $formatedDate = $date->format("Y-M-d");

                            ?>

                            <label for="" class="mx-2" style="font-size: 14px;">Order ID : <b><?php echo $orderId; ?></b></label><br>
                            <label for="" class="mx-2" style="font-size: 14px;">Order Date : <b><?php echo $formatedDate; ?></b></label><br>
                            <label for="" class="mx-2" style="font-size: 14px;">Total Items : <b><?php echo $totalItems; ?></b></label><br>
                            <label for="" class="mx-2 mt-3" style="font-size: 16px;">Transportation Charges : <b>Rs. <?php echo number_format($orderData1["delivery_fee"]) ?>.00</b></label><br>
                            <label for="" class="mx-2" style="font-size: 16px;">Sub Total : <b>Rs. <?php echo number_format($subTotal); ?>.00</b></label><br>
                            <label for="" class="mx-2 mt-4" style="font-size: 14px;">Discount (for 5 or more items - 5%) : <b>Rs. <?php echo number_format($discountAmount); ?>.00</b></label><br>

                            <div class="table-responsive mt-5">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Color</th>
                                            <th>Item Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Total price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        $orderResult2 = Database::search("SELECT * FROM `order` 
                                    INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` 
                                    INNER JOIN `color` ON `order`.`color_color_id` = `color`.`color_id`
                                    WHERE `order_id` = '$orderId' AND `user_email` = '$email'");
                                        $orderNum2 = $orderResult2->num_rows;

                                        $count = 0;
                                        for ($p = 0; $p < $orderNum2; $p++) {
                                            $orderData2 = $orderResult2->fetch_assoc();
                                            $count++;


                                        ?>

                                            <tr style="font-size: 15px;">
                                                <th class="text-secondary"><?php echo $count; ?></th>
                                                <td class="text-secondary"><?php echo $orderData2["title"]; ?></td>
                                                <td class="text-secondary"><?php echo $orderData2["color_name"]; ?></td>
                                                <td class="text-secondary">Rs. <?php echo number_format($orderData2["price"]); ?>.00</td>
                                                <td class="text-secondary"><?php echo $orderData2["qty"]; ?></td>
                                                <td class="text-secondary text-end">Rs. <?php echo number_format($orderData2["total"] - $orderData2["delivery_fee"]); ?>.00</td>
                                            </tr>

                                        <?php

                                        }

                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <label for="" class="mx-2 mt-3 text-dark fw-bold float-end" style="font-size: 20px;">Total Price : <b>Rs. <?php echo number_format($totalAmount); ?>.00</b></label><br>


                            <div style="font-size: 13px;" class="mt-4">
                                Thank you for choosing Nexxo Tech. <br>
                                Your order will be delivered within 5 days. <br>
                                We have successfully received your payment and the invoice is computer generated and valid without signature and seal.
                            </div>

                        </div>



                    </div>

                    <button class="btn btn-dark fw-bold mb-1 mt-5 float-end rounded-5" onclick="printinvoice();">Print Invoice</button>

                </div>

                <script src="js/script.js"></script>
                <script src="js/bootstrap.bundle.js"></script>
            </body>

            </html>

<?php

        } else {
            // include "unauthorized-access.php";
        }
    } else {
        include "unauthorized-access.php";
    }
} else {
    include "unauthorized-access.php";
}

?>