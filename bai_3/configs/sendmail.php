<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
function send($mailR)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration for Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'quochiep1406@gmail.com'; // Replace with your Gmail email address
        $mail->Password = 'qqhfznbctwdmrhkh';  // Replace with your Gmail password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email content
        $mail->setFrom('quochiep1406@gmail.com', 'Hoàng Quốc Hiệp');
        $mail->addAddress($mailR, 'Recipient Name');
        $mail->Subject = 'Notify';
        $mail->Body = 'Đăng ký thành công tài khoản.';

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }

}

?>
