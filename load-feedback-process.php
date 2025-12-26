<?php

if (isset($_GET["id"])) {

    include "connection.php";
    $productId = $_GET["id"];

    $feedBackResult = Database::search("SELECT * FROM `feedback` 
    INNER JOIN `user` ON `feedback`.`user_email`=`user`.`email` 
    WHERE `product_product_id` = '$productId'");
    $feedBackNum = $feedBackResult->num_rows;

    if ($feedBackNum > 0) {
        for ($f = 0; $f < $feedBackNum; $f++) {
            $feedBackData = $feedBackResult->fetch_assoc();

?>
            <div class="col-12 rounded-2 bg-white border-bottom border-light border-3 mb-3 animate__animated animate__fadeInUp p-2">
                <label for="" class="text-secondary mx-2 float-end" style="font-size: 12px;">
                    <?php echo $feedBackData["date"]; ?>
                </label><br>

                <label class="fw-bold mx-2 mt-2 fs-5 name-label">
                    <?php echo $feedBackData["fname"] . " " . $feedBackData["lname"]; ?>
                </label><br>

                <label class="text-secondary mt-2 mx-2">
                    <?php echo $feedBackData["feedback_text"]; ?>
                </label>
            </div>

        <?php

        }
    } else {
        ?>

        <div class="col-12 rounded-2 mb-2 text-center">
            <img src="images/icon/No-Feedback.png" class="mt-5" height="150px" alt=""><br>
            <label for="" class=" mt-2 text-secondary fw-bold mx-4 fs-4 mt-4">No Feedback Yet.</label>
        </div>

<?php
    }
}


?>