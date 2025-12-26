<?php

include "connection.php";
session_start();

$email =  $_SESSION["NexxoTechUser"]["email"];

$invoiceResult = Database::search("SELECT * FROM `order` 
INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` WHERE `user_email` = '$email' ORDER BY `date_time` DESC");
$invoiceNum = $invoiceResult->num_rows;

if ($invoiceNum > 0) {

?>

    <div class="table-responsive mt-4 mb-2 text-center">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Sub Total</th>
                    <th>Print</th>
                </tr>
            </thead>
            <tbody>

                <?php

                for ($i = 0; $i < $invoiceNum; $i++) {
                    $invoiceData =  $invoiceResult->fetch_assoc();

                    $date = date_create($invoiceData["date_time"]);
                    $foematedDate = date_format($date, "Y-M-d");

                ?>

                    <tr>
                        <td class="text-secondary"><?php echo $invoiceData["order_id"];?></td>
                        <td class="text-secondary"><?php echo $invoiceData["title"];?></td>
                        <td class="text-secondary">Rs. <?php echo number_format($invoiceData["price"]);?>.00</td>
                        <td class="text-secondary"><?php echo $invoiceData["qty"];?></td>
                        <td class="text-secondary"><?php echo $foematedDate;?></td>
                        <td class="text-secondary">Rs. <?php echo number_format($invoiceData["total"]-$invoiceData["delivery_fee"]);?>.00</td>
                        <td class="text-center"><a href="invoice.php?id=<?php echo $invoiceData["order_id"];?>" target="_blank" class="text-secondary"><i class="bi bi-printer"></i></a></td>
                    </tr>

                <?php

                }

                ?>

            </tbody>
        </table>
    </div>

<?php

} else {
?>



    <div class="col-12 text-center mb-5 animate__animated animate__fadeIn">

        <img src="images/icon/Empty-Invoices.png"  class="col-8 col-md-4 col-lg-1 mb-4 mt-5" alt="">
        <h4 class="text-secondary fw-bold">No invoice available at this time.</h4>

    </div>

<?php


}

?>