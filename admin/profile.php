<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$admin_username = $_SESSION['admin'];

// Lấy thông tin admin từ DB
$sql = "SELECT * FROM admin WHERE username = '$admin_username' LIMIT 1";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ Admin | VTi Restaurant</title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background: #f5f6fa; }

        #page-wrapper {
            background: #fff;
            padding: 30px;
            margin-top: 20px;
            border-radius: 6px;
        }

        .profile-box {
            max-width: 600px;
            margin: auto;
        }

        .profile-icon {
            font-size: 80px;
            color: #337ab7;
        }
    </style>
</head>
<body>

<!-- ===== HEADER ===== -->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> VTi Restaurant Admin
            </a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="index.php"><i class="bi bi-house"></i> Trang chủ</a></li>
            <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
            <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="active">
                <a href="profile.php">
                    <i class="bi bi-person-circle"></i>
                    <?= $admin_username ?>
                </a>
            </li>
            <li>
                <a href="logout.php" class="text-danger">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- ===== CONTENT ===== -->
<div class="container">
    <div id="page-wrapper" class="profile-box text-center">
        <i class="bi bi-person-circle profile-icon"></i>
        <h2 class="text-primary">Hồ sơ quản trị viên</h2>
        <hr>

        <table class="table table-bordered">
            <tr>
                <th width="40%">Tên đăng nhập</th>
                <td><?= $admin['username'] ?></td>
            </tr>
            <tr>
                <th>Vai trò</th>
                <td>Administrator</td>
            </tr>
            <tr>
                <th>Ngày truy cập</th>
                <td><?= date('d/m/Y H:i:s') ?></td>
            </tr>
        </table>

        <a href="index.php" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Quay lại trang chủ
        </a>

    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="text-center" style="margin-top:30px; color:#777;">
    © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by <span class="text-danger">Vanw Tít</span>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
