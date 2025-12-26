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

    <title>Admin Dashboard - Nexxo Tech</title>
</head>

<body onload="loadChart();" style="background-color: #fbfcf9;">

    <?php

    session_start();

    if (isset($_SESSION["service"])) {
        include "connection.php";
        include "admin-navigator.php";
    ?>

        <div class="mt-5" id="main-content">
            
            <img src="images/icon/Menu.png" class="toggle-btn" width="30px" alt="" onclick="toggleSidebar()">
            
            <div class="row justify-content-center gap-2 gap-lg-5">

                <div style="width: 18rem;padding: 20px;" class="shadow-sm bg-light rounded-4">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <img src="images/icon/Sales.png" height="50px" class="mt-3 mb-3" alt="">
                        </div>
                        <div class="col-10">
                            <label for="" class="text-secondary fw-bold mx-3">Total Sales</label><br>
                            <?php 
                            
                            $salesResult = Database::search("SELECT * FROM `order`");
                            $sales = $salesResult->num_rows;

                            ?>
                            <label for="" class="text-black mx-3 fs-4 fw-bold"><?php echo $sales;?></label>
                        </div>
                    </div>
                </div>
                <div style="width: 18rem;padding: 20px;" class="shadow-sm bg-light rounded-4">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <img src="images/icon/Income.png" height="50px" class="mt-3 mb-3" alt="">
                        </div>
                        <div class="col-10">
                            <label for="" class="text-secondary fw-bold mx-3">Total Income</label><br>
                            <?php

                            $incomeResult = Database::search("SELECT * FROM `order` INNER JOIN `product` ON `order`.`product_product_id` = `product`.`product_id`");
                            $incomNum = $incomeResult->num_rows;

                            $totalIncome = 0;
                            if ($incomNum > 0) {
                                
                                for ($i=0; $i < $incomNum; $i++) { 
                                    $incomeData = $incomeResult->fetch_assoc();

                                    $totalIncome += $incomeData["total"]-$incomeData["delivery_fee"];
                                }
                                
                            }

                            ?>
                            <label for="" class="text-black mx-3 fs-4 fw-bold">Rs. <?php echo number_format($totalIncome); ?>.00</label>
                        </div>
                    </div>
                </div>
                <div style="width: 18rem;padding: 20px;" class="shadow-sm bg-light rounded-4">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <img src="images/icon/product.png" height="50px" class="mt-3 mb-3" alt="">
                        </div>
                        <div class="col-10">
                            <label for="" class="text-secondary fw-bold mx-3">Total Product</label><br>
                            <?php

                            $productResult = Database::search("SELECT * FROM `product`");
                            $totalProduct = $productResult->num_rows;

                            ?>
                            <label for="" class="text-black mx-3 fs-4 fw-bold"><?php echo $totalProduct; ?></label>
                        </div>
                    </div>
                </div>
                <div style="width: 18rem;padding: 20px;" class="shadow-sm bg-light rounded-4">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <img src="images/icon/users.png" height="50px" class="mt-3 mb-3" alt="">
                        </div>
                        <div class="col-10">
                            <label for="" class="text-secondary fw-bold mx-3">Total Users</label><br>
                            <?php

                            $userResult = Database::search("SELECT * FROM `user`");
                            $userCount = $userResult->num_rows;

                            ?>
                            <label for="" class="text-black mx-3 fs-4 fw-bold"><?php echo $userCount; ?></label>
                        </div>
                    </div>
                </div>

                <div class="col-12 animate__animated animate__fadeIn mt-3">
                    <div class="row justify-content-around">


                        <div class="mt-3 rounded-4" style="width: 30rem;">
                            <h3 class="mt-2 mx-2 fw-bold">Daily Income</h3>
                            <canvas id="daily_income"></canvas>
                        </div>

                        <div class="mt-3 rounded-4" style="width: 30rem;">
                            <h3 class="mt-2 mx-2 fw-bold">Brand Products</h3>
                            <canvas id="brand_product"></canvas>
                        </div>


                    </div>

                </div>

            </div>
        </div>


    <?php
    } else {

    ?>

        <div class="col-12">
            <div class="row d-flex justify-content-center align-items-center vh-100">

                <div class="col-12 text-center">

                    <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                    <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view dashboard.</h4>
                    <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow mt-3 fw-bold">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                    <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

                </div>

            </div>
        </div>

    <?php

    }

    ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>