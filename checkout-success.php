<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; 

function connect_db() {
    $host = 'localhost';
    $db = 'fashion_mylishop';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES     => false,
    ];
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        error_log("Lỗi kết nối CSDL: " . $e->getMessage());
        return null;
    }
}

// Hàm gửi email xác nhận đơn hàng
function send_order_confirmation($recipient_email, $recipient_name, $order_id) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hotrai84@gmail.com'; 
        $mail->Password   = 'ptjr uekf eptt uhgw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Người gửi và Người nhận
        $mail->setFrom('hotrai84@gmail.com', 'VTi Restaurant - Xác Nhận Đơn Hàng');
        $mail->addAddress($recipient_email, $recipient_name); 

        // Nội dung Email
        $mail->isHTML(true);
        $mail->Subject = '🎉 Xác Nhận Đơn Hàng Thành Công - Mã #' . $order_id;
        $mail->Body    = "
            <h2>Xác Nhận Đặt Hàng Thành Công!</h2>
            <p>Chào $recipient_name,</p>
            <p>Đơn hàng của bạn đã được tiếp nhận thành công tại VTi Restaurant.</p>
            
            <p style='font-size: 16px; font-weight: bold;'>Mã đơn hàng của bạn là: <span style='color: #2ecc71;'>#$order_id</span></p>
            
            <p>Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
            
            <p>Cảm ơn bạn đã tin tưởng VTi Restaurant!</p>
            <p>Trân trọng,<br>
            Đội ngũ VTi</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Gửi mail xác nhận đơn hàng thất bại: {$mail->ErrorInfo}");
        return false;
    }
}


// --- LOGIC XỬ LÝ ĐẶT HÀNG ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Nếu không phải phương thức POST, chuyển hướng về giỏ hàng
    header("Location: view-cart.php");
    exit();
}
// 1. Thu thập thông tin khách hàng từ POST
$customer_name  = trim($_POST['fullname'] ?? 'Khách Hàng');
$customer_email = trim($_POST['email'] ?? ''); // Lấy email từ form
$customer_phone = trim($_POST['phone'] ?? '');
$customer_address = trim($_POST['address'] ?? '');
$customer_note  = trim($_POST['note'] ?? '');

// 2. Tạo mã đơn hàng ngẫu nhiên
$order_id = rand(100000, 999999);

// 3. Xử lý logic tính tổng tiền và lưu Đơn hàng vào CSDL
$total_amount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
}
// *** LƯU Ý QUAN TRỌNG: Bạn cần thêm logic kết nối CSDL tại đây
// *** và lưu toàn bộ dữ liệu đơn hàng (customer_name, customer_email, total_amount, v.v.)
// *** vào bảng `orders` và `order_details` trước khi xóa giỏ hàng.
//
// Ví dụ (chưa hoàn chỉnh):
/*
$db = connect_db();
if ($db) {
    $stmt = $db->prepare("INSERT INTO orders (order_code, total, name, email, phone, address, note) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$order_id, $total_amount, $customer_name, $customer_email, $customer_phone, $customer_address, $customer_note]);
    // Lấy ID đơn hàng vừa tạo để lưu chi tiết sản phẩm
    $last_order_id = $db->lastInsertId(); 
    // ... logic lưu chi tiết đơn hàng từ $_SESSION['cart'] vào bảng order_details
}
*/

// 4. GỬI EMAIL XÁC NHẬN ĐƠN HÀNG
$email_sent = false;
if (!empty($customer_email)) {
    $email_sent = send_order_confirmation($customer_email, $customer_name, $order_id);
}

// 5. Xóa giỏ hàng sau khi đặt thành công
unset($_SESSION['cart']);

// Hiển thị kết quả cho người dùng
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công - VTi Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .box {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .box h2 {
            color: #27ae60;
        }
        .box p {
            font-size: 16px;
            color: #333;
        }
        .box .order-id {
            font-weight: bold;
            margin-top: 20px;
        }
        .box .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>

</head>
<body>
    <div class="box">
        <h2>🎉 Đặt Hàng Thành Công!</h2>
        <p>Cảm ơn <strong><?php echo htmlspecialchars($customer_name); ?></strong> đã đặt hàng tại VTi Restaurant.</p>
        <p class="order-id">Mã đơn hàng của bạn là: <span style="color: #e67e22;">#<?php echo $order_id; ?></span></p>
        <?php if ($email_sent): ?>
            <div class="alert-success">
                Thông xin xác nhận của bạn đã được gửi đến <strong><?php echo htmlspecialchars($customer_email); ?></strong>.
            </div>
        <?php else: ?>
            <div class="alert-error">
                ! Không thể gửi email xác nhận đơn hàng. Vui lòng kiểm tra lại địa chỉ email của bạn.
            </div>
        <?php endif; ?>
        <a href="index.php" class="btn">Quay về Trang Chủ</a>
    </div>
</body>
</html>