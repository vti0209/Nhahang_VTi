<?php
session_start();

// 1. Kết nối Database
$host = "localhost";
$user = "root";
$password = "";
$database = "fashion_mylishop";

$conn = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($conn, 'UTF8');

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// 2. Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$u = $_SESSION['username'];

// 3. Lấy dữ liệu hiện tại để hiện lên form
$sql_old = "SELECT * FROM users WHERE username = '$u'";
$res_old = mysqli_query($conn, $sql_old);
$row = mysqli_fetch_assoc($res_old);

// 4. Xử lý khi nhấn nút Lưu (POST)
if (isset($_POST['btnUpdate'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Cập nhật vào bảng users (Bạn kiểm tra lại tên cột trong DB của mình nhé)
    $sql_update = "UPDATE users SET fullname='$fullname', email='$email', phone='$phone' WHERE username='$u'";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='profile.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa hồ sơ</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; padding-top: 50px; }
        .edit-box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 350px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #666; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-save { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn-save:hover { background: #218838; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>SỬA THÔNG TIN</h2>
    <form method="POST">
        <div class="form-group">
            <label>Tên đăng nhập:</label>
            <input type="text" value="<?php echo $row['username']; ?>" disabled style="background: #eee;">
        </div>
        <div class="form-group">
            <label>Họ và tên:</label>
            <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" value="<?php echo $row['phone']; ?>">
        </div>
        <button type="submit" name="btnUpdate" class="btn-save">Lưu thay đổi</button>
        <a href="profile.php" class="back-link">Hủy và quay lại</a>
    </form>
</div>

</body>
</html>