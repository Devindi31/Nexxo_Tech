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

    <title>Update Product - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn bg-white">
        <div class="row justify-content-center">

            <?php

            include "connection.php";
            session_start();

            if (isset($_SESSION["service"])) {
                if (isset($_GET["id"])) {
                    $prductId = $_GET["id"];

                    $productResult = Database::search("SELECT * FROM `product` 
                    INNER JOIN `category` ON `product`.`category_category_id`=`category`.`category_id` 
                    INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id`=`model_has_brand`.`id` 
                    INNER JOIN `model` ON `model_has_brand`.`model_model_id`=`model`.`model_id` 
                    INNER JOIN `brand` ON `model_has_brand`.`brand_brand_id`=`brand`.`brand_id` 
                    INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` WHERE `product_id` = '$prductId'");

                    if ($productResult->num_rows > 0) {
                        $productData = $productResult->fetch_assoc();

            ?>

                        <div class="col-12 col-lg-10 ">
                            <div class="row justify-content mt-4">

                                <h1 class="fw-bold text-black mb-3 text-center">Update Product</h1>

                                <hr>

                                <div class="col-12 col-lg-6 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Title</label>
                                    <input type="text" class="form-control" value="<?php echo $productData["title"]; ?>" id="product-title" />
                                </div>

                                <div class="col-12 col-lg-6 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Model Name</label>
                                    <input type="text" class="form-control" disabled value="<?php echo $productData["model_name"]; ?>" />
                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Category</label>

                                    <select name="" id="" disabled class="form-select rounded-3">
                                        <option value=""><?php echo $productData["category_name"]; ?></option>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Brand</label>

                                    <select name="" id="" disabled class="form-select rounded-3">
                                        <option value=""><?php echo $productData["brand_name"]; ?></option>
                                    </select>
                                </div>



                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Condition</label>

                                    <select name="" id="" disabled class="form-select rounded-3">
                                        <option value=""><?php echo $productData["condition_name"]; ?></option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Product Description</label>
                                    <textarea name="" id="update-product-description" cols="30" rows="10" class="form-control"><?php echo $productData["description"]; ?></textarea>

                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Product Price</label>
                                    <input type="number" class="form-control" value="<?php echo $productData["price"]; ?>" id="update-product-price" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Quantity</label>
                                    <input type="number" class="form-control" value="<?php echo $productData["quantity"]; ?>" id="update-product-quantity" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Delivery Fee</label>
                                    <input type="number" class="form-control" value="<?php echo $productData["delivery_fee"]; ?>" id="update-product-delivaryFee" />
                                </div>


                                <div class="row g-4 mt-3">

                                    <!-- Product Image -->
                                     
                                    <div class="col-12 col-lg-6">
                                        <div class="shadow rounded-5 h-100 p-3">

                                            <div class="col-12 rounded-5 border-secondary">
                                                <div class="row d-flex justify-content-center align-items-center mb-3">

                                                    <div class="col-12 col-md-5 col-lg-6 text-center mt-3">
                                                        <?php
                                                        $imageResult = Database::search("SELECT * FROM `product_image` WHERE `product_product_id`='" . $productData["product_id"] . "'");
                                                        if ($imageResult->num_rows > 0) {
                                                            $imageData = $imageResult->fetch_assoc();
                                                        ?>
                                                            <img src="<?php echo $imageData["product_image_path"]; ?>" class="col-12 col-lg-6" id="preview-update-product-image"><br>
                                                        <?php } else { ?>
                                                            <img src="images/icon/Add-Image.png" class="col-12 col-lg-6" id="preview-update-product-image"><br>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="col-12 col-lg-6 mt-5">
                                                        <h4 class="fw-bold text-secondary mx-5">Follow</h4>
                                                        <label class="text-secondary mx-5">Image size : (1:1)</label><br>
                                                        <label class="text-secondary mx-5">Image Background : Transparent</label><br>
                                                        <label class="text-secondary mx-5">Image Quality : High Quality</label>

                                                        <input type="file" class="d-none" id="update-product-image" onchange="select_update_product_image();">
                                                        <label for="update-product-image" class="btn btn-dark rounded-4 mt-5 mb-3 mx-5 fw-bold">Select Product Image</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Background Image -->
                                    <div class="col-12 col-lg-6">
                                        <div class="shadow rounded-5 h-100 p-3">

                                            <div class="col-12 rounded-5 border-secondary">
                                                <div class="row d-flex justify-content-center align-items-center mb-3">

                                                    <div class="col-11 col-lg-6 text-center mt-3">
                                                        <img src="<?php echo $productData["background_image"]; ?>" class="col-12 col-md-5 col-lg-10 mb-3 rounded-1" id="preview-update-background-image"><br>
                                                    </div>

                                                    <div class="col-12 col-lg-6 mt-5">
                                                        <h4 class="fw-bold text-secondary mx-5">Follow</h4>
                                                        <label class="text-secondary mx-5">Image size : 1920x1080</label><br>
                                                        <label class="text-secondary mx-5">Image Quality : High Quality</label>

                                                        <input type="file" class="d-none" id="update-product-background-image" onchange="select_update_background_image();">
                                                        <label for="update-product-background-image" class="btn btn-dark rounded-4 mt-5 mb-3 mx-5 fw-bold">Select Background Image</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>



                                <div class="col-12 mt-5 mb-5 text-center">
                                    <button class="btn btn-dark rounded-5 fw-bold w-50 py-2 fs-6" onclick="update_product('<?php echo $productData['product_id']; ?>');"> Update Product</button>
                                </div>

                            </div>
                        </div>

                    <?php

                    } else {

                    ?>

                        <div class="col-12 text-center">
                            <div class="row justify-content-center align-items-center vh-100">
                                <div class="col-12">
                                    <img src="images/icon/404.png" class="col-8 col-md-4 col-lg-2" alt="">
                                    <h4 class="fw-bold text-secondary mt-5">Product is not available at the moment.</h4>
                                    <a href="manage-product.php" class="btn btn-dark rounded-5 shadow fw-bold mt-3">&nbsp;&nbsp;&nbsp;Return to Product Section&nbsp;&nbsp;&nbsp;</a>
                                </div>
                            </div>
                        </div>

                    <?php

                    }
                } else {
                    ?>

                    <div class="col-12">
                        <div class="row d-flex justify-content-center align-items-center vh-100">

                            <div class="col-12 text-center">

                                <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-2" alt="">
                                <h4 class="fw-bold text-secondary mt-5">Unauthorized Access.</h4>

                                <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

                            </div>

                        </div>
                    </div>

                <?php
                }
            } else {
                ?>

                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center vh-100">

                        <div class="col-12 text-center">

                            <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be signed in to manage the product.</h4>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>