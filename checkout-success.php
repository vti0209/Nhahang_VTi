<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; 

// Hàm kết nối CSDL sử dụng PDO
function connect_db() {
    $host = 'localhost';
    $db = 'restaurant_vtiet27a';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
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

        $mail->setFrom('hotrai84@gmail.com', 'VTi Restaurant - Xác Nhận Đơn Hàng');
        $mail->addAddress($recipient_email, $recipient_name); 

        $mail->isHTML(true);
        $mail->Subject = '🎉 Xác Nhận Đơn Hàng Thành Công - Mã #' . $order_id;
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif;'>
                <h2>Xác Nhận Đặt Hàng Thành Công!</h2>
                <p>Chào $recipient_name,</p>
                <p>Đơn hàng của bạn đã được tiếp nhận thành công tại VTi Restaurant.</p>
                <p style='font-size: 16px; font-weight: bold;'>Mã đơn hàng của bạn là: <span style='color: #2ecc71;'>#$order_id</span></p>
                <p>Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
                <p>Cảm ơn bạn đã tin tưởng VTi Restaurant!</p>
                <hr>
                <p>Trân trọng,<br>Đội ngũ VTi Restaurant</p>
            </div>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Gửi mail xác nhận đơn hàng thất bại: {$mail->ErrorInfo}");
        return false;
    }
}

// --- LOGIC XỬ LÝ ĐẶT HÀNG ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['cart'])) {
    header("Location: view-cart.php");
    exit();
}

$db = connect_db();
if (!$db) die("Không thể kết nối CSDL.");

// 1. Thu thập thông tin khách hàng
$customer_name    = trim($_POST['fullname'] ?? 'Khách Hàng');
$customer_email   = trim($_POST['email'] ?? '');
$customer_phone   = trim($_POST['phone'] ?? '');
$customer_address = trim($_POST['address'] ?? '');

// --- MỚI: TẠO MÃ HIỂN THỊ NGẪU NHIÊN 8 SỐ ---
$display_id = rand(10000000, 99999999);

// 2. Tính tổng tiền (Khớp logic giảm giá với checkout.php)
$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    $saleprice = isset($item['saleprice']) ? $item['saleprice'] : 0;
    if ($saleprice > 0) {
        $final_price = $item['price'] - ($item['price'] * ($saleprice / 100));
    } else {
        $final_price = $item['price'];
    }
    $total_amount += $final_price * $item['quantity'];
}

// 3. Xử lý User (Lấy ID hoặc tạo mới nếu chưa có)
$stmt = $db->prepare("SELECT id FROM users WHERE email = ? OR phone = ? LIMIT 1");
$stmt->execute([$customer_email, $customer_phone]);
$user = $stmt->fetch();

if ($user) {
    $user_id = $user['id'];
} else {
    $stmt = $db->prepare("INSERT INTO users (fullname, email, phone, address, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$customer_name, $customer_email, $customer_phone, $customer_address, $customer_email, md5('123456')]);
    $user_id = $db->lastInsertId();
}

// 4. Lưu vào bảng `orders` (Giữ nguyên logic id tự tăng để Admin quản lý đơn hàng cũ không lỗi)
$date_order = date('Y-m-d H:i:s');
$stmt = $db->prepare("INSERT INTO orders (total, date_order, status, user_id) VALUES (?, ?, ?, ?)");
$stmt->execute([$total_amount, $date_order, 0, $user_id]);
$new_order_id = $db->lastInsertId();

// 5. Lưu chi tiết sản phẩm vào bảng `product_order`
$stmt_detail = $db->prepare("INSERT INTO product_order (product_id, order_id, quantity) VALUES (?, ?, ?)");
foreach ($_SESSION['cart'] as $product_id => $item) {
    $stmt_detail->execute([$product_id, $new_order_id, $item['quantity']]);
}

// 6. GỬI EMAIL XÁC NHẬN dùng mã hiển thị ngẫu nhiên
$email_sent = false;
if (filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    $email_sent = send_order_confirmation($customer_email, $customer_name, $display_id);
}

// 7. Xóa giỏ hàng
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt Hàng Thành Công - VTi Restaurant</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .box { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 600px; margin: 50px auto; text-align: center; }
        .box h2 { color: #27ae60; }
        .order-id { font-weight: bold; font-size: 20px; margin-top: 20px; }
        .btn { display: inline-block; margin-top: 30px; padding: 10px 25px; background-color: #27ae60; color: #fff; text-decoration: none; border-radius: 5px; }
        .alert-success { color: #155724; background-color: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px; border: 1px solid #c3e6cb; }
        .alert-error { color: #721c24; background-color: #f8d7da; padding: 15px; border-radius: 5px; margin-top: 20px; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="box">
        <h2>🎉 Đặt Hàng Thành Công!</h2>
        <p>Cảm ơn <strong><?= htmlspecialchars($customer_name) ?></strong> đã tin dùng sản phẩm của chúng tôi.</p>
        
        <p class="order-id">Mã đơn hàng của bạn là: <span style="color: #e67e22;">#<?= $display_id ?></span></p>
        
        <?php if ($email_sent): ?>
            <div class="alert-success">
                Hệ thống đã gửi email xác nhận chi tiết đến: <strong><?= htmlspecialchars($customer_email) ?></strong>.
            </div>
        <?php else: ?>
            <div class="alert-error">
                Có lỗi nhỏ khi gửi email, nhưng đừng lo! Đơn hàng của bạn đã được lưu lại thành công.
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="btn">Tiếp tục mua sắm</a>
    </div>
</body>
</html>