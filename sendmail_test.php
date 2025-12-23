<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // thiết lập máy chủ SMTP
    $mail->SMTPAuth   = true; // bật xác thực SMTP
    $mail->Username   = 'hotrai84@gmail.com'; 
    $mail->Password   = 'ptjr uekf eptt uhgw'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('hotrai84@gmail.com', 'VTi Restaurant');
    $mail->addAddress('Tiet.ho27@student.passerellesnumeriques.org');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Test PHPMailer';
    $mail->Body    = 'Gửi mail thành công với PHPMailer!';

    $mail->send();
    echo 'Mail gửi thành công!';
} catch (Exception $e) {
    echo "Gửi mail thất bại: {$mail->ErrorInfo}";
}