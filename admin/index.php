<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

/* ===== THỐNG KÊ ===== */
$totalProduct  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM products"))[0];
$totalCategory = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM categories"))[0];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ | Admin</title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background: #f5f6fa; }

        .navbar-admin {
            border-radius: 0;
            margin-bottom: 20px;
        }

        /* ===== DASHBOARD BOX ===== */
        .dash-box {
            background: #fff;
            border-radius: 6px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,.08);
            text-align: center;
        }
        .dash-box i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .dash-box h2 {
            margin: 10px 0;
            font-weight: bold;
        }
        .dash-box p {
            color: #777;
        }

        .footer-admin {
            background: #f8f9fa;
            padding: 20px;
            margin-top: 40px;
            border-top: 2px solid #ddd;
        }
    </style>
</head>
<body>

<!-- ===== HEADER ===== -->
<nav class="navbar navbar-inverse navbar-admin">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php" style="padding: 5px 15px;">
                <img src="../images/logohong.png"
                    alt="VTi Restaurant"
                    style="height:40px; display:inline-block;">
                <span style="color:#fff; font-weight:bold; margin-left:8px;">
                    VTi Restaurant Admin
                </span>
            </a>
        </div>

        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php"><i class="bi bi-house"></i> Trang chủ Admin</a></li>
            <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
            <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
            <li><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    <?= $_SESSION['admin'] ?? 'Admin VTi Restaurant' ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="logout.php" class="text-danger">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- ===== DASHBOARD CONTENT ===== -->
<div class="container-fluid">
    <h2 class="text-primary">_Quản trị viên VTi Restaurant_</h2>
    <p class="text-muted">Chào mừng bạn quay lại hệ thống quản trị.</p>

    <div class="row">
        <div class="col-md-3">
            <div class="dash-box">
                <i class="bi bi-box-seam text-danger"></i>
                <h2><?= $totalProduct ?></h2>
                <p>Ẩm Thực</p>
                <a href="product.php" class="btn btn-danger btn-sm">Xem</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-box">
                <i class="bi bi-tags text-success"></i>
                <h2><?= $totalCategory ?></h2>
                <p>Danh mục</p>
                <a href="category.php" class="btn btn-success btn-sm">Xem</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-box">
                <i class="bi bi-plus-circle text-primary"></i>
                <h2>+</h2>
                <p>Thêm Món</p>
                <a href="product-add.php" class="btn btn-primary btn-sm">Thêm</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-box">
                <i class="bi bi-percent text-warning"></i>
                <h2>%</h2>
                <p>Khuyến mãi</p>
                <a href="promotion-back.php" class="btn btn-warning btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer-admin text-center">
    © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by <span class="text-danger"> Vanw Tít</span>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
