<?php

include "connection.php";

$categoryId = $_POST["categoryId"];
$searchName = $_POST["productName"];
$brandId = $_POST["brandId"];

$query = "SELECT * FROM `product` INNER JOIN `model_has_brand` ON `product`.`model_has_brand_id`=`model_has_brand`.`id` 
INNER JOIN `product_image` ON `product_image`.`product_product_id`=`product`.`product_id` 
WHERE `category_category_id`='" . $categoryId . "'";

if (!empty($searchName) && $brandId == 0) {
    $query .= " AND `title` LIKE '%" . $searchName . "%'";
} else if ($brandId != 0 && empty($searchName)) {
    $query .= "  AND `brand_brand_id`='" . $brandId . "'";
} else if (!empty($searchName) && $brandId != 0) {
    $query .= " AND `title` LIKE '%" . $searchName . "%' AND `brand_brand_id`='" . $brandId . "'";
}

$searchResult = Database::search($query);
$searchNumRows = $searchResult->num_rows;

if ($searchNumRows > 0) {
    for ($i = 0; $i < $searchNumRows; $i++) {

        $productData = $searchResult->fetch_assoc();
    ?>
    
        <div class="rounded-4 device-card animate__animated animate__fadeIn" style="width: 18rem; height: 380px;">
    
            <div class="row d-flex align-items-end justify-content-center" style="height: 200px;">
                <img src="<?php echo ($productData["product_image_path"]); ?>" class="col-9 device-image" alt="">
            </div>
    
            <hr>
    
            <div class="col-12 text-black">
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
    
                <button class="btn btn-dark fw-bold col-3 rounded-5" onclick="window.location='single-product-view.php?id=<?php echo ($productData['product_id']); ?>'">Buy</button>
                <a href="single-product-view.php?id=<?php echo ($productData["product_id"]); ?>" class="float-end text-secondary me-2 mt-2">Learn more<i class="bi bi-chevron-double-right"></i></a>
    
            </div>
    
        </div>
    
    <?php
    
    }
    
}else{

    ?>

    <div class="col-12 text-center animate__animated animate__fadeIn mt-5">
        <img src="images/icon/Empty_Product.png" class="col-8 col-md-4 col-lg-1" alt="">
        <h4 class="text-secondary fw-bold mt-3">This product is currently unavailable.</h4>
    </div>

<?php

}