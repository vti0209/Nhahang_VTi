<?php
session_start();
require_once('../model/connect.php');

$error = "";

/* Nếu đã đăng nhập thì vào admin */
if (isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* Xử lý login */
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin
            WHERE username='$username'
            AND password='$password'
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi SQL: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #1d2671, #c33764);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-box {
    width: 380px;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
}
.login-box h3 {
    font-weight: bold;
    margin-bottom: 20px;
}
</style>
</head>
<body>

<div class="login-box">
    <h3 class="text-center text-danger">
        <i class="bi bi-shield-lock-fill"></i> ADMIN LOGIN
    </h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Tài khoản</label>
            <input type="text" name="username"
                   class="form-control" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password"
                   class="form-control" required>
        </div>

        <button type="submit" name="login"
                class="btn btn-danger btn-block">
            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
        </button>
        <a href="../index.php" class="btn btn-default btn-block">
            <i class="bi bi-arrow-left-circle"></i> Trở lại trang người dùng
        </a>
    </form>
</div>

</body>
</html>
