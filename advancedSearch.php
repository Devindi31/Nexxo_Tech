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

    <title>Advanced Search</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn bg-white">
        <div class="row">

            <?php include "header.php";

            ?>

            <div class="col-12" style="margin-top: 110px;">

                <label for=""><a href="index.php" class="text-decoration-none text-dark fw-bold"><i class="bi bi-chevron-double-left"></i>Home</a> / <b class="text-secondary fw-bold">Advanced Search</b></label>
                <h1 class="fw-bold text-center">Advanced Search</h1>

                <div class="row justify-content-center">

                    <div class="col-12 bg- mb-2 mt-4">
                        <div class="row justify-content-center">

                            <div class="col-12 mt-3 mb-4">
                                <input type="text" id="ad-text" class="form-control" placeholder="Search by Product name" style="border-radius: 13px;">
                            </div>

                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <select name="" id="ad-category" class="form-select" style="border-radius: 13px;">
                                    <option value="0">Select Category</option>
                                    <?php

                                    $categoryResult = Database::search("SELECT * FROM `category`");
                                    $categoryResultNum = $categoryResult->num_rows;

                                    if ($categoryResultNum > 0) {

                                        for ($c = 0; $c < $categoryResultNum; $c++) {
                                            $categoryData = $categoryResult->fetch_assoc();
                                    ?>
                                            <option value="<?php echo $categoryData["category_id"] ?>"><?php echo $categoryData["category_name"] ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="0">No Category</option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <select name="" id="ad-brand" class="form-select" style="border-radius: 13px;">
                                    <option value="0">Select Brand</option>
                                    <?php

                                    $brandResult = Database::search("SELECT * FROM `brand` ORDER BY `brand_name` ASC");
                                    $brandResultNum = $brandResult->num_rows;

                                    if ($brandResultNum > 0) {

                                        for ($b = 0; $b < $brandResultNum; $b++) {
                                            $brandData = $brandResult->fetch_assoc();
                                    ?>
                                            <option value="<?php echo $brandData["brand_id"] ?>"><?php echo $brandData["brand_name"] ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="0">No Brand</option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <select name="" id="ad-color" class="form-select" style="border-radius: 13px;">
                                    <option value="0">Select Color</option>
                                    <?php

                                    $colorResult = Database::search("SELECT * FROM `color` ORDER BY `color_name` ASC");
                                    $colorResultNum = $colorResult->num_rows;

                                    if ($colorResultNum > 0) {

                                        for ($cl = 0; $cl < $colorResultNum; $cl++) {
                                            $colorData = $colorResult->fetch_assoc();
                                    ?>
                                            <option value="<?php echo $colorData["color_id"] ?>"><?php echo $colorData["color_name"] ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="0">No Color</option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <input type="text" class="form-control" id="price-from" placeholder="Price From ..." style="border-radius: 13px;">
                            </div>
                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <input type="text" class="form-control" id="price-to" placeholder="Price To ..." style="border-radius: 13px;">
                            </div>
                            <div class="col-12 col-md-4 col-lg-4  mb-3">
                                <select name="" id="sort-by" class="form-select" style="border-radius: 13px;">
                                    <option value="0">Sort By Price</option>
                                    <option value="1">High to Low</option>
                                    <option value="2">Low to High</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-dark fw-bold rounded-5" onclick="advanced_search();">Search</button>
                            </div>

                        </div>
                    </div>


                    <div class="col-12">
                        <div class="row justify-content-center">

                            <div class="col-12">
                                <hr>
                            </div>

                            <h4 class="fw-bold text-secondary mb-3 mt-3 text-center">Your Results</h4>

                            <div class="col-12 text-center mb-5 mt-3">
                                <div class="row justify-content-center gap-2" id="advanced-search-result">
                                    <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-2" alt="">
                                    <h4 class="fw-bold text-secondary">No search results yet. Please select filters to proceed.</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>