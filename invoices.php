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

    <title>Invoices - Nexxo Tech</title>
</head>

<body onload="loadInvoices();">

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

                <div class="col-12 mb-5" style="margin-top: 110px;">

                    <label for="" class="text-dark"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b>Invoices</b></label>
                    <h1 class="fw-bold text-center mb-4">Invoices</h1>

                    <div class="row justify-content-center">

                        <div class="col-11 col-lg-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="invoice-orderId-or-name" placeholder="Search by order ID or product name" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">
                                <input type="date" class="form-control" id="order-date">
                                <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="search_invoice();"><i class="bi bi-search"></i></button>
                            </div>
                        </div>

                        <div class="col-11 mb-2" style="min-height: 65vh;" id="load-invoices-section">


                        </div>

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
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view your invoices.</h4>
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
</body>

</html>