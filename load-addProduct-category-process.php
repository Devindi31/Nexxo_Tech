<?php

include "connection.php";

$categoryResult = Database::search("SELECT * FROM `category`");
$categoryResultNum = $categoryResult->num_rows;

if ($categoryResultNum > 0) {
?>
    <option value="0">Select Category</option>
    <?php
    for ($c = 0; $c < $categoryResultNum; $c++) {
        $categoryData = $categoryResult->fetch_assoc();
    ?>
        <option value="<?php echo $categoryData["category_id"]; ?>"><?php echo $categoryData["category_name"]; ?></option>
    <?php
    }
} else {
    ?>
    <option value="0">No category</option>
<?php
}

?>