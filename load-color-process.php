<?php

include "connection.php";
session_start();

if (isset($_SESSION["service"])) {

    $colorResult = Database::search("SELECT * FROM `color` ORDER BY `color_name` ASC");
    $colorResultsNum = $colorResult->num_rows;

    if ($colorResultsNum > 0) {

        ?>
        <option value="0">Select Product Color</option>
        <?php
        for ($c = 0; $c < $colorResultsNum; $c++) {
            $colorData = $colorResult->fetch_assoc();
?>
            <option value="<?php echo $colorData["color_id"]; ?>"><?php echo $colorData["color_name"]; ?></option>
        <?php
        }
    } else {
        ?>
        <option value="0">There is no color in this product</option>
<?php
    }
}

?>