<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');
error_reporting(2);

/* ===== THÔNG BÁO (ALERT) ===== */
$alerts = [
    'bs'  => 'Cập nhật trạng thái thành công!',
    'bf'  => 'Lỗi thao tác trạng thái!',
    'adds'=> 'Thêm người dùng mới thành công!',
    'addf'=> 'Thêm người dùng thất bại!',
    'ups' => 'Cập nhật thông tin thành công!',
    'upf' => 'Cập nhật thông tin thất bại!'
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
    <title>Quản lý người dùng | Admin</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
        .avatar-user {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-admin">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#admin-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" style="padding: 5px 15px;">
                <img src="../images/logohong.png" alt="VTi Restaurant" style="height:40px; display:inline-block;">
                <span style="color:#fff; font-weight:bold; margin-left:8px;">VTi Restaurant Admin</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="admin-navbar">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><i class="bi bi-house"></i> Trang chủ Admin</a></li>
                <li><a href="order.php"><i class="bi bi-cart4"></i> Đơn hàng</a></li>
                <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
                <li><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
                <li class="active"><a href="user.php"><i class="bi bi-people"></i> Người dùng User</a></li>
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
                        <li><a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="page-wrapper" class="container-fluid">
    <h1 class="page-header text-primary">
        <i class="bi bi-people-fill"></i> Danh sách thành viên
    </h1>
    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr class="text-center" style="background-color: #f9f9f9;">
            <th width="50">ID</th>
            <th>Tên đăng nhập</th>
            <th>Họ và tên</th>
            <th>Email / SĐT</th>
            <th>Vai trò</th>
            <th width="120">Trạng thái</th>
            <th width="80">Sửa</th>
            <th width="120">Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)):
            $status = $row['status'] ?? 1;
        ?>
            <tr class="text-center <?= ($status == 0) ? 'danger' : '' ?>" style="vertical-align: middle;">
                <td><?= $row['id'] ?></td>
                <td><strong><?= $row['username'] ?></strong></td>
                <td><?= $row['fullname'] ?></td>
                <td>
                    <small><?= $row['email'] ?></small><br>
                    <span class="text-muted"><?= $row['phone'] ?></span>
                </td>
                <td>
                    <span class="label <?= ($row['role'] == 'admin') ? 'label-danger' : 'label-info' ?>">
                        <?= strtoupper($row['role']) ?>
                    </span>
                </td>
                <td>
                    <?php if($status == 1): ?>
                        <span class="text-success"><i class="bi bi-check-circle-fill"></i> Đang mở</span>
                    <?php else: ?>
                        <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Đã khóa</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="user-edit.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
                <td>
                    <?php if($status == 1): ?>
                        <a href="user-block.php?id=<?= $row['id'] ?>&action=0" 
                           class="btn btn-warning btn-sm" 
                           onclick="return confirm('Khóa tài khoản này?')">
                            <i class="bi bi-lock"></i> Khóa lại
                        </a>
                    <?php else: ?>
                        <a href="user-block.php?id=<?= $row['id'] ?>&action=1" 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-unlock"></i> Mở khóa
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    
    <div><a href="index.php" class="btn btn-danger"> Quay lại trang chủ</a></div>
</div>

<footer class="footer-admin">
    <div class="container-fluid text-center">
        © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by <span class="text-danger"> Vanw Tít</span>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>