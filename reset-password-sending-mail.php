<?php

include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "mail/PHPMailer.php";
require "mail/SMTP.php";
require "mail/Exception.php";

$emailOrMobile = $_GET["email"];

if (empty($emailOrMobile)) {
    echo ("Enter email address or mobile.");
} else {

    $resultSet =  Database::search("SELECT * FROM `user` WHERE `email`='" . $emailOrMobile . "' OR `mobile`='" . $emailOrMobile . "'");
    $numRows = $resultSet->num_rows;

    if ($numRows == 1) {

        $userData = $resultSet->fetch_assoc();

        $VerificationCode = rand(000000, 999999);

        Database::iud("UPDATE `user` SET `verification_code`='" . $VerificationCode . "' WHERE `email`='" . $emailOrMobile . "' OR `mobile`='" . $emailOrMobile . "'");

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
            $mail->addAddress($userData["email"]);

            $mail->isHTML(true);
            $mail->Subject = 'Reset your Nexxo Tech account password.';
          $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f7fb; font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0; background-color:#f5f7fb;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:14px; box-shadow:0 6px 18px rgba(0,0,0,0.08); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color:#dfdfdfff; padding:28px;">
                            <img src="https://nexxotechlogo.netlify.app/NexxoTech.png" height="60" alt="Nexxo Tech">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:32px; color:#333333;">

                            <h1 style="margin-top:0; font-size:24px; font-weight:700;">
                                Password Reset Verification. 🔐
                            </h1>

                            <p style="font-size:15px; line-height:1.6; margin:0;">
                                Hello ! <b>' . $userData["fname"] . ' ' . $userData["lname"] . '</b>,
                            </p>

                           <p style="font-size:14px; color:#0066ff !important; font-weight:600; margin:0;">
                                ' . $userData["email"] . '
                            </p>

                            <p style="font-size:15px; line-height:1.6;">
                                We received a request to reset your Nexxo Tech account password.
                                Please use the verification code below to complete the process.
                            </p>

                            <!-- OTP Box -->
                            <div style="margin:28px 0; text-align:center;">
                                <div style="display:inline-block; padding:14px 28px;
                                    background-color:#f0f7ff;
                                    border-radius:12px;
                                    border:1px dashed #0d6efd;">
                                    <span style="font-size:32px; letter-spacing:4px;
                                        font-weight:700; color:#0d6efd;">
                                        ' . $VerificationCode . '
                                    </span>
                                </div>
                            </div>

                            <p style="font-size:14px; line-height:1.6;">
                                This code is valid for a limited time.  
                                If you did not request a password reset, please ignore this email.
                            </p>

                            <p style="font-size:14px; margin-top:24px;">
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
           
            echo 'The verification code has been sent to your email address, please check it';
        } catch (Exception $e) {
          
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo ("An invalid email address or mobile phone number");
    }
}
