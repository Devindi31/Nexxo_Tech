<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {
    $service = $_SESSION["service"]["service_email"];

    if (isset($_GET["customerEmail"])) {
        $customerEmail = $_GET["customerEmail"];

        $userResult = Database::search("SELECT * FROM `user` WHERE `email` = '$customerEmail'");
        if ($userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
?>

            <div class="col-12 d-none d-md-none d-lg-block align-items-center animate__animated animate__fadeIn" style="background: rgba(255,255,255,0.5); backdrop-filter: blur(10px);">

                <?php

                if (!empty($userData["profile_image_path"])) {
                ?>
                    <img src="<?php echo $userData["profile_image_path"]; ?>" class="mt-3 mb-2 chat-section-profile-image" alt="">
                <?php
                } else {
                ?>
                    <img src="images/icon/user.png" class="mt-2" style="width: 50px; height: 50px;" alt="">
                <?php
                }

                ?>
                <label class="mt-3 mx-3 fs-4 text-dark" for="">
                    <b><?php echo $userData["fname"] . " " . $userData["lname"]; ?></b>
                    <span class="text-muted" style="font-size: 13px;">(<?php echo $userData["email"]; ?>)</span>
                </label>

            </div>

            <div class="col-12 message-div animate__animated animate__fadeIn gap-2">

                <div class="col-12 row justify-content-end mt-2 mb-3">

                    <?php

                    $messageResult = Database::search("SELECT * FROM `message` WHERE `customer`='$customerEmail' AND `service`='$service'");
                    $messageResultsNum = $messageResult->num_rows;

                    if ($messageResultsNum > 0) {

                        for ($m = 0; $m < $messageResultsNum; $m++) {
                            $messageData = $messageResult->fetch_assoc();

                            if ($messageData["type"] == "1") {
                    ?>
                                <div class="col-12 me-auto mb-2">
                                    <label class="admin-customer-message rounded-4"><?php echo $messageData["message_content"]; ?></label><br>
                                </div>

                            <?php
                            } else if ($messageData["type"] == "2") {
                            ?>
                                <div class="col-12 text-end">
                                    <label class="admin-service-message mb-2 text-start rounded-4"><?php echo $messageData["message_content"]; ?></label><br>
                                </div>
                        <?php
                            }
                        }
                    } else {
                        ?>

                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-8 text-center">
                                    <img src="images/icon/Chat.png" class="col-8 col-md-5 col-lg-10 mt-2" alt=""><br>
                                    <label for="" class="fw-bold fs-3 text-secondary mt-5 ">No message here yet . . .</label>
                                </div>
                            </div>
                        </div>

                    <?php
                    }

                    ?>
                </div>
            </div>

            <div class="col-12 position-sticky bottom-0">
                <div class="input-group p-3 border-top" style="background: rgb(255, 255, 255);">
                    <input type="text" class="form-control border shadow" placeholder="Type your message here . . ." id="admin-send-message" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">
                    <button class="btn btn-dark" type="button" onclick="admin_send_message('<?php echo $customerEmail; ?>');" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;"><i class="bi bi-arrow-up-circle-fill fs-5" style="color: #ffffffff;"></i></button>
                </div>
            </div>


<?php
        } else {
            echo "Customer not found";
        }
    } else {
        echo "Something went wrong";
    }
}
