<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');
error_reporting(2);

/* ===== THÔNG BÁO ===== */
$alerts = [
    'cs'  => 'Xóa danh mục thành công!',
    'cf'  => 'Không thể xóa danh mục!',
    'adds'=> 'Thêm danh mục thành công!',
    'addf'=> 'Thêm danh mục thất bại!',
    'ups' => 'Cập nhật danh mục thành công!',
    'upf' => 'Cập nhật danh mục thất bại!'
];
foreach ($alerts as $key => $msg) {
    if (isset($_GET[$key])) {
        echo "<script>alert('$msg');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục | Admin</title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background: #f5f6fa; }

        .navbar-admin {
            border-radius: 0;
            margin-bottom: 0;
        }

        #page-wrapper {
            background: #fff;
            padding: 20px;
            min-height: 500px;
        }

        .page-header {
            margin-top: 0;
            font-weight: bold;
        }

        .footer-admin {
            background: #f8f9fa;
            padding: 25px 15px;
            margin-top: 40px;
            border-top: 2px solid #ddd;
        }

        .footer-links li { margin-bottom: 6px; }
        .footer-links a { color: #337ab7; text-decoration: none; }
        .footer-links a:hover { text-decoration: underline; }
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
                <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li class="active"><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
                <li><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
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
    <h1 class="page-header text-primary">
        <i class="bi bi-tags-fill"></i> Danh sách danh mục
    </h1>

    <a href="category-add.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm danh mục
    </a>

    <br><br>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr class="text-center">
            <th width="80">ID</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th width="120">Sửa</th>
            <th width="100">Xóa</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM categories ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)):
        ?>
            <tr>
                <td class="text-center"><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['description'] ?? '' ?></td>
                <td class="text-center">
                    <a href="category-edit.php?id=<?= $row['id'] ?>"
                       class="btn btn-info btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
                <td class="text-center">
                    <a href="category-delete.php?id=<?= $row['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div><a href="index.php" class="btn btn-danger"> Quay lại trang chủ</a></div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h4 class="text-danger"><i class="bi bi-tags"></i> Quản lý danh mục</h4>
                <p>Quản lý các danh mục sản phẩm trong hệ thống.</p>
            </div>
            <div class="col-md-4">
                <h4 class="text-primary"><i class="bi bi-link-45deg"></i> Truy cập nhanh</h4>
                <ul class="list-unstyled footer-links">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="product.php">Ẩm Thực</a></li>
                    <li><a href="category-add.php">Thêm danh mục</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="text-success"><i class="bi bi-person"></i> Quản trị viên</h4>
                <p><b>Admin:</b> <?= $_SESSION['admin'] ?? 'Admin VTi Restaurant' ?></p>
                <p><i class="bi bi-calendar"></i> <?= date('d/m/Y') ?></p>
            </div>
        </div>
        <hr>
        <p class="text-center">
            © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by <span class="text-danger">Vanw Tít</span>
        </p>
    </div>
</footer>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
