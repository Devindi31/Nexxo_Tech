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

    <title>Admin - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn admin-signin-bg">
        <div class="row vh-100 d-flex justify-content-center align-items-center" style="backdrop-filter: blur(30px);">

            <div class="col-12 col-md-8 col-lg-4 rounded-5" style="background-color: rgba(255,255,255,0.1);">

                <div class="row justify-content-center animate__animated animate__fadeIn">

                    <div class="col-12 mt-3 mb-3 text-center">
                        <img src="images/Logo.png" class="col-4" alt="">
                    </div>

                    <h2 class="fw-bold text-center text-black">Admin Sign In</h2>

                    <div class="col-11 mb-3 text-start">
                        <label class="form-label text-black " for="">Email</label>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter Service Email" id="admin-signIn-email">
                            <button class="btn btn-light" style="border-color: gainsboro;" onclick="checking_email();"><i class="bi bi-arrow-right-circle fs-5 brand-title"></i></button>
                        </div>
                    </div>

                    <div class="col-12 d-none animate__animated animate__fadeIn" id="admin-signIn-password-div">
                        <div class="row justify-content-center">

                            <div class="col-11 mb-3 text-start">
                                <label class="form-label text-black" for="">Password</label>
                                <input class="form-control" type="password" id="admin-signIn-password" placeholder="Enter Password"/>
                            </div>

                            <hr>

                            <button class="btn btn-dark fw-bold rounded-5 col-6 mb-3" onclick="admin_signIn();">Next</button>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>