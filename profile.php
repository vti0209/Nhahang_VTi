<?php
session_start();

// 1. Cấu hình kết nối
$host = "localhost";
$user = "root";
$password = "";
$database = "fashion_mylishop";

$conn = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($conn, 'UTF8');

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

// 2. Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

$u = $_SESSION['username'];

// 3. Truy vấn dữ liệu từ bảng 'users' (Đã sửa theo ảnh của bạn)
$sql = "SELECT * FROM users WHERE username = '$u'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Không tìm thấy thông tin tài khoản '$u' trong bảng users.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ cá nhân - <?php echo $row['username']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .profile-box { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 400px; }
        .profile-box h2 { text-align: center; color: #d9534f; margin-bottom: 25px; text-transform: uppercase; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px; }
        .info-row { margin-bottom: 15px; font-size: 16px; border-bottom: 1px solid #f9f9f9; padding-bottom: 8px; }
        .label { font-weight: bold; color: #555; width: 120px; display: inline-block; }
        .value { color: #333; }
        .actions { text-align: center; margin-top: 30px; }
        .btn { text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; transition: 0.3s; }
        .btn-home { background: #eee; color: #333; margin-right: 10px; }
        .btn-edit { background: #d9534f; color: blue; color: white !important; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>

<div class="profile-box">
    <h2>Thông tin tài khoản</h2>
    
    <div class="info-row">
        <span class="label">Username:</span>
        <span class="value"><?php echo $row['username']; ?></span>
    </div>

    <div class="info-row">
        <span class="label">Họ và tên:</span>
        <span class="value"><?php echo isset($row['fullname']) ? $row['fullname'] : (isset($row['name']) ? $row['name'] : 'Chưa cập nhật'); ?></span>
    </div>

    <div class="info-row">
        <span class="label">Email:</span>
        <span class="value"><?php echo isset($row['email']) ? $row['email'] : 'Chưa cập nhật'; ?></span>
    </div>

    <div class="info-row">
        <span class="label">Điện thoại:</span>
        <span class="value"><?php echo isset($row['phone']) ? $row['phone'] : 'Chưa cập nhật'; ?></span>
    </div>

    <div class="actions">
        <a href="index.php" class="btn btn-home">Trang chủ</a>
        <a href="edit_profile.php" class="btn btn-edit">Sửa thông tin</a>
    </div>
</div>

</body>
</html>