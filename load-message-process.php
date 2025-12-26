<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];

    $serviceResult = Database::search("SELECT * FROM `service`");
    $serviceData =  $serviceResult->fetch_assoc();
    $service_email = $serviceData["service_email"];

    $messageResult = Database::search("SELECT * FROM `message` WHERE `service`='" . $service_email . "' AND `customer`='" . $email . "'");
    $messageNum = $messageResult->num_rows;

    if ($messageNum > 0) {

        for ($m = 0; $m < $messageNum; $m++) {

            $messageData = $messageResult->fetch_assoc();

            $date = date_create($messageData["date_time"]);
            $messageDateTime = date_format($date, "Y-M-d  H:i:s A");

            if ($messageData["type"] == "1") {
?>

                <div class="col-12 text-end">
                    <label class="customer-message mb-2 rounded-4 p-2 gap-2 text-start" style="padding:11px;"><?php echo $messageData["message_content"]; ?></label><br>
                </div>

            <?php
            } else if ($messageData["type"] == "2") {
            ?>

                <div class="col-12 me-auto mb-2">
                    <label class="service-message mb-2 rounded-4 p-2" style="padding:11px;"><?php echo $messageData["message_content"]; ?></label><br>
                </div>
                
        <?php

            }
        }
    } else {

        ?>

        <div class="col-12" style="margin-top: 200px;">
            <div class="row justify-content-center">
                <div class="col-11 text-center">
                    <img src="images/icon/Chat.png" class="col-8 col-md-4 col-lg-2" alt=""><br>
                    <h4 for="" class="fw-bold text-secondary mt-4 ">No message here yet . . .</h4>
                </div>
            </div>
        </div>


<?php

    }
} else {
    echo "login";
}

?>