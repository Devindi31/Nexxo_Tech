<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {
    $email = $_SESSION["NexxoTechUser"]["email"];

    $ebagResults = Database::search("SELECT * FROM `ebag` 
    INNER JOIN `product` ON `ebag`.`product_product_id`=`product`.`product_id` 
    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
    INNER JOIN `color` ON `ebag`.`color_color_id`=`color`.`color_id` WHERE `user_email`='$email' ORDER BY `ebag_id` DESC");

    $ebagNum = $ebagResults->num_rows;

    if ($ebagNum > 0) {

?>

        <div class="col-11 mt-4 mb-5">
            <div class="row justify-content-center gap-2">

                <?php

                $totalAmount = 0;
                $discountAmount = 0;
                $totalItems = 0;
                $subTotal = 0;
                $discountPercentage = 0;

                for ($e = 0; $e < $ebagNum; $e++) {
                    $ebagData = $ebagResults->fetch_assoc();
                    $totalItems++;
                    $subTotal += $ebagData["price"] * $ebagData["ebag_quantity"];
                ?>

                    <div class="rounded-4  shadow" style="width: 18rem; height: 530px;">

                        <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                            <img src="<?php echo $ebagData["product_image_path"]; ?>" class="col-9 device-image" alt="">
                        </div>

                        <hr>

                        <div class="col-12 text-black">

                            <label class="text-secondary fs-6" for=""><?php echo $ebagData["title"]; ?></label>
                            <h4 class="fw-bold fs-5">Rs. <?php echo number_format($ebagData["price"]); ?>.00</h4>
                            <div class="col-12">
                                <label for="">Quantity</label>&nbsp;&nbsp;&nbsp;
                                <a style="cursor: pointer;" class="fs-5"><i class="bi bi-dash-circle text-dark" onclick="eBagQuantityChange('<?php echo $ebagData['product_id']; ?>',1,'<?php echo $ebagData['quantity']; ?>');"></i></i></a>
                                <input type="text" style="width: 30px;" class="border-0 text-center bg-transparent" id="eBag-input-qty" readonly value="<?php echo $ebagData["ebag_quantity"]; ?>" />
                                <a style="cursor: pointer;" class="fs-5"><i class="bi bi-plus-circle text-dark" onclick="eBagQuantityChange('<?php echo $ebagData['product_id']; ?>',2,'<?php echo $ebagData['quantity']; ?>');"></i></a>
                            </div>
                            <label for="">Color : <b><?php echo $ebagData["color_name"]; ?></b></label>

                        </div>

                        <hr>
                        <div class="col-12">

                            <label for="" class="mt-1 text-secondary">The Total Amount : Rs. <?php echo number_format($ebagData["price"] * $ebagData["ebag_quantity"]); ?>.00</label>
                            <label for="" style="font-size: 12px;" class="text-secondary">(Without Transportation Charges)</label>

                        </div>

                        <hr>

                        <div class="col-12 mt-3 text-center">

                            <button class="btn btn-dark fw-bold col-3 rounded-5" onclick="eBagSingleBuy('<?php echo $ebagData['ebag_id']; ?>');">Buy</button>
                            <a href="single-product-view.php?id=<?php echo $ebagData["product_id"]; ?>" class="mx-2 text-secondary">Learn more<i class="bi bi-chevron-double-right"></i></a>
                            <button class="btn btn-danger col-3 rounded-5" onclick="delete_ebag('<?php echo $ebagData['ebag_id']; ?>');"><i class="bi bi-trash3"></i></button>

                        </div>

                    </div>

                <?php
                }

                $delivery_fee = $ebagData["delivery_fee"];

                if ($totalItems >= 5) {

                    $discountAmount = $subTotal / 100 * 5;
                    $totalAmount = $subTotal - $discountAmount + $delivery_fee;
                    $discountPercentage = 5;
                } else {

                    $totalAmount = $subTotal + $delivery_fee;
                }

                ?>

            </div>
        </div>

        <!-- CheckOut Box -->
        <div class="col-12 text-end fixed-bottom mb-1">
            <button class="btn btn-dark rounded-5" data-bs-toggle="offcanvas" data-bs-target="#ebagSummary" aria-controls="offcanvasScrolling"><i class="bi bi-arrows-angle-expand fs-5"></i></button>

            <div class="offcanvas offcanvas-start shadow" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="ebagSummary" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title fw-bold text-black mt-3" id="offcanvasScrollingLabel">Computed Summaries</h4>
                    <button type="button" class="btn-close mt-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <hr class="bg-dark">

                <div class="offcanvas-body text-start">

                    <div class="col-12">
                        <div class="row justify-content-center">

                            <div class="mx-5">
                                <label for="" class="fs-5 fw-bold mb-1 text-black">Pay With</label><br>
                                <label for="" style="font-size: 25px;"><i class='bx bxl-apple'></i></label>
                                <label for="" class="text-primary" style="font-size: 25px;"><i class='bx bxl-visa'></i></label>
                                <label for="" class="text-danger" style="font-size: 25px;"><i class='bx bxl-mastercard'></i></label>
                                <label for="" class="text-primary" style="font-size: 25px;"><i class='bx bxl-paypal'></i></label>
                            </div>


                            <div class="mt-3 mx-5">
                                <label for="" class="fs-5 fw-bold mb-1 text-black">Buyer Protection <i class="bi bi-shield-check text-success"></i></label><br>
                                <label for="" style="font-size: 14px;"> If the item is not delivered or is not as described, you will receive a full refund</label>
                            </div>

                            <div class="col-11 rounded-4 shadow mt-5" style="background-color: rgba(255, 255, 255, 0.1);">
                                <div class="col-12 mt-3">
                                    <label for="">Total Items</label>
                                    <label for="" class="float-end"><?php echo $totalItems; ?></label>
                                </div>
                                <div class="col-12">
                                    <label for="">Subtoal</label>
                                    <label for="" class="float-end">Rs. <?php echo number_format($subTotal); ?>.00</label>
                                </div>

                                <div class="col-12">
                                    <label for="">Discounts <label for="" class="text-secondary" style="font-size: 12px;">(5 or more Items)</label></label>
                                    <label for="" class="float-end">Rs . <?php echo number_format($discountAmount); ?>.00 <?php echo "(" . $discountPercentage . "%)" ?></label>
                                </div>

                                <div class="col-12">
                                    <label for="">Transportation Charges</label>
                                    <label for="" class="float-end">Rs . <?php echo number_format($delivery_fee); ?>.00</label>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="" class="fs-3 text-dark fw-bold">Total</label>
                                    <label for="" class="float-end fs-3 text-dark fw-bold">Rs. <?php echo number_format($totalAmount); ?>.00</label>
                                </div>

                                <hr>

                                <button class="btn btn-dark fw-bold col-12 rounded-5 mb-3" onclick="ebag_checkOut();">Checkout</button>

                            </div>



                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!-- CheckOut Box -->

    <?php
    } else {

    ?>

        <div class="col-12 text-center mb-5">

            <img src="images/icon/Empty-eBag.png" class="col-8 col-md-4 col-lg-1 mb-5 mt-5" alt="">
            <h4 class="text-secondary fw-bold">There are no products in your eBag. You can continue to shopping.</h4>
            <a href="index.php" class="btn btn-dark fw-bold mt-3 rounded-5 shadow">Go to Shopping</a>

        </div>

    <?php

    }
} else {

    ?>

    <div class="col-12">
        <div class="row d-flex justify-content-center align-items-center vh-100">

            <div class="col-12 text-center">

                <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view your eBag.</h4>
                <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow mt-3 fw-bold">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

            </div>

        </div>
    </div>

<?php

}

?>