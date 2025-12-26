<?php

include "connection.php";

$daily_data = [];
$daily_lables = [];

$brand_has_model = [];
$brand_name = [];

$dateTime = new DateTime();
$timeZoon = new DateTimeZone("Asia/Colombo");
$dateTime->setTimezone($timeZoon);
$newDateTime = $dateTime->format("Y-m-d");

$monthly_income_result = Database::search("SELECT * FROM `order` WHERE `date_time` LIKE '" . $newDateTime . "%'");
$monthly_income_num = $monthly_income_result->num_rows;

$monthly_income = 0;
$total_products = 0;

for ($m = 0; $m < $monthly_income_num; $m++) {
    $monthly_income_data = $monthly_income_result->fetch_assoc();

    $monthly_income += $monthly_income_data["total"];
    $total_products += $monthly_income_data["qty"];
}

$brandResult = Database::search("SELECT * FROM `brand`");
$brand_num = $brandResult->num_rows;

if ($brand_num > 0) {

    for ($b = 0; $b < $brand_num; $b++) {
        $brandData = $brandResult->fetch_assoc();

        $brand_has_model_count = Database::search("SELECT `brand_brand_id`, COUNT(model_model_id) AS brand_has_model_count FROM `model_has_brand` 
        INNER JOIN `brand` ON `model_has_brand`.`brand_brand_id`=`brand`.`brand_id`WHERE `brand_brand_id`='" . $brandData["brand_id"] . "'");

        if ($brand_has_model_count->num_rows > 0) {
            $brand_has_model_data = $brand_has_model_count->fetch_assoc();

            $brand_has_model[] = $brand_has_model_data["brand_has_model_count"];
            $brand_name[] = $brandData["brand_name"];
        } else {
            $brand_has_model[] = "0";
            $brand_name[] = $brandData["brand_name"];
        }
    }
} else {

    $brand_has_model[] = "0";
    $brand_name[] = "No Brand";
}

$daily_data[] = $monthly_income;
$daily_lables[] = "Daily Income";
$daily_data[] = $total_products;
$daily_lables[] = "Total Selling Product";

$json = [];
$json["daily_data"] = $daily_data;
$json["daily_lables"] = $daily_lables;
$json["brand_has_model_data"] = $brand_has_model;
$json["brand_name_lables"] = $brand_name;

echo (json_encode($json));

