<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];

    $watchlistResult = Database::search("SELECT * FROM `watchlist` 
    INNER JOIN `product` ON `watchlist`.`product_product_id`=`product`.`product_id`
    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
    INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` WHERE `user_email` = '$email'");
    $watchlistNum = $watchlistResult->num_rows;

    if ($watchlistNum > 0) {
?>

        <label for="" class="text-dark" style="margin-top: 110px;"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b>Watchlist</b></label>
        <h1 class="fw-bold text-center mb-5">Watchlist <label for="" class="text-secondary fs-6"><?php echo $watchlistNum; ?> item(s)</label></h1>

        <div class="row justify-content-center gap-2" style="min-height: 60vh;">

            <?php

            for ($w = 0; $w < $watchlistNum; $w++) {
                $watchlistData = $watchlistResult->fetch_assoc();

            ?>

                <div class="watchlist-card rounded-5 shadow" style=" width: 18rem;">
                    <div class="row align-items-center" style="height: 320px;">
                        <img src="<?php echo $watchlistData["product_image_path"]; ?>" class="watchlist-product-image" alt="">
                    </div>
                    <div class="watchlist-content rounded-5">
                        <div class="mt-5 mx-4">

                            <label for="" class="text-secondary"><?php echo $watchlistData["title"]; ?></label><br>
                            <label for="" class="text-black fs-3 fw-bold">Rs. <?php echo number_format($watchlistData["price"]); ?>.00</label><br>
                            <label for="" class="text-secondary fw-bold float-end" style="font-size: 14px;"><?php echo $watchlistData["condition_name"]; ?> Condition</label><br>

                            <hr>

                            <button class="btn btn-dark fw-bold rounded-5" onclick="window.location='single-product-view.php?id=<?php echo ($watchlistData['product_id']); ?>'">Buy</button>
                            <a href="single-product-view.php?id=<?php echo $watchlistData["product_id"] ?>" class="offset-1 text-secondary">More Details</a>
                            <button class="btn btn-danger rounded-5 float-end" onclick="delete_watchlist_item('<?php echo $watchlistData['product_id'] ?>');">&nbsp;<i class="bi bi-trash3"></i>&nbsp;</button>


                        </div>
                    </div>
                </div>

            <?php
            }

            ?>

        </div>

    <?php
    } else {

    ?>
        <label for="" class="text-dark" style="margin-top: 110px;"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-double-left"></i>Home</a> / <b>Watchlist</b></label>
        <h1 class="fw-bold text-center mb-5">Watchlist <label for="" class="text-secondary fs-6"><?php echo $watchlistNum; ?> item(s)</label></h1>

        <div class="row justify-content-center gap-2" style="min-height: 60vh;">
            <div class="animate__animated animate__fadeIn bg-light">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <img src="images/icon/Empty-Watchlist.png" class="col-8 col-md-4 col-lg-1 mb-5 mt-5" alt="">
                        <h4 class="text-secondary fw-bold">There are no products in your watchlist.</h4>
                        <a href="index.php" class="btn btn-dark fw-bold mt-3 rounded-5 shadow">Go to Shopping</a>
                    </div>
                </div>
            </div>

    <?php


    }
} else {
    include "unauthorized-access.php";
}

    ?>