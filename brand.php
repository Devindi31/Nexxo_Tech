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

        $brandResult = Database::search("SELECT * FROM `brand` WHERE `brand_id`=" . $_GET["id"]);
        $brandNum = $brandResult->num_rows;

        if ($brandNum > 0) {
            $brandData = $brandResult->fetch_assoc();

        ?> <title><?php echo ($brandData["brand_name"]); ?> - Nexxo Tech</title>
    </head>

    <body>
        <div class="container-fluid animate__animated animate__fadeIn brand-background">
            <div class="row" style="backdrop-filter: blur(100px);">

                <div class="col-12" style="margin-top: 95px;">

                    <label for="" class="text-secondary fw-bold"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b><?php echo ($brandData["brand_name"]); ?></b></label>
                    <h1 class="fw-bold text-black text-center"><?php echo ($brandData["brand_name"]); ?></h1>

                    <div class="row justify-content-center">

                        <div class="col-12 col-lg-6">

                            <div class="input-group mb-3">
                                <input type="text" class="form-control bg-light" placeholder="Search Product..." style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;" id="brandSearchProductName" />

                                <button class="btn btn-dark" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="searchBrandProduct('<?php echo $brandData['brand_id']; ?>');"><i class="bi bi-search"></i></button>
                            </div>

                        </div>
                    </div>

                    <div class="row justify-content-center gap-2 mb-5 mt-4" id="loadBrandProducts">

                        <?php

                        $productResult = Database::search("SELECT * FROM `product` 
                        INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id`=`model_has_brand`.`id`
                        WHERE `brand_brand_id`= '" . $brandData["brand_id"] . "' AND `product`.`status_status_id`='1'");
                        $productNum = $productResult->num_rows;

                        if ($productNum > 0) {

                            for ($b = 0; $b < $productNum; $b++) {
                                $productData = $productResult->fetch_assoc();

                        ?>

                                <div class="rounded-4 device-card" style="width: 18rem;    height: 380px;">

                                    <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                                        <img src="<?php echo ($productData["product_image_path"]); ?>" class="col-9 device-image" alt="">
                                    </div>

                                    <hr>

                                    <div class="col-12 text-black">
                                        <label class="text-secondary" for=""><?php echo ($productData["title"]); ?></label>
                                        <h4 class="fw-bold">Rs. <?php echo number_format($productData["price"]); ?>.00</h4>
                                        <?php

                                        if ($productData["quantity"] != 0) {
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

                                        <button class="btn btn-dark fw-bold col-3 rounded-5" onclick="window.location='single-product-view.php?id=<?php echo ($productData['product_id']); ?>'">Buy</button>
                                        <a href="single-product-view.php?id=<?php echo ($productData["product_id"]); ?>" class="float-end me-2 mt-2 text-secondary">Learn more<i class="bi bi-chevron-double-right"></i></a>

                                    </div>

                                </div>

                            <?php
                            }
                        } else {

                            ?>

                            <div class="col-12 text-center animate__animated animate__fadeIn mt-5">
                                <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-1" alt="">
                                <h4 class="text-secondary fw-bold mt-3">This product is currently unavailable.</h4>
                            </div>

                        <?php

                        }


                        ?>

                    </div>
                </div>

                <?php include "footer.php"; ?>

            </div>
        </div>

        <script src="js/script.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
    </body>

    </html>


<?php

        } else {

            include "unauthorized-access.php";
        }
    } else {

        include "unauthorized-access.php";
    }
