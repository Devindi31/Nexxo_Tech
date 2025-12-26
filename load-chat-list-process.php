<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {
    $service = $_SESSION["service"]["service_email"];

    $messageResult = Database::search("SELECT `message`.`customer`,MAX(`message`.`date_time`) AS latest_date_time FROM `message` WHERE `service` = '$service' GROUP BY `message`.`customer` ORDER BY `latest_date_time` DESC");

    $messageResultNum = $messageResult->num_rows;

    if ($messageResultNum > 0) {

        for ($m = 0; $m < $messageResultNum; $m++) {
            $customerData = $messageResult->fetch_assoc();
            $customerEmail = $customerData["customer"];

            $userResult = Database::search("SELECT * FROM `user` WHERE `email` = '$customerEmail'");
            $userData = $userResult->fetch_assoc();

?>

            <div class="col-12 chat-list rounded-4 mb-2" onclick="load_chat('<?php echo $customerEmail; ?>');">
                <div class="row d-flex align-items-center">
                    <div class="col-3">

                        <?php

                        if (!empty($userData["profile_image_path"])) {
                        ?>
                            <img src="<?php echo $userData["profile_image_path"]; ?>" class="chat-profile-image mt-2 mb-2 mx-2" alt="">
                        <?php
                        } else {
                        ?>
                            <img src="images/icon/user.png" class="chat-profile-image mt-2 mb-2 mx-2" alt="">
                        <?php
                        }

                        ?>


                    </div>
                    <div class="col-7">
                        <label for="" class="fw-bold fs-5"><?php echo $userData["fname"] . " " . $userData["lname"] ?></label><br>

                        <?php

                        $lastMessageResult = Database::search("SELECT SUBSTRING(`message_content`, 1, 22) AS `message_content` FROM `message` WHERE `customer`='$customerEmail' AND `service`='$service' ORDER BY `date_time` DESC LIMIT 1");

                        if ($lastMessageResult->num_rows > 0) {
                            $lastMessageData = $lastMessageResult->fetch_assoc();

                        ?>
                            <label for="" class="text-secondary" style="font-size: 14px;"><?php echo $lastMessageData["message_content"]; ?></label>
                        <?php
                        }

                        ?>

                    </div>
                    <div class="col-2">
                        <?php

                        $messageCountResult = Database::search("SELECT COUNT(*) AS `count` FROM `message` WHERE `customer` = '$customerEmail' AND `service` = '$service' AND `status`='0' AND `type`='1'");
                        if ($messageCountResult->num_rows > 0) {
                            $messageCount = $messageCountResult->fetch_assoc();

                            if ($messageCount["count"] != "0") {
                        ?>
                                <div class="rounded-5 msg-count-div text-center"><label for="" class="fw-bold text-white "><?php echo $messageCount["count"]; ?></label></div>
                        <?php
                            }
                        }

                        ?>
                    </div>

                </div>
            </div>

        <?php

        }
    } else {
        ?>

        <div class="row text-center">
            <div class="col-12">
                <img src="images/icon/Empty-Chat-List.png" class="col-12" alt="">
            </div>
        </div>
<?php
    }
}
