<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/Logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Add Product - Nexxo Tech</title>
</head>

<body onload="load_addProduct_category();load_addProduct_brand();">

    <div class="container-fluid animate__animated animate__fadeIn bg-white">
        <div class="row">

            <?php

            include "connection.php";
            session_start();

            if (isset($_SESSION["service"])) {
            ?>

                <div class="col-12">
                    <div class="row justify-content-center" style="backdrop-filter: blur(15px);">

                        <div class="col-12 fixed-top text-end">
                            <img src="images/icon/Menu.png" class="mt-4 mx-4" style="cursor: pointer;" height="30px" data-bs-toggle="offcanvas" data-bs-target="#adminMenuBar" />
                        </div>

                        <div class="offcanvas offcanvas-start shadow" style="background-color: rgb(255, 255, 255);" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="adminMenuBar">
                            <div class="offcanvas-header">
                                <h3 class="offcanvas-title fw-bold text-black mt-3" id="offcanvasScrollingLabel">Admin Dashboard</h3>
                                <button type="button" class="btn-close mt-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>

                            <hr class="bg-dark mb-3">

                            <div class="offcanvas-body text-center">

                                <img src="images/Logo.png" class="admin-logo-image mt-3 mb-3" alt="" /><br>

                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark mt-5" style="font-size: 17px;" onclick="window.location = 'admin-dashboard.php'"><i class="bi bi-speedometer"></i>&nbsp; Dashboard</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark" style="font-size: 17px;" onclick="window.location = 'manage-product.php'"><i class="bi bi-collection-fill"></i>&nbsp; Product Management</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark" style="font-size: 17px;" onclick="window.location = 'manage-users.php'"><i class="bi bi-person-fill-gear fs-5"></i> User Management</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark" style="font-size: 17px;" onclick="window.location = 'order-management.php'"><i class="bi bi-box-seam-fill"></i>&nbsp; Order Management</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark" style="font-size: 17px;" onclick="window.location = 'user-report.php'"><i class="bi bi-clipboard2-data-fill"></i>&nbsp; User Reports</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-dark mb-5" style="font-size: 17px;" onclick="window.location = 'admin-message.php'"><i class="bi bi-chat-dots-fill"></i>&nbsp; Message</button>
                                <button class="col-11 menu-button mb-2 text-start fw-bold text-danger mt-5" style="font-size: 17px;" onclick="admin_logOut();"><i class="bi bi-door-open-fill"></i>&nbsp; Log Out</button>

                            </div>
                        </div>

                        <div class="col-12 col-lg-10 ">
                            <div class="row justify-content mt-4">

                                <h1 class="fw-bold text-black mb-3 text-center">Add New Product</h1>

                                <hr>

                                <div class="col-12 col-lg-6 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Title</label>
                                    <input type="text" class="form-control" id="product-title" placeholder="Add Product Title" />
                                </div>

                                <div class="col-12 col-lg-6 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Model Name</label>
                                    <input type="text" class="form-control" id="product-model-name" placeholder="Add Model Name" />
                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Category</label>
                                    <div class="input-group gap-1">
                                        <select name="" id="product-category" class="form-select rounded-3">

                                        </select>
                                        <button class="btn btn-dark rounded-3" type="button" onclick="open_add_category_modal();"><i class="bi bi-plus-circle"></i></button>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Brand</label>
                                    <div class="input-group gap-1">
                                        <select name="" id="product-brand" class="form-select rounded-3">

                                        </select>
                                        <button class="btn btn-dark rounded-3" type="button" onclick="open_add_brand_modal();"><i class="bi bi-plus-circle"></i></button>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-4">
                                    <label class="form-label fw-bold" for="">Product Condition</label>

                                    <select name="" id="product-condition" class="form-select rounded-3">

                                        <?php

                                        $condition = Database::search("SELECT * FROM `condition`");
                                        $conditionNum =  $condition->num_rows;

                                        if ($conditionNum > 0) {

                                            for ($c = 0; $c < $conditionNum; $c++) {
                                                $conditionData = $condition->fetch_assoc();
                                        ?>
                                                <option value="<?php echo $conditionData['condition_id']; ?>"><?php echo $conditionData['condition_name']; ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="0">No Condition</option>
                                        <?php
                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="col-12 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Product Description</label>
                                    <textarea name="" id="product-description" cols="30" rows="10" class="form-control" placeholder="Add Product Description"></textarea>

                                </div>

                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Product Price</label>
                                    <input type="text" class="form-control" id="product-price" placeholder="Add Product Price" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Quantity</label>
                                    <input type="number" class="form-control" id="product-quantity" placeholder="Add Quantity" />
                                </div>
                                <div class="col-12 col-lg-4 mb-3 mt-3">
                                    <label class="form-label fw-bold" for="">Delivery Fee</label>
                                    <input type="text" class="form-control" id="product-delivery-fee" placeholder="Add Delivery Fee" />
                                </div>

                                <div class="row g-4 mt-3">

                                    <!-- Product Image -->

                                    <div class="col-12 col-lg-6">
                                        <div class="shadow rounded-5 h-100 p-3">

                                            <div class="col-12 rounded-5 mt-3 border-secondary">
                                                <div class="row d-flex justify-content-center align-items-center mb-3">

                                                    <div class="col-12 col-md-5 col-lg-6 text-center mt-3">
                                                        <img src="images/icon/Add-Image.png" class="col-12 col-lg-6 product-image" alt="" id="preview-product-image"><br>
                                                    </div>

                                                    <div class="col-12 col-lg-6 mt-5">
                                                        <h4 class="fw-bold text-secondary mx-5">Follow</h4>
                                                        <label for="" class="text-secondary mx-5">Image size : (1:1)</label><br>
                                                        <label for="" class="text-secondary mx-5">Image Background : Transparent</label><br>
                                                        <label for="" class="text-secondary mx-5">Image Quality : High Quality</label>

                                                        <input type="file" class="d-none" id="product-image" onchange="select_product_image();">
                                                        <label for="product-image" class="btn btn-dark rounded-4 mt-5 mb-3 mx-5 fw-bold">Select Product Image</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Background Image -->

                                    <div class="col-12 col-lg-6">
                                        <div class="shadow rounded-5 h-100 p-3">

                                            <div class="col-12 rounded-5 border-secondary">
                                                <div class="row d-flex justify-content-center align-items-center mb-3">

                                                    <div class="col-11 col-lg-6 text-center mt-3">
                                                        <img src="images/icon/Add-Background-Image.png" class="col-12 col-md-5 col-lg-10 mb-3 rounded-1 product-image" id="preview-background-image" alt=""><br>
                                                    </div>

                                                    <div class="col-12 col-lg-6 mt-5">
                                                        <h4 class="fw-bold text-secondary mx-5">Follow</h4>
                                                        <label for="" class="text-secondary mx-5">Image size : 1920x1080</label><br>
                                                        <label for="" class="text-secondary mx-5">Image Quality : High Quality</label>

                                                        <input type="file" class="d-none" id="product-background-image" onchange="select_background_image();">
                                                        <label for="product-background-image" class="btn btn-dark rounded-4 mt-5 mb-3 mx-5 fw-bold">Select Background Image</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 mt-5 mb-5 text-center">
                                    <button class="btn btn-dark rounded-5 fw-bold w-50 py-2 fs-6" onclick="add_new_product();">Add New Product</button>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php
            } else {

            ?>

                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center vh-100">

                        <div class="col-12 text-center">

                            <img src="images/icon/unauthorized.png" class="col-8 col-md-4 col-lg-3" alt="">
                            <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be logged in to add product.</h4>
                            <a href="create-or-signIn.php" class="btn btn-dark rounded-5 shadow mt-3 fw-bold">&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;</a>

                            <label for="" class="text-secondary fixed-bottom" style="font-size: 12px;">Copyright &copy; <label for="" id="copyright-year"></label> Nexxo Tech | All Rights Reserved</label>

                        </div>

                    </div>
                </div>

            <?php

            }

            ?>

        </div>
    </div>

    <!-- Add Category Modal -->

    <div class="modal fade" id="add-category-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12 text-center">
                        <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Add New Category</h1>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-3">
                        <label for="" class="text-secondary fw-bold">Category Name</label>
                        <input type="text" class="form-control" id="category-name" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="text-secondary fw-bold">Category Icon Name</label>
                        <input type="text" class="form-control" id="category-icon" />

                        <div class="col-12 mt-3 mb-2 rounded-4">
                            <label for="" class="mt-2 text-secondary mx-2 fw-bold" style="font-size: 12px;">Follow this guide to choose an icon name.</label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">1. Follow this link : <a target="_blank" href="https://icons.getbootstrap.com/">Bootstrap Icon</a></label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">2. Choose an icon</label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">3. Copy the icon name as in this example : <span><span>&lt;</span><span>i</span> <span>class</span><span>=</span><span class="fw-bold text-dark">"bi bi-apple"</span><span class="p">&gt;&lt;/</span><span class="nt">i</span><span class="p">&gt;</span></span></label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">4. Paste the icon name in the input field</label><br>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 text-center border-end">
                                <a class="text-decoration-none text-dark fw-bold" onclick="add_new_category();" style="cursor: pointer;">Add Category</a>
                            </div>
                            <div class="col-6 text-center">
                                <a class="text-decoration-none text-secondary fw-bold" data-bs-dismiss="modal" style="cursor: pointer;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Brand Modal -->
    <div class="modal fade" id="add-brand-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12 text-center">
                        <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Add New Brand</h1>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-3">
                        <label for="" class="text-secondary fw-bold">Brand Name</label>
                        <input type="text" class="form-control" id="brand-name" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="text-secondary fw-bold">Brand Image</label>
                        <input type="file" class="form-control" id="brand-image" />

                        <div class="col-12 mt-3 mb-2 rounded-4">
                            <label for="" class="mt-2 text-secondary mx-2 fw-bold" style="font-size: 12px;">Follow this guide to choose an image.</label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">1. Follow this link to find the SVG image : <a target="_blank" href="https://svgrepo.com/">Find SVG image</a></label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">2. Image Color : Black</label><br>
                            <label for="" class="text-secondary mx-2" style="font-size: 13px;">3. Image Type : SVG</label><br>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 text-center border-end ">
                                <a class="text-decoration-none text-dark fw-bold" onclick="add_new_brand();" style="cursor: pointer;">Add Brand</a>
                            </div>
                            <div class="col-6 text-center">
                                <a class="text-decoration-none text-secondary fw-bold" data-bs-dismiss="modal" style="cursor: pointer;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>