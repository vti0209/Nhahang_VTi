<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');
error_reporting(2);

/* ===== XÓA KHUYẾN MÃI ===== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM promotions WHERE id = $id");
    header("Location: promotion-back.php?ps=1");
    exit;
}

/* ===== ALERT ===== */
if (isset($_GET['ps'])) {
    echo "<script>alert('Xóa khuyến mãi thành công!');</script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khuyến mãi | Admin</title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background: #f5f6fa; }
        .navbar-admin { border-radius: 0; margin-bottom: 0; }
        #page-wrapper {
            background: #fff;
            padding: 20px;
            min-height: 500px;
        }
        .page-header { margin-top: 0; font-weight: bold; }
        .footer-admin {
            background: #f8f9fa;
            padding: 25px 15px;
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
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#admin-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" style="padding: 5px 15px;">
                <img src="../images/logohong.png"
                    alt="VTi Restaurant"
                    style="height:40px; display:inline-block;">
                <span style="color:#fff; font-weight:bold; margin-left:8px;">
                    VTi Restaurant Admin
                </span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="admin-navbar">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><i class="bi bi-house"></i> Trang chủ Admin</a></li>
                <li><a href="order.php"><i class="bi bi-cart4"></i> Đơn hàng</a></li>
                <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
                <li class="active"><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
                <li><a href="user.php"><i class="bi bi-people"></i> Người dùng User</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <?= $_SESSION['admin'] ?? 'Admin VTi Restaurant'; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php"><i class="bi bi-person"></i> Thông tin</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php" class="text-danger">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== CONTENT ===== -->
<div id="page-wrapper" class="container-fluid">
    <h1 class="page-header text-warning">
        <i class="bi bi-percent"></i> Quản lý Khuyến mãi
    </h1>

    <a href="promotion-add.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm khuyến mãi
    </a>

    <br><br>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Món ăn</th>
            <th>Nội dung</th>
            <th width="120">Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "
            SELECT pr.*, p.name AS product_name
            FROM promotions pr
            JOIN products p ON pr.product_id = p.id
            ORDER BY pr.id DESC
        ";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)):
        ?>
            <tr>
                <td class="text-center"><?= $row['id'] ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['contents'] ?></td>
                <td class="text-center">
                    <a href="promotion-edit.php?id=<?= $row['id'] ?>"
                       class="btn btn-info btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a onclick="return confirm('Xóa khuyến mãi này?')"
                       href="promotion-back.php?delete=<?= $row['id'] ?>"
                       class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-danger">Quay lại trang chủ</a>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer-admin text-center">
    © <?= date('Y') ?> <b>VTi Restaurant Admin</b> |
    Design by <span class="text-danger">Vanw Tít</span>
</footer>

<!-- JS (BẮT BUỘC) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
