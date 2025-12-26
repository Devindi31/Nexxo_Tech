<?php

include "connection.php";
session_start();

if (isset($_SESSION["NexxoTechUser"])) {

    $email = $_SESSION["NexxoTechUser"]["email"];
    $order_id_or_name = $_POST["orderId_or_name"];
    $order_date = $_POST["order_date"];

    $query = "SELECT * FROM `order` 
    INNER JOIN `product` ON `order`.`product_product_id`=`product`.`product_id` WHERE `user_email`='$email'";

    if (!empty($order_id_or_name) && empty($order_date)) {
        $query .= " AND (`order`.`order_id` LIKE '%$order_id_or_name%' OR `title` LIKE '%$order_id_or_name%') ORDER BY `date_time` DESC";
    } else if (empty($order_id_or_name) && !empty($order_date)) {
        $query .= " AND `order`.`date_time` LIKE '$order_date%' ORDER BY `date_time` DESC";
    } else if (!empty($order_id_or_name) && !empty($order_date)) {
        $query .= " AND (`order`.`order_id` LIKE '%$order_id_or_name%' OR `title` LIKE '%$order_id_or_name%') AND `order`.`date_time` LIKE '$order_date%' ORDER BY `date_time` DESC";
    }

    $searchResult = Database::search($query);
    $resultNum = $searchResult->num_rows;

    if ($resultNum > 0) {

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

                    for ($i = 0; $i < $resultNum; $i++) {
                        $invoiceData =  $searchResult->fetch_assoc();

                        $date = date_create($invoiceData["date_time"]);
                        $foematedDate = date_format($date, "Y-M-d");

                    ?>

                        <tr class="animate__animated animate__fadeIn">
                            <td class="text-secondary"><?php echo $invoiceData["order_id"]; ?></td>
                            <td class="text-secondary"><?php echo $invoiceData["title"]; ?></td>
                            <td class="text-secondary">Rs. <?php echo number_format($invoiceData["price"]); ?>.00</td>
                            <td class="text-secondary"><?php echo $invoiceData["qty"]; ?></td>
                            <td class="text-secondary"><?php echo $foematedDate; ?></td>
                            <td class="text-secondary">Rs. <?php echo number_format($invoiceData["total"] - $invoiceData["delivery_fee"]); ?>.00</td>
                            <td class="text-secondary text-center"><a href="invoice.php?id=<?php echo $invoiceData["order_id"]; ?>" class="text-secondary" target="_blank"><i class="bi bi-printer"></i></a></td>
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
            <h4 class="text-secondary fw-bold text-center">No invoices match your search.</h4>

        </div>

<?php
    }
} else {
    echo "login";
}
