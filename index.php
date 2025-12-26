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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <title>Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row justify-content-center">

            <?php include "header.php"; ?>

            <div class="col-12 container bg-white">
                <div class="row d-flex justify-content-center align-items-center">

                    <div class="col-12" style="margin-top: 110px;">
                        <div class="row justify-content-center">

                            <div class="col-12 col-lg-5">

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search Product..." style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;" id="basicSearchProductName" />

                                    <select class="form-select" name="" id="basicSearchProductCategory">
                                        <option value="0">Select Category</option>

                                        <?php

                                        $categoryResult = Database::search("SELECT * FROM `category`");
                                        $numRows1 = $categoryResult->num_rows;

                                        for ($c = 0; $c < $numRows1; $c++) {
                                            $categoryData = $categoryResult->fetch_assoc();

                                        ?>

                                            <option value="<?php echo ($categoryData["category_id"]); ?>">
                                                <?php echo ($categoryData["category_name"]); ?></option>

                                        <?php
                                        }

                                        ?>

                                    </select>

                                    <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="basicSearch();"><i class="bi bi-search"></i></button>
                                </div>

                            </div>

                            <div class="col-lg-5 mb-3">
                                <a href="advancedSearch.php" class="btn btn-dark rounded-5 float-end fw-bold">Advanced Search</a>
                                <a href="" class="btn btn-dark rounded-5" data-bs-toggle="dropdown" aria-expanded="true"><i class="bi bi-columns-gap text-white"></i></a>

                                <div class="dropdown">
                                    <ul class="dropdown-menu shadow">

                                        <?php

                                        $categoryResult2 = Database::search("SELECT * FROM `category`");
                                        $numRows2 = $categoryResult2->num_rows;

                                        for ($c2 = 0; $c2 < $numRows2; $c2++) {
                                            $categoryData2 = $categoryResult2->fetch_assoc();

                                        ?>

                                            <li><a class="dropdown-item text-dark   " href="category.php?id=<?php echo ($categoryData2["category_id"]); ?>"><i class="<?php echo ($categoryData2["icon_name"]); ?>"></i>
                                                    &nbsp;&nbsp;<?php echo ($categoryData2["category_name"]); ?></a></li>

                                        <?php
                                        }

                                        ?>
                                    </ul>
                                </div>

                            </div>



                        </div>
                    </div>

                    <div class="col-12 mb-5 d-none basic-search-view-div" id="basic-search-div">

                    </div>

                    <?php

                    $latestProductResult = Database::search("SELECT * FROM `product` INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
                    WHERE `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 1");
                    $latestProductData = $latestProductResult->fetch_assoc();

                    if ($latestProductResult->num_rows != 0) {

                    ?>

                        <div class="col-11 col-md-8 bg-white col-lg-11 text-center main-content-div" style="overflow: hidden;margin-bottom: 50px;background-image: url('<?php echo ($latestProductData["background_image"]); ?>');">

                            <div class="row align-items-center" style="    backdrop-filter: blur(15px);background: rgb(255, 255, 255, 0.5);">

                                <div class="col-12 col-lg-5 " style="overflow: hidden;">
                                    <img src="<?php echo ($latestProductData['product_image_path']); ?>" class="col-12" alt="">
                                </div>

                                <div class="col-12 col-lg-5">
                                    <label for="" class="fs-1 fw-bold"><?php echo ($latestProductData['title']); ?></label>

                                    <div class="col-12" style="text-align: justify;">
                                        <p><?php echo ($latestProductData['description']); ?></p>
                                    </div>

                                    <div class="col-12 mb-5 mx-3">
                                        <div class="row align-items-center gap-1">
                                            <button class="btn btn-dark text-white fw-bold rounded-5 col-4 col-lg-2" onclick="window.location='single-product-view.php?id=<?php echo ($latestProductData['product_id']); ?>'">Buy</button>
                                            <button class="btn btn-outline-dark rounded-5 col-6 col-lg-5 text-decoration-underline" onclick="window.location='single-product-view.php?id=<?php echo ($latestProductData['product_id']); ?>'">Learn
                                                more <i class="bi bi-chevron-double-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    <?php

                    } else {

                    ?>

                        <div class="col-11 col-md-8 col-lg-11 text-center main-content-div rounded-5" style="overflow: hidden;margin-bottom: 50px;">

                            <div class="row align-items-center" style="backdrop-filter: blur(15px);background: rgb(255, 255, 255, 0.5);">

                                <div class="col-12 col-lg-5 rounded-5 bg-light" style="overflow: hidden;">
                                    <img src="images/Coming-Soon.png" class="col-12" alt="">
                                </div>

                                <div class="col-12 col-lg-5">
                                    <label for="" class="fs-1 fw-bold">Coming Soon</label>

                                    <div class="col-12" style="text-align: justify;">
                                        <p>We are thrilled to announce that an exciting new product is coming soon! Our team
                                            has been working tirelessly to bring you the latest innovation, designed to
                                            enhance your experience and meet your needs like never before. Stay tuned for
                                            more updates and get ready to explore the future with us. Be among the first to
                                            know by subscribing to our newsletter and following us on social media. Your
                                            anticipation and support mean the world to us!</p>
                                        <p>Stay tuned!</p>
                                    </div>

                                    <div class="col-12 mb-5 mx-3">
                                        <div class="row align-items-center gap-1">
                                            <button class="btn btn-dark rounded-5 col-4 col-lg-2 disabled">Buy</button>
                                            <button class="btn btn-outline-dark rounded-5 col-6 col-lg-5 text-decoration-underline disabled">Learn
                                                more <i class="bi bi-chevron-right"></i></button>
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

            <div class="col-12 bg-white">
                <div class="row justify-content-center mt-4 mb-5">
                    <h1 class="fw-bold text-center text-black mb-5">Popular Brand</h1>

                    <div class="col-11 col-lg-12 mb-4">

                        <div class="row justify-content-center gap-3 mt-3 mx-3 me-3 mb-3">


                            <section class="collection">
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">

                                        <?php

                                        $brandResult = Database::search("SELECT * FROM `brand`");
                                        $numRows3 = $brandResult->num_rows;

                                        for ($b = 0; $b < $numRows3; $b++) {

                                            $brandData = $brandResult->fetch_assoc();

                                        ?>

                                            <div class="rounded-3 swiper-slide d-flex justify-content-center align-items-center brand-link-dive" style="width: 150px;height: 150px;" onclick="window.location='brand.php?id=<?php echo ($brandData['brand_id']); ?>'">
                                                <img src="<?php echo ($brandData["icon_path"]); ?>" class="col-10 col-md-6 col-lg-10" alt="">
                                            </div>

                                        <?php


                                        }

                                        ?>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>

                </div>
            </div>



            <div class="col-12 mt-5 bg-white mb-5">
                <div class="row justify-content-center mt-5 gap-2 mb-4">

                    <h1 class="fw-bold text-center text-black">Latest Products in Categories</h1>

                    <div class="col-12">
                        <div class="row justify-content-center gap-4">

                            <?php

                            $categoryResult3 = Database::search("SELECT * FROM `category`");
                            $numRows4 = $categoryResult3->num_rows;

                            for ($c3 = 0; $c3 < $numRows4; $c3++) {

                                $categoryData3 = $categoryResult3->fetch_assoc();

                            ?>

                                <div class="divider d-flex align-items-center my-4 col-12 mb-2" style="margin-top: 10px;">
                                    <p class="text-center fw-bold mx-3 mb-0 fs-4"><?php echo ($categoryData3["category_name"]); ?></p>&nbsp;&nbsp;
                                </div>

                                <?php

                                $productResult = Database::search("SELECT * FROM `product` 
                                INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
                                WHERE `category_category_id`='" . $categoryData3["category_id"] . "' AND `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 5");
                                $ProductNumRows = $productResult->num_rows;

                                if ($ProductNumRows != 0) {


                                    for ($p = 0; $p < $ProductNumRows; $p++) {

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
                                                    <label for="" class="">In Stock</label>
                                                <?php
                                                } else {
                                                ?>
                                                    <label for="" class="text-danger ">Out of Stock</label>
                                                <?php
                                                }

                                                ?>

                                            </div>

                                            <div class="col-12 mt-3 ">

                                                <button class="btn btn-dark col-3 rounded-5 fw-bold" onclick="window.location='single-product-view.php?id=<?php echo ($productData['product_id']); ?>'">Buy</button>
                                                <a href="single-product-view.php?id=<?php echo ($productData["product_id"]); ?>" class="float-end me-2 mt-2 text-secondary">Learn more<i class="bi bi-chevron-double-right"></i></a>

                                            </div>

                                        </div>
                                  
                                    <?php
                                    }
                                    ?>
                                    <div></div>
                                <?php

                                } else {

                                ?>

                                    <div class="col-12 text-center mb-5">
                                        <img src="images/icon/Empty_Product.png" class="col-10 col-lg-1" alt="">
                                        <h4 for="" class="text-secondary fw-bold">No products yet.</h4>
                                    </div>

                            <?php

                                }
                            }

                            ?>

                        </div>
                    </div>

                </div>
            </div>

            <?PHP include "footer.php"; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>