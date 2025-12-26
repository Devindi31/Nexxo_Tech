<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/Logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="css/full.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>User Profile - Nexxo Tech</title>
</head>

<body>

    <div class="container-fluid animate__animated animate__fadeIn profile-background">
        <div class="row" style="min-height: 100vh;">

            <?php

            include "header.php";

            if (isset($_SESSION["NexxoTechUser"])) {

                $userResult = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["NexxoTechUser"]["email"] . "'");

                if ($userResult->num_rows > 0) {

                    $userData = $userResult->fetch_assoc();

                    if ($userData["status_status_id"] == 2) {
                        echo "<script>window.location='access-denied.php';</script>";
                    }

                    $addresResult = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["NexxoTechUser"]["email"] . "'");

                    $AddressLine = "";
                    $city = "";
                    $district = "";
                    $postalCode = "";

                    if ($addresResult->num_rows > 0) {
                        $addressData = $addresResult->fetch_assoc();

                        $AddressLine = $addressData["line_1"];
                        $city = $addressData["city"];
                        $district = $addressData["district"];
                        $postalCode = $addressData["postal_code"];
                    }



            ?>

                    <div class="col-12 mb-4" style="margin-top: 110px;">

                    <label for="" class="text-dark"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b>My Profile</b></label>
                        <h1 class="fw-bold text-center mb-3">My Profile</h1>

                        <div class="row justify-content-center border-0 p-tabs-container rounded-5" id="tab_example" style="background: transparent;">
                            <div class="p-tabs">
                                <button class="p-tab p-is-active fw-bold" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">Personal Details</button>
                                <button class="p-tab fw-bold" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;">Address Book</button>
                            </div>

                            <div class="p-panels rounded-4 glass col-lg-8" style="background: rgba(255,255,255,0.7);">

                                <!-- Personal Details -->
                                <div class="p-panel p-is-active">

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 text-center">
                                                <?php

                                                if (!empty($userData["profile_image_path"])) {


                                                ?>

                                                    <img src="<?php echo ($userData["profile_image_path"]); ?>" class="profile-page-image" alt="" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php

                                                } else {

                                                ?>
                                                    <img src="images/icon/user.png" class="profile-page-image" alt="" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php

                                                }

                                                ?>
                                                <div class="dropdown">

                                                    <input type="file" class="d-none" id="uploadProfileImage" onchange="updateProfileImage();">

                                                    <ul class="dropdown-menu shadow">
                                                        <li><a class="dropdown-item" style="cursor: pointer;"><label for="uploadProfileImage" style="cursor: pointer;"><i class="bi bi-cloud-arrow-up"></i> Upload Image</label></a></li>
                                                        <li><a class="dropdown-item text-danger" style="cursor: pointer;" onclick="removeProfileImage();"><i class="bi bi-trash3"></i> Remove Image</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <label for="" class="fs-5 fw-bold text-center"><?php echo $userData["fname"] . " " . $userData["lname"]; ?></label><br>
                                            <label for="" class="text-secondary text-center mb-4"><?php echo $userData["email"] ?></label>

                                            <div class="col-11 col-lg-6 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">First Name</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="userFirstName" value="<?php echo $userData["fname"]; ?>">
                                            </div>
                                            <div class="col-11 col-lg-6 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">Last Name</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="userLastName" value="<?php echo $userData["lname"]; ?>">
                                            </div>

                                            <div class="col-11 col-lg-12 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">Email Address</label>
                                                <input type="email" class="form-control text-secondary profile-input border-top-0 border-start-0 border-end-0" disabled value="<?php echo $userData["email"]; ?>">
                                            </div>

                                            <div class="col-11 col-lg-12 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">Registered Date</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" disabled value="<?php echo $userData["joined_date"]; ?>">
                                            </div>

                                        </div>
                                    </div>

                                    <button class="btn btn-dark rounded-4 float-end fw-bold" onclick="updateUserDetails();">Update</button>

                                </div>
                                <!-- Personal Details -->


                                <!-- Address Book -->
                                <div class="p-panel">

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 text-center">
                                                <?php

                                                if (!empty($userData["profile_image_path"])) {


                                                ?>
                                                    <img src="<?php echo ($userData["profile_image_path"]); ?>" class="profile-page-image" alt="" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php

                                                } else {

                                                ?>
                                                    <img src="images/icon/user.png" class="profile-page-image" alt="" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php

                                                }

                                                ?>

                                                <div class="dropdown">

                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" style="cursor: pointer;"><label for="uploadProfileImage" style="cursor: pointer;"><i class="bi bi-cloud-arrow-up"></i> Upload Image</label></a></li>
                                                        <li><a class="dropdown-item text-danger" style="cursor: pointer;" onclick="removeProfileImage();"><i class="bi bi-trash3"></i> Remove Image</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <label for="" class="fs-5 fw-bold text-center"><?php echo $userData["fname"] . " " . $userData["lname"]; ?></label><br>
                                            <label for="" class="text-secondary text-center mb-4"><?php echo $userData["email"]; ?></label>


                                            <div class="col-11 col-lg-12 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">Address Line</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="addressLine" value="<?php echo $AddressLine; ?>">
                                            </div>


                                            <div class="col-11 col-lg-6 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">City</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="city" value="<?php echo $city; ?>">
                                            </div>

                                            <div class="col-11 col-lg-6 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">District</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="district" value="<?php echo $district; ?>">
                                            </div>


                                            <div class="col-11 col-lg-6 mb-3">
                                                <label for="" class="text-secondary" style="font-size: 13px;">Postal Code</label>
                                                <input type="text" class="form-control profile-input border-top-0 border-start-0 border-end-0" id="postalCode" value="<?php echo $postalCode; ?>">
                                            </div>

                                        </div>
                                    </div>

                                    <button class="btn btn-dark rounded-4 float-end fw-bold" onclick="updateUserAdress();">Update</button>

                                </div>
                                <!-- Address Book -->


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
                                <h4 class="fw-bold text-secondary mt-5">Access Denied: User not found.</h4>
                                <a href="create-or-signIn.php" class="btn btn-dark fw-bold rounded-5 shadow mt-3 ">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                                <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

                            </div>

                        </div>
                    </div>

                <?php

                }
            } else {

                ?>

                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center vh-100">

                        <div class="col-12 text-center">

                            <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to view this page.</h4>
                            <a href="create-or-signIn.php" class="btn btn-dark fw-bold rounded-5 shadow mt-3 ">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

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
    <script src="js/tabs.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>