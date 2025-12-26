<?php
require "connection.php";

$text = $_POST["text"];
$category = $_POST["category"];
$brand = $_POST["brand"];
$color = $_POST["color"];
$priceFrom = $_POST["priceFrom"];
$priceTo = $_POST["priceTo"];
$sort = $_POST["sortBy"];

if ($color != 0) {
    $colorResult = Database::search("SELECT * FROM `color` WHERE `color_id`='$color'");
    $colorData = $colorResult->fetch_assoc();

    $query = "SELECT * FROM `product` 
    INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id` = `model_has_brand`.`id` 
    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id`
    INNER JOIN `product_has_color` ON `product_has_color`.`product_product_id` = `product`.`product_id`
    WHERE `product`.`title` LIKE '%" . $text . "%' AND `product_has_color`.`color_color_id` = '" . $colorData["color_id"] . "'";
} else {

    $query = "SELECT * FROM `product` 
    INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id` = `model_has_brand`.`id` 
    INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id`
    WHERE `product`.`title` LIKE '%" . $text . "%'";
}

if ($category != 0) {
    $query .= " AND `product`.`category_category_id` = '" . $category . "'";
}

if ($brand != 0) {
    $query .= " AND `model_has_brand`.`brand_brand_id` = '" . $brand . "'";
}

if (!empty($priceFrom)) {
    $query .= " AND `product`.`price` >='" . $priceFrom . "'";
}

if (!empty($priceTo)) {
    $query .= " AND `product`.`price` <='" . $priceTo . "'";
}

switch ($sort) {
    case 1:
        $query .= " ORDER BY `price` DESC";

        break;

    case 2:
        $query .= " ORDER BY `price` ASC";

        break;
}

if (empty($text) && $category == 0 && $brand == 0 && $color == 0 && empty($pricef) && empty($pricet)) {

    $query;
}

$productResult = Database::search($query);
$productResultNum = $productResult->num_rows;

if ($productResultNum > 0) {
    while ($productData = $productResult->fetch_assoc()) {

?>

        <div class="rounded-4 device-card animate__animated animate__fadeIn" style="width: 18rem;    height: 380px;">

            <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                <img src="<?php echo ($productData["product_image_path"]); ?>" class="col-9 device-image" alt="">
            </div>

            <hr>

            <div class="col-12 text-black text-start">
                <label class="text-secondary" for=""><?php echo ($productData["title"]); ?></label>
                <h4 class="fw-bold">Rs. <?php echo number_format($productData["price"]); ?>.00</h4>

                <?php

                if ($productData["quantity"] != 0) {
                ?>
                    <label for="">In Stock</label>
                <?php
                } else {
                ?>
                    <label for="" class="text-danger">Out of Stock</label>
                <?php
                }

                ?>

            </div>

            <div class="col-12 mt-3 ">

                <button class="btn btn-secondary text-white fw-bold col-3 rounded-5 float-start" onclick="window.location='single-product-view.php?id=<?php echo ($productData['product_id']); ?>'">Buy</button>
                <a href="single-product-view.php?id=<?php echo ($productData["product_id"]); ?>" class="float-end me-2 mt-2 text-secondary">Learn more<i class="bi bi-chevron-double-right"></i></a>

            </div>

        </div>

    <?php
    }
} else {
    ?>

    <div class="col-12 text-center animate__animated animate__fadeIn">
        <div class="row justify-content-center gap-2" id="advanced-search-result">
            <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-2" alt="">
            <h4 class="fw-bold text-secondary mt-2">Oops! No matches results yet.</h4>
        </div>
    </div>

<?php
}