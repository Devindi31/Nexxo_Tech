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

    <title>Message - Nexxo Tech</title>

</head>

<body onload="loadMessage();">

    <div class="container-fluid chat-container animate__animated animate__fadeIn d-none d-md-none d-lg-block">
        <div class="row h-100">

            <?php include "connection.php";
            session_start();

            if (isset($_SESSION["NexxoTechUser"])) {
            ?>

                <div class="col-12 col-lg-3 customer-service d-flex flex-column align-items-center text-center">
                    <img src="images/Logo.png" class="mb-1" style="width:180px; height:180px;" alt="Logo">
                    <h4 class="fw-bold mt-3">Customer Service Center</h4>

                    <div class="cs-contact mt-3 text-start">
                        <label for="" class="mt-1" style="font-size: 16px;"><i class="bi bi-geo-alt-fill"></i> 123, Main Street, Colombo, Sri Lanka</label><br>
                        <label for="" class="mt-1" style="font-size: 16px;"><i class='bi bi-envelope-fill'></i> &nbsp;info@nexxotech.com</label><br>
                        <label for="" class="mt-1" style="font-size: 16px;"><i class="bi bi-telephone-fill"></i> +(94) 74 011 7716</label>
                    </div>

                    <div class="mt-auto">
                        <p class="text-muted" style="font-size: 13px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</p>
                    </div>
                </div>

                <div class="col-12 col-lg-9 chat-section d-flex flex-column">

                    <div class="col-12 d-flex align-items-start animate__animated animate__fadeIn mb-2">

                        <img src="images/Icon.png" class="me-3 mt-1 mx-3" style="width: 55px; height: 55px; border-radius: 50%;" alt="Nexxo Tech Logo">

                        <div class="col-8 d-flex flex-column">
                            <span class="fw-bold fs-4 text-dark mt-1">Nexxo Tech</span>
                            <span class="text-muted" style="font-size: 12px;">Customer Service</span>
                        </div>

                        <div class="col-3">
                            <a href="index.php" class="mt-2 text-dark float-end" style="font-size: 30px;"><i class="bi bi-house-fill"></i>
                            </a>
                        </div>

                    </div>

                    <div class="messages flex-grow-1 overflow-auto p-4" id="load-message-section"></div>

                    <div class="col-12 position-sticky bottom-0">
                        <div class="input-group p-3 border-top">
                            <input type="text" class="form-control border shadow" placeholder="Enter your message here . . ." id="input-text-message" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">
                            <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="send_message();"><i class="bi bi-arrow-up-circle-fill fs-5 "></i></button>
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
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be signed in to send messages.</h4>
                            <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow fw-bold mt-3">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

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
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>