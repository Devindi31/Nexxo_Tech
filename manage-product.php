<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/Logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="css/full.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Manage Products - Nexxo Tech</title>
</head>

<body onload="load_manage_products();">

    <div class="container-fluid animate__animated animate__fadeIn bg-white">
        <div class="row">

            <div class="col-12">
                <div class="row justify-content-center">

                    <?php
                    session_start();

                    if (isset($_SESSION["service"])) {

                    ?>

                        <div class="offcanvas offcanvas-start shadow " style="background-color: rgb(255, 255, 255);" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="adminMenuBar">
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

                        <div class="col-12">
                            <div class="row justify-content-around">

                                <div class="col-12 text-end fixed-bottom">
                                    <a href="add-product.php" class="btn btn-dark rounded-5 mb-2"><i class="bi bi-plus-lg fs-5"></i></a>
                                </div>

                                <div class="col-12 row justify-content-center fixed-top" style="backdrop-filter: blur(15px);">
                                    <h1 class="fw-bold text-black mt-4 mb-4 text-center">Manage Products</h1>

                                    <div class="col-12 fixed-top text-end">
                                        <img src="images/icon/Menu.png" class="mt-4 me-4" style="cursor: pointer;" height="30px" data-bs-toggle="offcanvas" data-bs-target="#adminMenuBar" />
                                    </div>

                                    <div class="col-11 col-lg-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control bg-transparent" id="admin-product-name" placeholder="Search by product name . . ." style="border-top-left-radius: 25px;border-bottom-left-radius: 25px;">
                                            <button class="btn btn-dark" type="button" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;" onclick="admin_search_product();"><i class="bi bi-search"></i></button>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-11" style="margin-top: 190px;">
                                    <div class="row justify-content-center gap-4" id="admin-product-section">

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
                                    <h4 class="fw-bold text-secondary mt-5">Access Denied: You must be signed in to manage the product.</h4>
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

        </div>
    </div>

    <!-- Add Color modal -->
    <div class="modal fade" id="add-color-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12 text-center">
                        <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Add Product Color</h1>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="col-12">
                        <label for="" class="fw-bold text-dark ">Available Product Color</label>

                        <ul id="color-list">

                        </ul>

                    </div>

                    <div class="col-12 mb-3">
                        <label for="" class="text-dark fw-bold">Select Color</label>
                        <select name="" class="form-select rounded-3" id="load-color-select">

                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="text-secondary">If the product color you want is not available, add it</label>
                        <div class="input-group mb-3 gap-2">
                            <input type="text" class="form-control rounded-3" id="add-color-input">
                            <button class="btn btn-dark rounded-3" type="button" onclick="add_new_color();"><i class="bi bi-plus-circle"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 text-center border-end">
                                <a class="text-decoration-none text-dark fw-bold" style="cursor: pointer;" id="add-color-button">Add Color</a>
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
    <!-- add Color modal -->


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/sweetalert2.js"></script>
</body>

</html>