<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $userName = $_POST['searchUser'];

    $userResult = Database::search("SELECT * FROM `user` WHERE `fname` LIKE '%$userName%' OR `lname` LIKE '%$userName%'");
    $userResultNum = $userResult->num_rows;

    if ($userResultNum > 0) {

        for ($u = 0; $u < $userResultNum; $u++) {
            $userData = $userResult->fetch_assoc();

            $date = date_create($userData["joined_date"]);
            $formatedDate = date_format($date, 'Y M d');

            $orderCountResult = Database::search("SELECT COUNT(DISTINCT `order_id`) AS orderCount  FROM `order` WHERE `user_email`='" . $userData["email"] . "'");
            $orderCountData = $orderCountResult->fetch_assoc();

            $productCountResult = Database::search("SELECT  COUNT(`order_id`) AS productCount FROM `order` WHERE user_email ='" . $userData["email"] . "'");
            $productCountData = $productCountResult->fetch_assoc();

?>

            <div class="rounded-4 animate__animated animate__fadeIn" style="width: 20rem;height: 390px;background-color: rgba(235, 235, 235, 0.712);">

                <div class="text-center mt-2" style="height: 125px;">

                    <?php

                    if (isset($userData["profile_image_path"]) && !empty($userData["profile_image_path"])) {
                    ?>
                        <img src="<?php echo $userData["profile_image_path"]; ?>" class="users-image mt-2 mb-2" style="border-radius: 50%;" alt="">
                    <?php
                    } else {
                    ?>
                        <img src="images/icon/user.png" class="users-image mt-2 mb-2" style="border-radius: 50%;" alt="">
                    <?php
                    }

                    ?>
                </div>

                <hr>

                <div class="col-12 text-black">
                    <label class="brand-title fs-4 fw-bold" for=""><?php echo $userData["fname"] . " " . $userData["lname"] ?></label><br>
                    <label for="" class="text-dark" style="font-size: 15px;">Email : <b class="text-dark"><?php echo $userData["email"]; ?></b></label><br>
                    <label for="" class="text-secondary" style="font-size: 15px;">Mobile : <b><?php echo $userData["mobile"]; ?></b></label><br>
                    <label for="" class="text-secondary" style="font-size: 15px;">Total Orders : <b><?php echo $orderCountData["orderCount"]; ?></b></label><br>
                    <label for="" class="text-secondary" style="font-size: 15px;">Total Product : <b><?php echo $productCountData["productCount"]; ?></b></label><br>
                    <label for="" class="text-secondary" style="font-size: 15px;">Joined Date : <b><?php echo $formatedDate; ?></b></label>
                </div>

                <hr>


                <div class="col-12 mt-3 text-end">
                    <label class="p-form-switch">
                        <input type="checkbox" <?php
                                                if ($userData["status_status_id"] == 1) {
                                                ?>checked<?php
                                                        }
                                                            ?> onchange="change_user_status('<?php echo $userData['email'] ?>');" id="<?php echo $userData['email'] ?>" />
                        <span></span>
                    </label>
                </div>

            </div>


        <?php
        }
    } else {
        ?>

        <div class="col-12 text-center animate__animated animate__fadeIn">
            <img src="images/icon/Empty-Users.png" class="col-8 col-md-4 col-lg-1" alt="">
            <h4 class="text-secondary fw-bold mt-3">No matching users available.</h4>
        </div>

<?php
    }
}

?>