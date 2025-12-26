<?php

include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "mail/PHPMailer.php";
require "mail/SMTP.php";
require "mail/Exception.php";

$emailOrMobile = $_GET["em"];

echo($emailOrMobile);


$resultSet =  Database::search("SELECT * FROM `user` WHERE `email`='" . $emailOrMobile . "' OR `mobile`='" . $emailOrMobile . "'");
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
    $mail->addAddress($userData["email"]);

    $mail->isHTML(true);
    $mail->Subject = 'Nexxo Tech account password has been reset.';
   $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Successful</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f7fb;
font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0; background-color:#f5f7fb;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:14px;
                    box-shadow:0 6px 18px rgba(0,0,0,0.08); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color:#dfdfdfff; padding:28px;">
                            <img src="https://nexxotechlogo.netlify.app/NexxoTech.png" height="60" alt="Nexxo Tech">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:32px; color:#333333;">

                            <h2 style="margin-top:0; font-size:24px; font-weight:700;">
                                Password Reset Successful. ✅
                            </h2>

                            <p style="font-size:15px; margin:0;">
                                Hello ! <b>' . $userData["fname"] . ' ' . $userData["lname"] . '</b>,
                            </p>

                            <p style="font-size:14px; color:#0066ff; font-weight:600; margin:4px 0 16px 0;">
                                ' . $userData["email"] . '
                            </p>

                            <p style="font-size:15px; line-height:1.6;">
                                Your Nexxo Tech account password has been successfully reset.
                                You can now log in using your new password.
                            </p>

                            <div style="margin:20px 0; padding:16px;
                                background-color:#f0f7ff;
                                border-left:4px solid #0d6efd;
                                border-radius:8px;">

                                <p style="font-size:14px; margin:0; line-height:1.6;">
                                    ⚠️ If you did not perform this action or suspect unauthorized access,
                                    please reset your password immediately using the
                                    <b>"Forgot Password"</b> option or contact our support team.
                                </p>
                            </div>

                            <p style="font-size:14px; margin-top:24px;">
                                Best regards,<br>
                                <b>Nexxo Tech Support Team</b>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color:#f1f1f1;
                        padding:18px; font-size:12px; color:#777;">
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
