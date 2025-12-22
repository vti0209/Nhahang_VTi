<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');
error_reporting(2);

/* ===== ALERT ===== */
$alerts = [
    'ps'    => 'Xóa Món ăn thành công!',
    'pf'    => 'Không thể xóa Món ăn!',
    'addps' => 'Thêm Món ăn thành công!',
    'addpf' => 'Thêm Món ăn thất bại!',
    'ups'   => 'Cập nhật Món ăn thành công!',
    'upf'   => 'Cập nhật Món ăn thất bại!'
];
foreach ($alerts as $k => $v) {
    if (isset($_GET[$k])) {
        echo "<script>alert('$v');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Món ăn | Admin</title>

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
        table img { border-radius: 4px; object-fit: cover; }
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
                <li class="active"><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
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
    <h1 class="page-header text-danger">
        <i class="bi bi-box-seam-fill"></i> Danh sách Món ăn
    </h1>

    <a href="product-add.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Món ăn
    </a>
    <a href="promotion-back.php" class="btn btn-warning">
        <i class="bi bi-percent"></i> Thêm khuyến mãi
    </a>

    <br><br>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Tên Món ăn</th>
            <th>Danh mục</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Giảm giá</th>
            <th width="100">Sửa</th>
            <th width="100">Xóa</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.id DESC
        ";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)):
            $img = $row['image'] ? "../".$row['image'] : "";
        ?>
            <tr class="text-center">
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['category_name'] ?? 'Chưa có' ?></td>
                <td>
                    <?php if ($img): ?>
                        <img src="<?= $img ?>" width="80" height="80">
                    <?php endif; ?>
                </td>
                <td><?= number_format($row['price']) ?> đ</td>
                <td><?= number_format($row['saleprice']) ?> %</td>
                <td>
                    <a href="product-edit.php?idProduct=<?= $row['id'] ?>"
                       class="btn btn-info btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
                <td>
                    <a href="product-delete.php?idProducts=<?= $row['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn chắc chắn muốn xóa Món ăn này?')">
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
    <div class="container-fluid text-center">
        © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by <span class="text-danger"> Vanw Tít</span>
    </div>
</footer>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
