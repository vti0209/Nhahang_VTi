<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');
require_once(__DIR__ . '/../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['btn_update'])) {
    $order_id   = (int)$_POST['order_id'];      
    $order_code = $_POST['order_code']; 
    $status_val = (int)$_POST['status_val'];
    $email      = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $reason     = mysqli_real_escape_string($conn, $_POST['reason'] ?? "");

    $status_text = [
        0 => "Đang chờ xử lý", 1 => "Đã xác nhận", 2 => "Đang giao hàng",
        3 => "Sắp đến nơi", 4 => "Giao thành công", 5 => "Giao thất bại"
    ];

    // 1. Cập nhật trạng thái trong Database
    mysqli_query($conn, "UPDATE orders SET status = $status_val WHERE id = $order_id");

    // 2. Lấy THÔNG TIN CHI TIẾT (Tên người nhận và Món ăn) từ VIEW
    $fullname = "Quý khách"; 
    $items_html = "";
    
    // Truy vấn lấy cả tên người nhận và danh sách món
    $sql_data = "SELECT fullname, nameProduct, quantity FROM view_order_list WHERE idOrder = $order_id";
    $result_data = mysqli_query($conn, $sql_data);

    if ($result_data && mysqli_num_rows($result_data) > 0) {
        $items_html .= "<table border='1' cellpadding='10' style='border-collapse:collapse; width:100%; border: 1px solid #ddd;'>";
        $items_html .= "<tr style='background:#f8f8f8;'><th>Món ăn</th><th style='width:50px;'>SL</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result_data)) {
            $fullname = $row['fullname']; // Lấy tên người nhận từ dòng dữ liệu
            $items_html .= "<tr><td style='padding:8px;'>{$row['nameProduct']}</td><td align='center'>{$row['quantity']}</td></tr>";
        }
        $items_html .= "</table>";
    }

    $current_st = $status_text[$status_val];

    // 3. Gửi Mail chuyên nghiệp
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hotrai84@gmail.com'; 
        $mail->Password   = 'ptjr uekf eptt uhgw'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('hotrai84@gmail.com', 'VTi Restaurant');
        $mail->addAddress($email);
        $mail->isHTML(true);

        // Tiêu đề cá nhân hóa theo tên khách
        $mail->Subject = "Cập nhật đơn hàng của $fullname";

        $body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #d9534f; color: white; padding: 20px; text-align: center;'>
                <h2 style='margin: 0;'>VTi Restaurant</h2>
                <p style='margin: 5px 0 0;'>Thông báo từ hệ thống VTi</p>
            </div>

            <div style='padding: 20px; color: #333; line-height: 1.6;'>
                <p>Xin chào <strong>$fullname</strong>,</p>
                <p>Đơn hàng đã đặt của bạn tại VTi Restaurant đã được chuyển sang trạng thái mới:</p>
                
                <div style='background-color: #f9f9f9; border-left: 5px solid #d9534f; padding: 15px; margin: 20px 0;'>
                    <span style='font-size: 18px; color: #d9534f;'><strong>$current_st</strong></span>
                </div>

                <p><strong>Chi tiết món ăn của bạn:</strong></p>
                <div style='margin-bottom: 20px;'>
                    $items_html
                </div>";

                // Hiển thị lý do nếu thất bại
                if ($status_val == 5 && !empty($reason)) {
                    $body .= "
                    <div style='background-color: #fff1f0; border: 1px solid #ffa39e; padding: 10px; border-radius: 4px; color: #cf1322;'>
                        <strong>Lý do:</strong> $reason
                    </div>";
                }

        $body .= "
                <p style='margin-top: 25px; border-top: 1px solid #eee; padding-top: 15px;'>
                    Nếu có bất kỳ thắc mắc nào, hãy liên hệ hotline: <strong style='color:#d9534f;'>(+84) 373 532 152</strong>
                </p>
            </div>

            <div style='background-color: #f4f4f4; color: #777; padding: 15px; text-align: center; font-size: 12px;'>
                <p style='margin: 0;'>&copy; " . date('Y') . " VTi Restaurant. Thiết kế bởi Vanw Tít.</p>
                <p style='margin: 5px 0 0;'>Đà Nẵng, Việt Nam | Trân trọng!</p>
            </div>
        </div>";

        $mail->Body = $body;
        $mail->send();

        header("Location: order.php?msg=success");
        exit;
    } catch (Exception $e) {
        header("Location: order.php?msg=error");
        exit;
    }
}