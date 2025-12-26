<?php

include "connection.php";

$brandResult = Database::search("SELECT * FROM `brand`");
$brandResultNum = $brandResult->num_rows;

if ($brandResult > 0) {
?>
    <option value="0">Select Brand</option>
    <?php
    for ($c = 0; $c < $brandResultNum; $c++) {
        $brandData = $brandResult->fetch_assoc();
    ?>
        <option value="<?php echo $brandData["brand_id"]; ?>"><?php echo $brandData["brand_name"]; ?></option>
    <?php
    }
} else {
    ?>
    <option value="0">No Brand</option>
<?php
}

?>