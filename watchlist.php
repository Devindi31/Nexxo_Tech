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

    <title>Watchlist - Nexxo Tech</title>
</head>


<body onload="loadWatchlist();">

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

                <div class="col-12" id="load-watchlist-section">

                </div>

                <?php include "footer.php"; ?>

            <?php

            } else {
            ?>

                 <div class="col-12">
                        <div class="row d-flex justify-content-center align-items-center vh-100">

                            <div class="col-12 text-center">

                                <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                                <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view your Watchlist.</h4>
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