<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../model/connect.php';

// Gọi autoload của Composer
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email    = $_POST['email'] ?? '';
    $address  = $_POST['address'] ?? '';
    $phone    = $_POST['phone'] ?? '';

    // Insert database
    $sql = "INSERT INTO users (fullname, username, password, email, phone, address, role)
            VALUES ('$fullname', '$username', md5('$password'), '$email', '$phone', '$address', 1)";

    $res = mysqli_query($conn,$sql);

    if ($res) {

        /* -----------------------------------
         *  GỬI EMAIL XÁC NHẬN ĐĂNG KÝ
         * ----------------------------------- */
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;

            // !!! THAY EMAIL VÀ APP PASSWORD CỦA BẠN TẠI ĐÂY !!!
            $mail->Username   = 'hotrai84@gmail.com';   
            $mail->Password   = 'ptjr uekf eptt uhgw';     

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
           

            // Người gửi
            $mail->setFrom('hotrai84@gmail.com', 'VTi Restaurant');

            // Người nhận
            $mail->addAddress($email, $fullname);

            // Nội dung email
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->Subject = "Chúc mừng tài khoản trải nghiệm mới tại VTi Restaurant!";
            $mail->Body    = "
                <h2>Xin chào $fullname!</h2>
                <p>Welcome Bạn đã đăng ký tài khoản tại <b>VTi Restaurant</b> thành công.</p>
                <p>Thông tin đăng ký:</p>
                <ul>
                    <li><b>Tên đăng nhập:</b> $username</li>
                    <li><b>Email:</b> $email</li>
                </ul>
                <p>Cảm ơn bạn đã sử dụng dịch vụ của VTi Restaurant_Nơi hương vị hòa quyện với sự thanh lịch!</p>
            ";

            $mail->send();

        } catch (Exception $e) {
            // Nếu lỗi email, vẫn cho phép đăng ký
            // echo "Mailer Error: {$mail->ErrorInfo}";
        }

        header("location:login.php?rs=success");
        exit();
    } 
    else {
        header("location:login.php?rf=fail");
        exit();
    }
}
?>