var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    loop: true,
    slidesPerView: "auto",
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 150,
        modifier: 1,
        slideShadows: true,
    },
    autoplay: {

        delay: 3000,
        disableOnInteraction: false,
    }

});

function signInSignUpChange() {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function createAccount() {

    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var email = document.getElementById("email").value;
    var mobile = document.getElementById("mobile").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    var form = new FormData();

    form.append("fname", fname);
    form.append("lname", lname);
    form.append("email", email);
    form.append("mobile", mobile);
    form.append("password", password);
    form.append("confirmPassword", confirmPassword);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {

            var response = request.responseText;
            if (response == "success") {

                welcomeMail(email);

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "<label for='' class='fw-bold fs-1'>Congratulations !</label>",
                    html: "<label class='fs-5'><b>" + fname + " " + lname + "</b>, your account has been successfully created.</label> <hr> <a class='text-secondary fw-bold fs-5' style='cursor: pointer;' onclick='window.location.reload(); '>Go to Sign In <i class='bi bi-chevron-double-right' style='font-size: 15px;'></i></a>",
                    showConfirmButton: false
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }
        }
    }

    request.open("POST", "createAccount-process.php", true);
    request.send(form);

}

function createAccounNewPasswordShow() {

    var password = document.getElementById("password");
    var newPasswordIcon = document.getElementById("newAccountShowPasswordIcon");

    if (password.type == "password") {
        password.type = "text";
        newPasswordIcon.className = "bi bi-eye";
    } else {
        password.type = "password";
        newPasswordIcon.className = "bi bi-eye-slash";
    }

}

function createAccounConfirmPasswordShow() {

    var confirmPassword = document.getElementById("confirmPassword");
    var confirmPasswordIcon = document.getElementById("newAccountShowConfirmPasswordIcon");



    if (confirmPassword.type == "password") {
        confirmPassword.type = "text";
        confirmPasswordIcon.className = "bi bi-eye";
    } else {
        confirmPassword.type = "password";
        confirmPasswordIcon.className = "bi bi-eye-slash";
    }

}


function welcomeMail(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;
        }
    }

    request.open("GET", "welcome-mail-sending-process.php?email=" + email, true);
    request.send();
}


function signIn() {

    var signInEmail = document.getElementById("signInEmail").value;
    var signInPassword = document.getElementById("signInPassword").value;
    var rememberMe = document.getElementById("rememberMe").checked;

    var form = new FormData();

    form.append("signInEmail", signInEmail);
    form.append("signInPassword", signInPassword);
    form.append("rememberMe", rememberMe);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {

                window.location = "index.php";

            } else {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Sorry !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }
        }
    }

    request.open("POST", "signIn-process.php", true);
    request.send(form);

}


function sendVerificationCode() {

    var resetEmailOrMobile = document.getElementById("resetEmailOrMobile").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {

        document.getElementById("sendVerificationCodeButton").innerHTML = "Please wait a moment";
        document.getElementById("sendVerificationCodeButton").classList.add("disabled");

        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "Enter email address or mobile.") {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

                document.getElementById("sendVerificationCodeButton").innerHTML = "Continue";
                document.getElementById("sendVerificationCodeButton").classList.remove("disabled");

            } else if (response == "An invalid email address or mobile phone number") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Sorry !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

                document.getElementById("sendVerificationCodeButton").innerHTML = "Continue";
                document.getElementById("sendVerificationCodeButton").classList.remove("disabled");

            } else {


                document.getElementById("sendVerificationCodeButton").classList.remove("disabled");
                document.getElementById("sendVerificationCodeButton").className = "d-none";
                document.getElementById("resetPasswordButton").className = "d-block btn btn-dark mt-3 rounded-5";

                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "<label for='' class='fw-bold fs-1'>Check !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

                document.getElementById("resetPasswordHideDiv").classList.remove("d-none");

            }
        }
    }

    request.open("GET", "reset-password-sending-mail.php?email=" + resetEmailOrMobile, true);
    request.send();

}

function resetPassword() {

    var resetEmailOrMobile = document.getElementById("resetEmailOrMobile").value;
    var resetNewPassword = document.getElementById("reseNewPassword").value;
    var resetConfirmPassword = document.getElementById("resetConfirmPassword").value;
    var resetVerificationCode = document.getElementById("resetVerificationCode").value;

    var form = new FormData();

    form.append("resetEmailOrMobile", resetEmailOrMobile);
    form.append("resetNewPassword", resetNewPassword);
    form.append("resetConfirmPassword", resetConfirmPassword);
    form.append("resetVerificationCode", resetVerificationCode);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "Your password reset is successful.") {

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "<label for='' class='fw-bold fs-1'>Success !</label>",
                    html: "<label>" + response + "</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

                resetPasswordSuccessMailSending(resetEmailOrMobile);

            } else if (response == "An invalid email address or mobile phone number") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Sorry !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "reset-password-process.php", true);
    request.send(form);

}


function resetNewPasswordShow() {

    var password = document.getElementById("reseNewPassword");
    var newPasswordIcon = document.getElementById("reseNewPasswordIcon");

    if (password.type == "password") {
        password.type = "text";
        newPasswordIcon.className = "bi bi-eye";
    } else {
        password.type = "password";
        newPasswordIcon.className = "bi bi-eye-slash";
    }

}

function resetConfirmPasswordShow() {

    var confirmPassword = document.getElementById("resetConfirmPassword");
    var confirmPasswordIcon = document.getElementById("resetConfirmPasswordIcon");



    if (confirmPassword.type == "password") {
        confirmPassword.type = "text";
        confirmPasswordIcon.className = "bi bi-eye";
    } else {
        confirmPassword.type = "password";
        confirmPasswordIcon.className = "bi bi-eye-slash";
    }

}

function resetPasswordSuccessMailSending(resetNewPassword) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

        }
    }

    request.open("GET", "reset-password-success-mail-sending.php?em=" + resetNewPassword, true);
    request.send();

}


function logOut() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {
                window.location.reload();
            }

        }
    }

    request.open("GET", "log-out-process.php", true);
    request.send();

}

function advanced_search() {

    var text = document.getElementById("ad-text").value;
    var category = document.getElementById("ad-category").value;
    var brand = document.getElementById("ad-brand").value;
    var color = document.getElementById("ad-color").value;
    var priceFrom = document.getElementById("price-from").value;
    var priceTo = document.getElementById("price-to").value;
    var sortBy = document.getElementById("sort-by").value;

    var form = new FormData();
    form.append("text", text);
    form.append("category", category);
    form.append("brand", brand);
    form.append("color", color);
    form.append("priceFrom", priceFrom);
    form.append("priceTo", priceTo);
    form.append("sortBy", sortBy);


    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("advanced-search-result").innerHTML = response;
        }
    }

    request.open("POST", "advanced-search-process.php", true);
    request.send(form);

}


function searchCategoryBrand(categoryId) {

    var productName = document.getElementById("SearchProductName").value;
    var brandId = document.getElementById("SearchBrandId").value;

    var form = new FormData();

    form.append("categoryId", categoryId);
    form.append("productName", productName);
    form.append("brandId", brandId);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("loadCategory").innerHTML = response;
        }
    }

    request.open("POST", "search-category-process.php", true);
    request.send(form);

}

function searchBrandProduct(brandId) {

    var productName = document.getElementById("brandSearchProductName").value;

    var form = new FormData();
    form.append("brandId", brandId);
    form.append("productName", productName);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("loadBrandProducts").innerHTML = response;

        }
    }

    request.open("POST", "search-brand-process.php", true);
    request.send(form);

}


function basicSearch() {

    var productName = document.getElementById("basicSearchProductName").value;
    var categoryId = document.getElementById("basicSearchProductCategory").value;

    var form = new FormData();
    form.append("productName", productName);
    form.append("categoryId", categoryId);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response != "") {

                var resultDiv = document.getElementById("basic-search-div")
                resultDiv.className = "col-12 mb-5 d-block basic-search-view-div";
                resultDiv.innerHTML = response;

            }

        }
    }

    request.open("POST", "basic-search-process.php", true);
    request.send(form);

}

function updateProfileImage() {

    var profileImage = document.getElementById("uploadProfileImage");

    var form = new FormData();

    form.append("profileImage", profileImage.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "Your profile image has been updated successfully.") {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-center",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: response
                }).then(() => {
                    window.location.reload();
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "update-profile-image-process.php", true);
    request.send(form);

}

function removeProfileImage() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {
                window.location.reload();
            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to remove profile image.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "User Not Found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("GET", "remove-profile-image-process.php", true);
    request.send();

}

function updateUserDetails() {
    var firstName = document.getElementById("userFirstName").value;
    var lastName = document.getElementById("userLastName").value;

    var form = new FormData();

    form.append("firstName", firstName);
    form.append("lastName", lastName);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Profile information updated successfully.",
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "update-user-details-process.php", true);
    request.send(form);
}

function updateUserAdress() {

    var addressLine = document.getElementById("addressLine").value;
    var city = document.getElementById("city").value;
    var district = document.getElementById("district").value;
    var postalCode = document.getElementById("postalCode").value;

    var form = new FormData();
    form.append("addressLine", addressLine);
    form.append("city", city);
    form.append("district", district);
    form.append("postalCode", postalCode);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "Address Added Successfully") {
                Swal.fire({
                    icon: "success",
                    title: response,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });

            } else if (response == "Address Updated Successfully") {
                Swal.fire({
                    icon: "success",
                    title: response,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "update-user-address-process.php", true);
    request.send(form);

}

function loadFeedback(productId) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("feedback-content").innerHTML = response;
        }
    }

    request.open("POST", "load-feedback-process.php?id=" + productId, true);
    request.send();

}

function addFeedback(productId) {

    var feedback = document.getElementById("feedback-text").value;

    var form = new FormData();
    form.append("feedback", feedback);
    form.append("productId", productId);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {

                document.getElementById("feedback-text").value = "";
                loadFeedback(productId);


            } else if (response == "Please Enter Your Feedback") {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "add-feedback-process.php", true);
    request.send(form);


}

function checkQuantity(productQty) {

    var inputQty = document.getElementById("quantityInput");

    var inputQuantityValue = parseInt(inputQty.value, 10);

    if (isNaN(inputQuantityValue) || inputQuantityValue < 1) {
        inputQty.value = "1";
    }

    else if (inputQuantityValue > productQty) {
        inputQty.value = productQty;
    }

}

function buy(productId) {

    var productColor = document.getElementById("productColor").value;
    var inputQty = document.getElementById("quantityInput").value;

    var form = new FormData();
    form.append("productId", productId);
    form.append("productColor", productColor);
    form.append("inputQty", inputQty);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to purchase this product.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "Please update your profile address book.") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr> <a href='user-profile.php' class='text-dark fw-bold'>Go to Profile <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "Product Not Found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else if (response == "Invalid input quantity.") {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else if (response == "Please select a color, or our product color is not available.") {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });



            } else {

                var object = JSON.parse(response);

                var email = object["email"];
                var amount = object["amount"];

                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);

                    Swal.fire({
                        icon: "success",
                        title: "Your payment has been completed.",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        addNewOrder(orderId, productId, email, amount, inputQty, productColor);
                    });


                };

                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };


                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                var payment = {
                    "sandbox": true,
                    "merchant_id": object["merchantId"],    // Replace your Merchant ID
                    "return_url": "http://localhost/Nexxo_Tech/single-product-view.php?id=" + productId,     // Important
                    "cancel_url": "http://localhost/Nexxo_Tech/single-product-view.php?id=" + productId,     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": object["orderId"],
                    "items": object["item"],
                    "amount": amount + ".00",
                    "currency": "LKR",
                    "hash": object["hash"], // *Replace with generated hash retrieved from backend
                    "first_name": object["fname"],
                    "last_name": object["lname"],
                    "email": email,
                    "phone": object["mobile"],
                    "address": object["address"],
                    "city": object["city"],
                    "country": "Sri Lanka",
                    "delivery_address": object["address"],
                    "delivery_city": object["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                payhere.startPayment(payment);

            }

        }
    }

    request.open("POST", "buy-process.php", true);
    request.send(form);


}

function addNewOrder(orderId, productId, email, amount, inputQty, productColor) {

    var form = new FormData();

    form.append("orderId", orderId);
    form.append("productId", productId);
    form.append("email", email);
    form.append("amount", amount);
    form.append("inputQty", inputQty);
    form.append("productColor", productColor);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                window.location = "invoice.php?id=" + orderId;

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to purchase this product.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "add-new-order-process.php", true);
    request.send(form);

}

function printinvoice() {

    var originalContent = document.body.innerHTML;
    var printContent = document.getElementById("invoice-content").innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
}

function addToeBag(productId) {

    var inputQty = document.getElementById("quantityInput").value;
    var productColorId = document.getElementById("productColor").value;

    if (inputQty <= 0) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
            html: "<label>Please enter a valid quantity.</label> <hr>",
            showConfirmButton: true
        });
    } else if (productColorId == 0) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
            html: "<label>Please select a color, or this product has no colors.</label> <hr>",
            showConfirmButton: true
        });
    } else {

        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == "added") {

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "<label for='' class='fw-bold fs-1'>Added to eBag.</label>",
                        html: "<label>This product was successfully added to eBag.</label> <hr> <a href='ebag.php' class='text-dark fw-bold'>Go to eBag</a>",
                        showConfirmButton: false
                    });

                } else if (response == "updated") {

                    Swal.fire({
                        position: "center",
                        icon: "info",
                        title: "<label for='' class='fw-bold fs-1'>eBag updated.</label>",
                        html: "<label>This product has already been added to eBag, 1 quantity was added to this product.</label> <hr> <a href='ebag.php' class='text-dark fw-bold'>Go to eBag</a>",
                        showConfirmButton: false
                    });

                } else if (response == "login") {

                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                        html: "<label>Please login to add this product to eBag.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                        showConfirmButton: false
                    });

                } else {

                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                        html: "<label>" + response + "</label> <hr>",
                        showConfirmButton: true
                    });

                }

            }
        }

        request.open("GET", "add-to-eBag-process.php?id=" + productId + "&colorId=" + productColorId, true);
        request.send();

    }

}

function addToWatchlist(productId) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please login to add this product to watchlist.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (espornse == "success") {
                window.location.reload();

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("GET", "add-to-watchlist-process.php?id=" + productId, true);
    request.send();

}

function findOrder() {
    var orderIdOrName = document.getElementById("orderIdOrName").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please login to find an order</label> <hr> <a href='create-or-signIn.php' class='text-decoration-none'>Login <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                document.getElementById("loard-order-section").innerHTML = response;
            }
        }
    }

    request.open("GET", "find-order-process.php?orderIdOrName=" + orderIdOrName, true);
    request.send();

}

function confirmDelivery(itemId) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please login to confirm delivery.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });
            } else if (response == "Item Not Found") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Item Not Found.</label> <hr>",
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "<label for='' class='fw-bold fs-1'>Success !</label>",
                    html: "<label>Delivery Confirmed.</label> <hr>",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {

                    window.location.reload();

                });
            }

        }
    }
    request.open("GET", "confirm-delivery-process.php?itemId=" + itemId, true);
    request.send();

}

function loadeBag() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("load-ebag-section").innerHTML = response;

        }
    }

    request.open("GET", "load-eBag-process.php", true);
    request.send();

}

function eBagQuantityChange(productId, action, quantity) {

    var form = new FormData();
    form.append("productId", productId);
    form.append("action", action);
    form.append("quantity", quantity);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please login to change quantity.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });
            } else if (response == "success") {
                loadeBag();
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }
        }

    }

    request.open("POST", "eBag-quantity-change-process.php", true);
    request.send(form);

}

function eBagSingleBuy(eBagId) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please login to buy.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "Please update your profile address book.") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please update your profile address book.</label> <hr> <a href='user-profile.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "eBag Product Not Found") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>eBag Product Not Found</label> <hr>",
                    showConfirmButton: true
                });
            } else {

                var object = JSON.parse(response);

                var email = object["email"];
                var amount = object["amount"];


                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);

                    Swal.fire({
                        icon: "success",
                        title: "Your payment has been completed.",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        add_new_order_from_ebag(orderId, eBagId, email, amount);

                    });


                };

                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };


                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };



                var payment = {
                    "sandbox": true,
                    "merchant_id": object["merchantId"],    // Replace your Merchant ID
                    "return_url": "http://localhost/Nexxo_Tech/ebag.php",     // Important
                    "cancel_url": "http://localhost/Nexxo_Tech/ebag.php",     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": object["orderId"],
                    "items": object["item"],
                    "amount": amount + ".00",
                    "currency": "LKR",
                    "hash": object["hash"], // *Replace with generated hash retrieved from backend
                    "first_name": object["fname"],
                    "last_name": object["lname"],
                    "email": email,
                    "phone": object["mobile"],
                    "address": object["address"],
                    "city": object["city"],
                    "country": "Sri Lanka",
                    "delivery_address": object["address"],
                    "delivery_city": object["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                payhere.startPayment(payment);

            }
        }
    }

    request.open("GET", "ebag-single-buy-process.php?ebagId=" + eBagId, true);
    request.send();

}

function add_new_order_from_ebag(orderId, eBagId, email, amount) {

    var form = new FormData();

    form.append("orderId", orderId);
    form.append("eBagId", eBagId);
    form.append("email", email);
    form.append("amount", amount);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                window.location = "invoice.php?id=" + orderId;

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to purchase this product.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }
        }
    }

    request.open("POST", "add-new-order-from-ebag.php", true);
    request.send(form);

}

function delete_ebag(eBagId) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                loadeBag();
            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to remove this product.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("GET", "delete-ebag-process.php?eBagId=" + eBagId, true);
    request.send();

}

function ebag_checkOut() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to checkout.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "Please update your profile address book.") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr> <a href='user-profile.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "eBag Result Not Found.") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                var object = JSON.parse(response);

                var email = object["email"];
                var amount = object["amount"];


                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);

                    Swal.fire({
                        icon: "success",
                        title: "Your payment has been completed.",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        add_new_order_from_ebag_checkOut(orderId, email);

                    });


                };

                payhere.onDismissed = function onDismissed() {
                    console.log("Payment dismissed");
                };


                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };



                var payment = {
                    "sandbox": true,
                    "merchant_id": object["merchantId"],    // Replace your Merchant ID
                    "return_url": "http://localhost/Nexxo_Tech/ebag.php",     // Important
                    "cancel_url": "http://localhost/Nexxo_Tech/ebag.php",     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": object["orderId"],
                    "items": object["item"],
                    "amount": amount + ".00",
                    "currency": "LKR",
                    "hash": object["hash"], // *Replace with generated hash retrieved from backend
                    "first_name": object["fname"],
                    "last_name": object["lname"],
                    "email": email,
                    "phone": object["mobile"],
                    "address": object["address"],
                    "city": object["city"],
                    "country": "Sri Lanka",
                    "delivery_address": object["address"],
                    "delivery_city": object["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                payhere.startPayment(payment);

            }
        }
    }

    request.open("GET", "ebag-checkout-process.php", true);
    request.send();

}

function add_new_order_from_ebag_checkOut(orderId, email) {

    var form = new FormData();
    form.append("orderId", orderId);
    form.append("email", email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                window.location = "invoice.php?id=" + orderId;

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to purchase this product.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "add-new-order-from-ebag-checkout-process.php", true);
    request.send(form);

}

function loadWatchlist() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("load-watchlist-section").innerHTML = response;

        }
    }

    request.open("GET", "load-watchlist-process.php", true);
    request.send();

}

function delete_watchlist_item(productId) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                loadWatchlist();

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to delete this product</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }


    request.open("POST", "delete-watchlist-item-process.php?id=" + productId, true);
    request.send();

}

function loadInvoices() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            document.getElementById("load-invoices-section").innerHTML = response;

        }
    }

    request.open("GET", "load-invoices-process.php", true);
    request.send();

}

function search_invoice() {

    var orderId_or_name = document.getElementById("invoice-orderId-or-name").value;
    var order_date = document.getElementById("order-date").value;

    var form = new FormData();
    form.append("orderId_or_name", orderId_or_name);
    form.append("order_date", order_date);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to search this invoice.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                document.getElementById("load-invoices-section").innerHTML = response;
            }

        }
    }

    request.open("POST", "search-invoice-process.php", true);
    request.send(form);

}

function loadMessage() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to view messages.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                document.getElementById("load-message-section").innerHTML = response;
            }

        }
    }

    request.open("GET", "load-message-process.php", true);
    request.send();

}

function send_message() {

    var message_text = document.getElementById("input-text-message");

    var form = new FormData();
    form.append("message_text", message_text.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to send message.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else if (response == "success") {
                message_text.value = "";
                loadMessage();
            }

        }
    }

    request.open("POST", "send-message-process.php", true);
    request.send(form);

}

function message_status_change() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {

            var response = request.responseText;

            if (response == "login") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Please log in to view message.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });
            }

        }
    }

    request.open("GET", "message-status-change-process.php", true);
    request.send();

}

function checking_email() {

    var email = document.getElementById("admin-signIn-email");

    var form = new FormData();
    form.append("email", email.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "Please enter service email") {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else if (response == "no") {


                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>This email is not registered.</label> <hr>",
                    showConfirmButton: true
                });


            } else {

                document.getElementById("admin-signIn-password-div").classList.remove("d-none");
                document.getElementById("admin-signIn-password").focus();

            }



        }
    }

    request.open("POST", "admin-email-checking-process.php", true);
    request.send(form);

}

function admin_signIn() {

    var email = document.getElementById("admin-signIn-email");
    var password = document.getElementById("admin-signIn-password");

    var form = new FormData();
    form.append("email", email.value);
    form.append("password", password.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response != "success") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                window.location = "admin-dashboard.php";
            }

        }
    }

    request.open("POST", "admin-signIn-process.php", true);
    request.send(form);

}


function loadChart() {

    var daily_incom_chart = document.getElementById("daily_income");
    var brand_product = document.getElementById("brand_product");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            var json = JSON.parse(response);

            new Chart(daily_incom_chart, {
                type: 'polarArea',
                data: {
                    labels: json.daily_lables,
                    datasets: [{
                        label: '# of Votes',
                        data: json.daily_data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(brand_product, {
                type: 'pie',
                data: {
                    labels: json.brand_name_lables,
                    datasets: [{
                        label: 'Number of models',
                        data: json.brand_has_model_data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        }
    }

    request.open("GET", "load-chart-process.php", true);
    request.send();

}

function admin_logOut() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                window.location = "create-or-signIn.php";
            }

        }
    }

    request.open("GET", "admin-logOut-process.php", true);
    request.send();

}

function load_manage_products() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("admin-product-section").innerHTML = response;

        }
    }

    request.open("GET", "load-manage-products-process.php", true);
    request.send();

}

function change_product_status(productId) {

    var status = document.getElementById(productId).checked;

    var form = new FormData();
    form.append("productId", productId);
    form.append("status", status);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                load_manage_products();

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>You must be logged in to access this action.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "change-product-status-process.php", true);
    request.send(form);

}

function admin_search_product() {

    var product_name = document.getElementById("admin-product-name").value;

    var form = new FormData();
    form.append("productName", product_name);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("admin-product-section").innerHTML = response;
        }
    }

    request.open("POST", "admin-search-product-process.php", true);
    request.send(form);

}

function load_addProduct_category() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("product-category").innerHTML = response;

        }
    }

    request.open("GET", "load-addProduct-category-process.php", true);
    request.send();

}

function load_addProduct_brand() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("product-brand").innerHTML = response;

        }
    }


    request.open("GET", "load-addProduct-brand-process.php", true);
    request.send();

}

var cModal;
function open_add_category_modal() {
    var categoryModal = document.getElementById("add-category-modal");
    cModal = new bootstrap.Modal(categoryModal);
    cModal.show();
}

function add_new_category() {

    var category_name = document.getElementById("category-name");
    var category_icon = document.getElementById("category-icon");

    var form = new FormData();
    form.append("categoryName", category_name.value);
    form.append("categoryIcon", category_icon.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {

                load_addProduct_category();
                cModal.hide();
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Category Added Successfully."
                });

                category_name.value = "";
                category_icon.value = "";


            } else if (response == "This category already exists.") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }
            else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "add-new-category-process.php", true);
    request.send(form);

}

var bModal;
function open_add_brand_modal() {
    var brandModal = document.getElementById("add-brand-modal");
    bModal = new bootstrap.Modal(brandModal);
    bModal.show();
}

function add_new_brand() {

    var brand_name = document.getElementById("brand-name");
    var brand_image = document.getElementById("brand-image");

    var form = new FormData();
    form.append("brandName", brand_name.value);
    form.append("brandImage", brand_image.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_addProduct_brand();
                bModal.hide();
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Brand Added Successfully."
                });

                brand_name.value = "";
                brand_image.value = "";

            } else if (response == "This Brand already exists.") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "add-new-brand-process.php", true);
    request.send(form);

}

function select_product_image() {

    var image = document.getElementById("product-image");

    var file = image.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("preview-product-image").src = url;

}

function select_background_image() {

    var image = document.getElementById("product-background-image");

    var file = image.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("preview-background-image").src = url;

}

function add_new_product() {

    var product_name = document.getElementById("product-title");
    var product_category = document.getElementById("product-category");
    var product_brand = document.getElementById("product-brand");
    var product_model = document.getElementById("product-model-name");
    var product_condition = document.getElementById("product-condition");
    var product_description = document.getElementById("product-description");
    var product_price = document.getElementById("product-price");
    var product_quantity = document.getElementById("product-quantity");
    var delivery_fee = document.getElementById("product-delivery-fee");
    var product_image = document.getElementById("product-image");
    var product_background_image = document.getElementById("product-background-image");

    var form = new FormData();
    form.append("productName", product_name.value);
    form.append("categoryId", product_category.value);
    form.append("brandId", product_brand.value);
    form.append("modelName", product_model.value);
    form.append("condition", product_condition.value);
    form.append("description", product_description.value);
    form.append("price", product_price.value);
    form.append("quantity", product_quantity.value);
    form.append("deliveryFee", delivery_fee.value);
    form.append("productImage", product_image.files[0]);
    form.append("productBackgroundImage", product_background_image.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                Swal.fire({
                    icon: "success",
                    title: "New Product Added Successfully.",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location = "manage-product.php";
                });

            } else if (response == "Product Not Added") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else if (response == "This product already exists") {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "add-new-product-process.php", true);
    request.send(form);


}

function load_users() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("load-user-section").innerHTML = response;

        }

    }

    request.open("GET", "load-manage-users-process.php", true);
    request.send();

}

function change_user_status(email) {

    var status = document.getElementById(email).checked;

    var form = new FormData();
    form.append("email", email);
    form.append("status", status);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_users();
            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>You must be logged in to access this action.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("POST", "change-user-status-process.php", true);
    request.send(form);

}

function admin_search_users() {

    var search_user = document.getElementById("user-name").value;

    var form = new FormData();
    form.append("searchUser", search_user);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("load-user-section").innerHTML = response;
        }
    }

    request.open("POST", "admin-search-users-process.php", true);
    request.send(form);

}


function select_update_product_image() {

    var image = document.getElementById("update-product-image");

    var file = image.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("preview-update-product-image").src = url;

}

function select_update_background_image() {

    var image = document.getElementById("update-product-background-image");

    var file = image.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("preview-update-background-image").src = url;

}

function update_product(productId) {

    var title = document.getElementById("product-title").value;
    var description = document.getElementById("update-product-description").value;
    var price = document.getElementById("update-product-price").value;
    var quantity = document.getElementById("update-product-quantity").value;
    var deliveryFee = document.getElementById("update-product-delivaryFee").value;
    var productImage = document.getElementById("update-product-image").files[0];
    var backgroundImage = document.getElementById("update-product-background-image").files[0];

    var form = new FormData();

    form.append("productId", productId);
    form.append("title", title);
    form.append("description", description);
    form.append("price", price);
    form.append("quantity", quantity);
    form.append("deliveryFee", deliveryFee);
    form.append("productImage", productImage);
    form.append("backgroundImage", backgroundImage);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Product updated successfully.",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location = "manage-product.php";
                });

            } else if (response == "Product not found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>Product not found</label> <hr>",
                    showConfirmButton: true
                });

            } else {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }
        }
    }

    request.open("POST", "update-product-process.php", true);
    request.send(form);

}


var cModal;
function add_color_modal(productId) {

    var colorModal = document.getElementById("add-color-modal");
    cModal = new bootstrap.Modal(colorModal);

    document.getElementById("add-color-button").onclick = function () {
        add_color(productId);
    }

    cModal.show();
    load_color_list(productId);
    load_color();

}

function load_color_list(productId) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "Something went wrong" || response == "Product Not Found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {

                document.getElementById("color-list").innerHTML = response;
            }


        }
    }

    request.open("GET", "load-color-list-process.php?id=" + productId, true);
    request.send();

}

function load_color() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "Something went wrong" || response == "Product Not Found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {

                document.getElementById("load-color-select").innerHTML = response;
            }

        }
    }

    request.open("GET", "load-color-process.php", true);
    request.send();

}

function add_color(productId) {

    var color = document.getElementById("load-color-select");

    var form = new FormData();
    form.append("productId", productId);
    form.append("color", color.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_color_list(productId);
            } else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }
        }
    }

    request.open("POST", "add-color-process.php", true);
    request.send(form);

}


function add_new_color() {

    var color = document.getElementById("add-color-input");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_color();
                Swal.fire({
                    icon: "success",
                    title: "Color added successfully.",
                    showConfirmButton: false,
                    timer: 1500
                });
                color.value = "";

            } else if (response == "This color already exists.") {

                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "<label for='' class='fw-bold fs-1'>Warning !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }

    request.open("GET", "add-new-color-process.php?colorName=" + color.value, true);
    request.send();

}

// function load_chat_list() {

//     var request = new XMLHttpRequest();
//     request.onreadystatechange = function () {
//         if (request.readyState == 4 && request.status == 200) {
//             var response = request.responseText;

//             document.getElementById("load-chat-list-div").innerHTML = response;
//         }
//     }

//     request.open("GET", "load-chat-list-process.php", true);
//     request.send();

// }


function load_chat_list() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {

        if (request.readyState == 4 && request.status == 200) {

            var response = request.responseText;

            document.getElementById("load-chat-list-div").innerHTML = response;

            if (response.includes("Empty-Chat-List.png")) {

                document.getElementById("load-chat-msg-div").innerHTML = `
                
                    <div class="col-12" style="margin-top: 300px;">
                        <div class="row justify-content-center">
                            <div class="col-11 text-center">
                                <img src="images/icon/Chat.png" class="col-8 col-md-4 col-lg-2" alt=""><br>
                                <h4 class="fw-bold text-secondary mt-4">No message here yet . . .</h4>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
    };

    request.open("GET", "load-chat-list-process.php", true);
    request.send();
}


function load_chat(customerEmail) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "Something went wrong" || response == "Customer not found") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            } else {
                document.getElementById("load-chat-msg-div").innerHTML = response;
            }

        }
    }

    request.open("GET", "load-admin-chat-process.php?customerEmail=" + customerEmail, true);
    request.send();

    chat_list_status_change(customerEmail);

}

function chat_list_status_change(customerEmail) {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_chat_list();
            } else {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }


    request.open("GET", "chat-list-status-change-process.php?customerEmail=" + customerEmail, true);
    request.send();

}

function search_chat_list() {

    var search = document.getElementById("customers-name").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("load-chat-list-div").innerHTML = response;
        }
    }

    request.open("GET", "search-chat-list-process.php?search=" + search, true);
    request.send();

}

function admin_send_message(email) {

    var message = document.getElementById("admin-send-message");

    var form = new FormData();
    form.append("email", email);
    form.append("message", message.value);


    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                load_chat(email);
                load_chat_list();
                message.value = "";
            } else {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });

            }

        }
    }

    request.open("POST", "admin-send-message-process.php", true);
    request.send(form);

}

function load_manage_order() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("admin-order-section").innerHTML = response;

        }
    }

    request.open("GET", "load-manage-order-process.php", true);
    request.send();

}

function search_admin_order() {

    var search = document.getElementById("admin-product-name").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            document.getElementById("admin-order-section").innerHTML = response;
        }
    }

    request.open("GET", "search-admin-order-process.php?search=" + search, true);
    request.send();

}

function change_order_status(orderId, status) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "success") {
                window.location.reload();

            } else if (response == "login") {

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>You must be logged in to access this action.</label> <hr> <a href='create-or-signIn.php' class='text-dark fw-bold'>Log In <i class='bi bi-chevron-double-right'></i></a>",
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "<label for='' class='fw-bold fs-1'>Oops !</label>",
                    html: "<label>" + response + "</label> <hr>",
                    showConfirmButton: true
                });
            }

        }
    }


    request.open("GET", "change-order-status-process.php?orderId=" + orderId + "&status=" + status, true);
    request.send();

}

function print_customer_report() {

    var originalContent = document.body.innerHTML;
    var printContent = document.getElementById("report-section").innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;

}

//Right-click-disable
document.addEventListener('contextmenu', function (event) {
    event.preventDefault();
});
//Right-click-disable

function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.querySelector('.toggle-btn');

    sidebar.classList.toggle('hide');
    mainContent.classList.toggle('full-width');
    toggleBtn.classList.toggle('move-left');
}