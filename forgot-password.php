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
    
    <title>Recover Your Account - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn bg-white">
        <div class="row justify-content-center">
            <?php include "header.php"; ?>


            <div class="col-12 container" id="resetPasswordSuccessViewDiv">
                <div class="row d-flex justify-content-center align-items-center" style="min-height: 800px;">

                    <div class="col-11 col-lg-6">
                        <h3 class="fw-bold text-black">Reset your password.</h3>

                        <p class="mt-5" style="font-size: 15px;">To proceed, enter the phone number or email address associated with your account.</p>

                        <div class="col-11 col-lg-4 mb-3 text-dark">
                            <label class="form-label fw-bold" for="">Email or Mobile Number</label>
                            <input class="form-control" type="text" id="resetEmailOrMobile"/>
                        </div>

                        <div class="d-none animate__animated animate__fadeInDown" id="resetPasswordHideDiv">
                            <div class="row mb-3">

                                <div class="col-11 col-lg-5 text-secondary">
                                    <label class="form-label" for="">New Password</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="password" id="reseNewPassword"/>
                                        <a class="input-group-text" style="cursor: pointer;" onclick="resetNewPasswordShow();"><i id="reseNewPasswordIcon"class="bi bi-eye-slash"></i></a>
                                    </div>
                                </div>

                                <div class="col-11 col-lg-5 text-secondary">
                                    <label class="form-label" for="">Confirm Password</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="password" id="resetConfirmPassword"/>
                                        <a class="input-group-text" style="cursor: pointer;" onclick="resetConfirmPasswordShow();"><i id="resetConfirmPasswordIcon" class="bi bi-eye-slash"></i></a>
                                    </div>
                                </div>

                            </div>

                            <div class="col-11 col-lg-4 mb-3 text-secondary">
                                <label class="form-label" for="">Verification Code</label>
                                <input class="form-control" type="text" id="resetVerificationCode"/>
                            </div>
                        </div>

                        <button class="btn btn-dark mt-3 rounded-5 fw-bold" id="sendVerificationCodeButton" onclick="sendVerificationCode();">Continue</button>
                        <button class="btn btn-dark mt-3 rounded-5 d-none" id="resetPasswordButton" onclick="resetPassword();"><b>Continue</b></button>
        
                    </div>

                </div>
            </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>