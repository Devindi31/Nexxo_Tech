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

    <title>Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row vh-100 d-flex align-items-center">

            <div class="col-12 col-md-5 vh-100 align-items-center d-flex col-lg-4 bg-white">

                <div class="row justify-content-center animate__animated animate__fadeIn" id="signInBox">

                    <div class="col-12 mt-3 mb-3 text-center">
                        <img src="images/Logo.png" class="col-4" alt="">
                    </div>

                    <a href="admin-signIn.php" class="fw-bold text-center admin-signIn fs-2 mb-4 text-decoration-none">Sign In</a>

                    <?php

                    $email = "";
                    $password = "";

                    if (isset($_COOKIE["email"])) {
                        $email = $_COOKIE["email"];
                    }

                    if (isset($_COOKIE["password"])) {
                        $password = $_COOKIE["password"];
                    }


                    ?>

                    <div class="col-11 mb-3 text-start">
                        <label class="form-label text-secondary" for="">Email</label>
                        <input class="form-control" type="text" id="signInEmail" value="<?php echo ($email); ?>" />
                    </div>
                    <div class="col-11 mb-3 text-start">
                        <label class="form-label text-secondary" for="">Password</label>
                        <input class="form-control" type="password" id="signInPassword" value="<?php echo ($password); ?>" />
                    </div>

                    <div class="col-11 mb-4">
                        <input class="form-check-input" type="checkbox" id="rememberMe" <?php if (isset($_COOKIE["email"])) {
                                                                                            echo ("checked");
                                                                                        } ?> />
                        <label class="form-check-label text-secondary" for="rememberMe">Keep me signed in</label>
                    </div>


                    <button class="btn btn-dark rounded-4 col-6 fw-bold" onclick="signIn();">Sign In</button>


                    <div class="col-11 text-center mb-3 mt-2">
                        <a href="forgot-password.php" target="_blank" class="text-secondary forgotten-password">Forgotten your password ?</a>
                    </div>

                    <div class="col-11 text-center mb-3">
                        <label for="">Don't have an account ? <a onclick="signInSignUpChange();" class="text-dark text-decoration-none fw-bold" style="cursor: pointer;"> Register Now Here</a></label>
                    </div>


                </div>


                <div class="row justify-content-center text-secondary animate__animated animate__fadeIn d-none" id="signUpBox">

                    <div class="col-12 mb-3 text-center">
                        <img src="images/Logo.png" class="col-4" alt="">
                    </div>

                    <div class="col-11 text-center">
                        <label class="fs-2 fw-bold mb-3 text-black mb-5" for="">Create a Account</label>
                    </div>


                    <div class="col-6 mb-3">
                        <label class="form-label" for="">First name</label>
                        <input class="form-control" type="text" id="fname" />
                    </div>
                    <div class="col-5 mb-3">
                        <label class="form-label" for="">Last name</label>
                        <input class="form-control" type="text" id="lname" />
                    </div>

                    <div class="col-11 mb-3">
                        <label class="form-label" for="">Email</label>
                        <input class="form-control" type="email" id="email" />
                    </div>

                    <div class="col-11 mb-3">
                        <label class="form-label" for="">Mobile</label>
                        <input class="form-control" type="text" id="mobile" />
                    </div>

                    <div class="col-11 mb-3">
                        <label class="form-label" for="">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" />
                            <a class="input-group-text" style="cursor: pointer;" onclick="createAccounNewPasswordShow();"><i id="newAccountShowPasswordIcon" class="bi bi-eye-slash"></i></a>
                        </div>
                    </div>

                    <div class="col-11 mb-3">
                        <label class="form-label" for="">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" />
                            <a class="input-group-text" style="cursor: pointer;" onclick="createAccounConfirmPasswordShow();"><i id="newAccountShowConfirmPasswordIcon" class="bi bi-eye-slash"></i></a>
                        </div>
                    </div>

                    <hr>

                    <div class="col-11 text-center">
                        <button class="btn btn-dark rounded-4 fw-bold col-7 col-lg-6" onclick="createAccount();">Create Account</button><br>
                        <label class="mt-2">If you have an account ? <a onclick="signInSignUpChange();" class="fw-bold text-dark text-decoration-none" style="cursor: pointer;">Sign In</a></label>
                    </div>

                </div>

            </div>

            <div class="col-md-7 col-lg-8 vh-100 d-none d-md-block d-lg-block sign-in-bg">
            </div>

        </div>
    </div>


    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>