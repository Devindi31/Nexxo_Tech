<?php

include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "mail/PHPMailer.php";
require "mail/SMTP.php";
require "mail/Exception.php";

$email = $_GET["email"];


$resultSet = Database::search("SELECT * FROM `user` WHERE `email`='$email'");
$userData = $resultSet->fetch_assoc();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'vithanagedevindi46@gmail.com';
    $mail->Password = 'vlslzmqfenbdswgs';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('vithanagedevindi46@gmail.com', 'Nexxo Tech');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Welcome to Nexxo Tech !';
    $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Nexxo Tech</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fb; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7fb; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:28px; background-color:#dfdfdfff;">
                            <img src="https://nexxotechlogo.netlify.app/NexxoTech.png" height="60" alt="Nexxo Tech Logo">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#333333;">
                            <h1 style="margin-top:0; font-size:24px; font-weight:700;">
                                Welcome to Nexxo Tech! 🎉
                            </h1>

                          <p style="font-size:15px; line-height:1.6; margin:0;">
                              Hello ! <b>' . $userData["fname"] . ' ' . $userData["lname"] . '</b>,
                          </p>

                         <p style="font-size:14px; color:#0066ff !important; font-weight:600; margin:0;">
                        ' . $email . '
                         </p>

                            <p style="font-size:15px; line-height:1.6;">
                                We are excited to have you on board! Your Nexxo Tech account has been successfully created,
                                and you can now enjoy a seamless online shopping experience with us.
                            </p>

                            <p style="font-size:15px; font-weight:600; margin-bottom:10px;">
                                  Here are a few things you can do with your new Nexxo Tech account:

                            </p>

                            <ul style="font-size:14px; line-height:1.8; padding-left:18px;">
                                <li><b>Browse & Shop :</b> Explore a wide range of quality products.</li>
                                <li><b>Save Favorites :</b> Keep track of products you love.</li>
                                <li><b>Track Orders :</b> Monitor your purchases from payment to delivery.</li>
                                <li><b>Exclusive Offers :</b> Get early access to promotions and discounts.</li>
                                <li><b>Personalized Picks :</b> Discover products recommended just for you.</li>
                            </ul>

                            <p style="font-size:14px; line-height:1.6;">
                               If you have any questions, concerns, or feedback, feel free to reach out to our customer support team. We are here to assist you every step of the way.
                            </p>

                            <p style="font-size:14px; line-height:1.6;">
                                Happy shopping and welcome once again!
                            </p>

                            <p style="margin-top:25px; font-size:14px;">
                                Best regards,<br>
                                <b>Nexxo Tech Support Team</b>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color:#f1f1f1; padding:18px; font-size:12px; color:#777;">
                            © ' . date("Y") . ' Nexxo Tech. All rights reserved.<br>
                            Follow us on social media <b>@NexxoTech</b>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
';


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
