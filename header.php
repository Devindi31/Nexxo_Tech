<div class="col-12 fixed-top glass animate__animated animate__fadeInDown">
    <div class="row justify-content-between align-items-center">

        <div class="col-3 col-md-4 col-lg-3 d-none d-md-block d-lg-block mt-2 mb-2">
            <img src="images/Icon.png" onclick="window.location='index.php'" class="mx-4" style="width: 70px;height: 70px;cursor: pointer;" alt="">
        </div>

        <div class="col-2 text-center">
            <label class="fs-1 fw-bold brand-title style-font" for="">NexxoTech</label>
        </div>

        <div class="col-10 col-md-4 col-lg-3 text-end mt-2 mb-2 d-none d-md-block d-lg-block">
            <?php

            include "connection.php";
            session_start();

            if (isset($_SESSION["NexxoTechUser"])) {

                $email = $_SESSION["NexxoTechUser"]["email"];

                $userResult = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
                $userData = $userResult->fetch_assoc();

                $serviceResult = Database::search("SELECT * FROM `service`");
                $serviceData =  $serviceResult->fetch_assoc();
                $service_email = $serviceData["service_email"];

                $messageResult = Database::search("SELECT * FROM `message` WHERE `service`='" . $service_email . "' AND `customer`='" . $email . "' AND `status`='0' AND `type`='2'");
                $messageCount = $messageResult->num_rows;

                if (!empty($userData["profile_image_path"])) {
            ?>
                    <img src="<?php echo ($userData["profile_image_path"]); ?>" class="profile-image me-4" style="width: 55px;height: 55px;" alt="" data-bs-toggle="offcanvas" aria-controls="staticBackdrop" data-bs-target="#mainMenu">
                <?php

                } else {

                ?>
                    <img src="images/icon/user.png" class="profile-image me-4" style="width: 55px;height: 55px;" alt="" data-bs-toggle="offcanvas" aria-controls="staticBackdrop" data-bs-target="#mainMenu">
                <?php

                }
            } else {

                ?>

                <a href="create-or-signIn.php" class="text-dark fw-bold">Sign In <i class="bi bi-chevron-double-right"></i></a>

            <?php

            }

            ?>
        </div>



        <div class="col-6 col-lg-3 text-end mt-2 mb-2 d-lg-none d-md-none d-block" style="cursor: pointer;">
            <img src="images/icon/Menu.svg" class="col-2" data-bs-toggle="offcanvas" aria-controls="staticBackdrop" data-bs-target="#mainMenu" alt="">
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="mainMenu">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <?php

        if (isset($_SESSION["NexxoTechUser"])) {

            $email = $_SESSION["NexxoTechUser"]["email"];

            $userResult = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
            $userData = $userResult->fetch_assoc();

            $serviceResult = Database::search("SELECT * FROM `service`");
            $serviceData =  $serviceResult->fetch_assoc();
            $service_email = $serviceData["service_email"];

            $messageResult = Database::search("SELECT * FROM `message` WHERE `service`='" . $service_email . "' AND `customer`='" . $email . "' AND `status`='0' AND `type`='2'");
            $messageCount = $messageResult->num_rows;

        ?>

            <div class="col-12 mobile-profile-div">
                <div class="row mx-2 me-2 align-items-center justify-content-center">
                    <div class="col-3 mt-2 mb-2">

                        <?php

                        if (!empty($userData["profile_image_path"])) {

                        ?>
                            <img src="<?php echo ($userData["profile_image_path"]); ?>" class="profile-image" alt="">
                        <?php

                        } else {

                        ?>
                            <img src="images/icon/user.png" class="profile-image" alt="">
                        <?php

                        }

                        ?>
                    </div>
                    <div class="col-9">
                        <label class="fw-bold fs-6 style-font" for=""><?php echo $userData["fname"] . " " . $userData["lname"]; ?></label>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row justify-content-center">

                    <div class="col-11 mobile-link-div">
                        <div class="row gap-2">

                            <?php

                            if ($userData["status_status_id"] == 1) {
                            ?>

                                <a class="mx-3 mb-2 mt-3 text-decoration-none fw-bold text-dark" style="font-size: 19px;" href="user-profile.php"><i class="bi bi-person-fill"></i>&nbsp; My Account Profile</a>
                                <a class="mx-3 mb-2 text-decoration-none fw-bold text-dark" style="font-size: 19px;" href="my-order.php"><i class="bi bi-clipboard2-data-fill"></i>&nbsp; My Order</a>
                                <a class="mx-3 mb-2 text-decoration-none fw-bold text-dark" style="font-size: 19px;" href="ebag.php"><i class="bi bi-bag-fill"></i>&nbsp; eBag</a>
                                <a class="mx-3 mb-2 text-decoration-none fw-bold text-dark" style="font-size: 19px;" href="watchlist.php"><i class="bi bi-clipboard-heart-fill"></i>&nbsp; Watchlist</a>
                                <a class="mx-3 mb-2 text-decoration-none fw-bold text-dark" style="font-size: 19px;" href="invoices.php"><i class="bi bi-file-earmark-text-fill"></i>&nbsp; Invoices</a>
                                <a class="mx-3 mb-2 text-decoration-none fw-bold text-dark message-link" onclick="message_status_change();" href="message.php"><i class="bi bi-chat-dots-fill"></i>&nbsp; Message<span class="message-badge"><?php echo $messageCount; ?></span></a>


                            <?php
                            } else {
                            ?>

                                <div class="col-12 text-center">
                                    <img src="images/icon/Block.png" class="text-center" width="100px" alt=""><br>
                                    <label class="fw-bold text-secondary text-center" style="font-size: 13px;" for="">Your account is suspended.</label>
                                    <hr>
                                    <div class="row text-start">
                                        <a class="mx-3 text-decoration-none text-dark fs-6 mb-3" onclick="message_status_change();" href="message.php"><i class="bi bi-chat-dots-fill"></i> <b>Contact Service <?php echo "(" . $messageCount . ")" ?></b></a>
                                    </div>
                                </div>

                            <?php
                            }

                            ?>


                            <a class="mx-3 text-decoration-none fs-5 text-danger mb-3 fw-bold fixed-bottom" style="cursor: pointer;" onclick="logOut();"><i class="bi bi-door-open-fill"></i>&nbsp; Log Out</a>

                        </div>
                    </div>

                </div>
            </div>

        <?php

        } else {

        ?>

            <div class="col-12 mobile-profile-div">
                <div class="row mx-2 me-2 align-items-center justify-content-center">
                    <div class="col-3 mt-2 mb-2">
                        <img src="images/Icon.png" class="profile-image" alt="">
                    </div>
                    <div class="col-9">
                        <a href="create-or-signIn.php" class="text-dark fw-bold">Sign In <i class="bi bi-chevron-double-right"></i></a>
                    </div>
                </div>
            </div>

        <?php

        }

        ?>

    </div>
</div>