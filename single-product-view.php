<?php

if (isset($_GET["id"])) {

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

        <?php include "header.php";

        $productId = $_GET["id"];
        $productResult = Database::search("SELECT * FROM `product` 
        INNER JOIN `category` ON `product`.`category_category_id`=`category`.`category_id` 
        INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id`=`model_has_brand`.`id` 
        INNER JOIN `brand` ON `model_has_brand`.`brand_brand_id`=`brand`.`brand_id` 
        INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
        WHERE `product_id` = '$productId'");

        if ($productResult->num_rows > 0) {
            $productData = $productResult->fetch_assoc();

        ?>
    </head>
    <title><?php echo $productData["title"]; ?> - Nexxo Tech</title>

    <body onload="loadFeedback('<?php echo $_GET['id']; ?>');">

        <div class="container-fluid animate__animated animate__fadeIn">
            <div class="row">

                <div class="col-12 mb-5" style="margin-top: 110px;">

                    <label for="" class="text-dark"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <?php echo $productData["category_name"]; ?> /
                        <b><?php echo $productData["brand_name"]; ?></b></label>
                    <h1 class="fw-bold mt-3"><?php echo $productData["title"]; ?></h1>

                    <div class="row justify-content-center">

                        <div class="col-12 col-lg-12">
                            <label for="" class="mt-1 mb-2 text-secondary fs-3 fw-bold">Rs.
                                <?php echo number_format($productData["price"]); ?>.00</label>
                            <div class="row justify-content-center align-items-center gap-1">

                                <div class="col-12 col-md-5 col-lg-6 text-center mb-3 mb-lg-0">
                                    <img src="<?php echo $productData["product_image_path"]; ?>" class="col-8 col-md-10 col-lg-8" alt="">
                                </div>
                                <div class="col-11 col-md-6 mb-3 col-lg-5">

                                    <h5 class="fw-bold mt-3">Delivery Fee</i></h5>
                                    <label for="" class="text-secondary">Around Sri Lanka : Rs.
                                        <?php echo number_format($productData["delivery_fee"]); ?>.00</label><br>

                                    <hr>

                                    <h5 class="fw-bold">Service</h5>
                                    <label for="" class="text-secondary">Service Buyer Protection ensures that customers can purchase products and services with confidence. We protect buyers by providing secure payment processing, accurate product and service information, and reliable customer support. If a service does not meet the promised standards or issues occur during the transaction, buyers are supported through our dispute resolution and refund process, ensuring a safe and trustworthy experience.</label><br>

                                    <hr>

                                    <?php

                                    $colorResult = Database::search("SELECT * FROM `product_has_color` 
                                        INNER JOIN `color` ON `product_has_color`.`color_color_id`=`color`.`color_id` 
                                        WHERE `product_product_id` = '$productId'");

                                    $colorResultNum = $colorResult->num_rows;

                                    ?>
                                    <h5 class="fw-bold ">Color</h5>
                                    <select name="" id="productColor" class="form-select mb-3">
                                        <?php
                                        if ($colorResultNum > 0) {

                                        ?>
                                            <option value="0">Select Color</option>
                                            <?php
                                            for ($i = 0; $i < $colorResultNum; $i++) {
                                                $colorData = $colorResult->fetch_assoc();

                                            ?>
                                                <option value="<?php echo $colorData["color_id"] ?>">
                                                    <?php echo $colorData["color_name"] ?></option>
                                            <?php

                                            }

                                            ?>


                                        <?php

                                        } else {
                                        ?>
                                            <option value="0">No colors available</option>
                                        <?php
                                        }

                                        ?>
                                    </select>

                                    <?php


                                    if ($productData["quantity"] > 0) {
                                    ?>

                                        <h5 class="fw-bold">Quantity</h5>
                                        <input type="number" class="form-control" min="1" max="<?php echo $productData["quantity"]; ?>" value="1" onkeyup="checkQuantity('<?php echo $productData['quantity']; ?>')" id="quantityInput">
                                        <label for="" class="text-secondary mt-2 float-end mb-5"><?php echo $productData["quantity"]; ?> Pieces Available</label>

                                        <hr class="border-0 mb-5">

                                        <button class="btn btn-dark fw-bold rounded-5 mb-3" onclick="buy('<?php echo $productData['product_id']; ?>');">Buy Now</button>
                                        <button class="btn btn-secondary fw-bold rounded-5 mb-3" onclick="addToeBag('<?php echo $productData['product_id']; ?>');">&nbsp;&nbsp; Add to eBag
                                            &nbsp;&nbsp;</button>

                                    <?php
                                    } else {
                                    ?>
                                        <h5 class="fw-bold">Quantity</h5>
                                        <input type="text" class="form-control text-danger" readonly value="Sold Out">

                                        <hr>

                                        <button class="btn btn-dark fw-bold rounded-5 mb-3" disabled>Buy Now</button>
                                        <button class="btn btn-secondary fw-bold rounded-5 mb-3" disabled>&nbsp;&nbsp; Add to eBag
                                            &nbsp;&nbsp;</button>
                                        <?php
                                    }


                                    $watchlistCountResult = Database::search("SELECT * FROM `watchlist` WHERE `product_product_id`='" . $productData['product_id'] . "'");
                                    $watchlistCount = $watchlistCountResult->num_rows;

                                    if (isset($_SESSION["NexxoTechUser"])) {

                                        $watchlistResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["NexxoTechUser"]["email"] . "' AND `product_product_id`='" . $productData['product_id'] . "'");
                                        $watchlistNum = $watchlistResult->num_rows;

                                        if ($watchlistNum > 0) {
                                        ?>
                                            <button class="btn btn-danger fw-bold rounded-5 mb-3" onclick="addToWatchlist('<?php echo $productData['product_id']; ?>');">&nbsp;&nbsp;<i class="bi bi-clipboard-heart"></i> <?php echo "(" . $watchlistCount . ")" ?>&nbsp;&nbsp;</button>
                                        <?php

                                        } else {
                                        ?>
                                            <button class="btn btn-light fw-bold rounded-5 mb-3" onclick="addToWatchlist('<?php echo $productData['product_id']; ?>');">&nbsp;&nbsp;<i class="bi bi-clipboard-heart"></i> <?php echo "(" . $watchlistCount . ")" ?>&nbsp;&nbsp;</button>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <button class="btn btn-light fw-bold rounded-5 mb-3" onclick="addToWatchlist('<?php echo $productData['product_id']; ?>');">&nbsp;&nbsp;<i class="bi bi-clipboard-heart"></i> <?php echo "(" . $watchlistCount . ")" ?>&nbsp;&nbsp;</button>
                                    <?php
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">

                            <h4 class="fw-bold mt-5">Description</h4>
                            <p class="text-secondary"><?php echo $productData["description"]; ?></p>

                        </div>
                        <div class="col-12 col-lg-6 text-center mt-5">

                            <h4 class="fw-bold">Warranty</h4>
                            <p class="fs-6 fw-bold text-secondary">Regarding the Warranty Policy and Label</p>
                            <p class="text-secondary" style="font-size: 14px;">Please contact us within 7 days if there are
                                any quality issues with your goods, and we will assist you. Kindly preserve the original
                                warranty sticker. You will not be eligible for warranty service and we will not entertain
                                any claims for reimbursement if you rip the warranty sticker. If you disassemble or fix the
                                goods without getting authorization from our company, it will be considered man-made damage,
                                and we won't accept returns or complaints.</p>

                        </div>


                        <div class="col-12 mt-5 text-center">
                            <label for="" class="fw-bold text-black fs-4">Customer Reviews</label><br>

                            <label for="" class="mt-3 fw-bold brand-title style-font" style="font-size: 55px;">4.8</label><br>
                            <i class="bi bi-star-fill brand-title"></i>
                            <i class="bi bi-star-fill brand-title"></i>
                            <i class="bi bi-star-fill brand-title"></i>
                            <i class="bi bi-star-fill brand-title"></i>
                            <i class="bi bi-star-half brand-title"></i><br>
                            <label for="" class=" text-secondary">Every review is from a verified customers.</label>
                        </div>

                        <div class="col-12 mt-5">
                            <h4 class="fw-bold text-black text-center mb-3">Add Feedback</h4>
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-6">

                                    <div class="input-group mb-3 ">
                                        <input type="text" class="form-control" placeholder="Type Your Feedback" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;" id="feedback-text">

                                        <?php

                                        if (isset($_SESSION["NexxoTechUser"])) {
                                        ?>
                                            <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="addFeedback('<?php echo $productData['product_id'] ?>');"><i class="bi bi-arrow-up-circle-fill fs-5"></i></button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="create-or-signIn.php" class="btn btn-dark fw-bold" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;">Sign
                                                In</a>
                                        <?php
                                        }

                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 mt-3">

                            <div id="feedback-content" style="height: 350px; overflow-y: scroll; scrollbar-width: none; -ms-overflow-style: none;">

                                <!-- Feedbacks -->

                            </div>

                        </div>



                        <div class="col-12 mb-4 mt-5">
                            <div class="row justify-content-center text-center gap-2">


                                <?php

                                $relatedProductResult = Database::search("SELECT * FROM `product` 
                                    INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id`=`model_has_brand`.`id` 
                                    INNER JOIN `brand` ON `model_has_brand`.`brand_brand_id`=`brand`.`brand_id` 
                                    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id`
                                    WHERE `product_id` != '$productId' AND `brand`.`brand_id` = '" . $productData["brand_id"] . "'");

                                $relatedProductNum = $relatedProductResult->num_rows;

                                if ($relatedProductNum > 0) {
                                ?>
                                    <h3 class="mt-5 mb-4 fw-bold text-black">Related Product</h3>
                                    <?php
                                    for ($r = 0; $r < $relatedProductNum; $r++) {
                                        $relatedProductData = $relatedProductResult->fetch_assoc();

                                    ?>

                                        <div class="rounded-4 device-card" style="width: 18rem;    height: 380px;">

                                            <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                                                <img src="<?php echo ($relatedProductData["product_image_path"]); ?>" class="col-9 device-image" alt="">
                                            </div>

                                            <hr>

                                            <div class="col-12 text-black text-start">
                                                <label class="text-secondary" for=""><?php echo ($relatedProductData["title"]); ?></label>
                                                <h4 class="fw-bold">Rs.
                                                    <?php echo number_format($relatedProductData["price"]); ?>.00</h4>
                                                <?php

                                                if ($relatedProductData["quantity"] != 0) {
                                                ?>
                                                    <label for="">In Stock</label>
                                                <?php
                                                } else {
                                                ?>
                                                    <label for="" class="text-danger">Out of Stock</label>
                                                <?php
                                                }

                                                ?>

                                            </div>

                                            <div class="col-12 mt-3 ">

                                                <button class="btn btn-dark fw-bold col-3 float-start rounded-5" onclick="window.location='single-product-view.php?id=<?php echo ($relatedProductData['product_id']); ?>'">Buy</button>
                                                <a href="single-product-view.php?id=<?php echo ($relatedProductData["product_id"]); ?>" class="text-secondary float-end me-2 mt-2">Learn more<i class="bi bi-chevron-double-right"></i></a>

                                            </div>

                                        </div>

                                    <?php

                                    }
                                } else {
                                    ?>

                                    <div class="col-12 text-center">
                                        <img src="images/icon/Empty_Product.png" class="col-6 col-md-4 col-lg-2" alt=""><br>
                                        <label for="" class=" fw-bold text-secondary fs-1">No Relatetd Item</label>
                                    </div>

                                <?php

                                }

                                ?>

                            </div>
                        </div>

                    </div>
                </div>


                <?php include "footer.php"; ?>

            </div>
        </div>

        <script src="js/script.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script src="js/sweetalert2.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    </body>

    </html>

<?php
        } else {

?>
    </head>
    <title>Nexxo Tech</title>

    <body>

        <div class="container-fluid animate__animated animate__fadeIn bg-light">
            <div class="row d-flex justify-content-center align-items-center vh-100">

                <div class="col-12 text-center">

                    <img src="images/icon/404.png" class="col-8 col-md-4 col-lg-2" alt="">
                    <h4 class="fw-bold text-secondary mt-5">Product is not available at the moment.</h4>
                    <a href="index.php" class="btn btn-dark rounded-5 shadow fw-bold mt-3">&nbsp;&nbsp;&nbsp;Return to Home&nbsp;&nbsp;&nbsp;</a>

                </div>

            </div>
        </div>

        <script src="js/script.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
    </body>

    </html>

<?php

        }

?>




<?php

} else {
    include "unauthorized-access.php";
}

?>