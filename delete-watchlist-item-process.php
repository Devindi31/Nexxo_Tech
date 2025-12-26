<?php 

include "connection.php";
session_start();

if(isset($_SESSION["NexxoTechUser"])){

    if (isset($_GET["id"])) {
        
        $product_id = $_GET["id"];
        $email = $_SESSION["NexxoTechUser"]["email"];

        $watchlistResult = Database::search("SELECT * FROM `watchlist` WHERE `product_product_id` = '$product_id' AND `user_email` = '$email'");

        if ($watchlistResult->num_rows > 0) {
            $watchlistData = $watchlistResult->fetch_assoc();

            Database::iud("DELETE FROM `watchlist` WHERE `product_product_id` = '$product_id' AND `user_email` = '$email'");
            echo "success";
            
        }else{
            echo "Watchlist Product Not Found";
        }
        
    }else{
        echo "Something went wrong";
    }

}else{
    echo "login";
}

?>