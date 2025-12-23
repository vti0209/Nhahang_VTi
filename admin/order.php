<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');
error_reporting(2);

/* ===== ALERT THÔNG BÁO ===== */
if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    echo "<script>alert('Cập nhật trạng thái và gửi mail thành công!');</script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn hàng | Admin</title>

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
        .reason-input { display: none; margin-top: 5px; }
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
                <li class="active"><a href="order.php"><i class="bi bi-cart4"></i> Đơn hàng</a></li>
                <li><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
                <li><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
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

<div id="page-wrapper" class="container-fluid">
    <h1 class="page-header text-danger">
        <i class="bi bi-cart-fill"></i> Quản lý Đơn hàng
    </h1>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center info">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Thông tin món đặt</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th width="280">Xử lý</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT idOrder, fullname, email, phone, dateOrder, status
                FROM view_order_list
                GROUP BY idOrder
                ORDER BY dateOrder DESC";
        $result = mysqli_query($conn, $sql);

        $status_names = ["Đang chờ", "Đã xác nhận", "Đang giao", "Sắp đến", "Thành công", "Thất bại"];
        $labels = ["default", "info", "warning", "primary", "success", "danger"];

        while ($row = mysqli_fetch_assoc($result)):
            $st = $row['status'];
        ?>
        <tr>
            <td class="text-center"><b>#<?= $row['idOrder'] ?></b></td>
            <td>
                <strong><?= $row['fullname'] ?></strong><br>
                <small><i class="bi bi-envelope"></i> <?= $row['email'] ?></small><br>
                <small><i class="bi bi-telephone"></i> <?= $row['phone'] ?></small>
            </td>
            <td>
                <button class="btn btn-xs btn-default" data-toggle="collapse"
                        data-target="#items-<?= $row['idOrder'] ?>">
                    <i class="bi bi-list-ul"></i> Chi tiết món
                </button>
                <div id="items-<?= $row['idOrder'] ?>" class="collapse" style="margin-top:5px;font-size:12px;">
                    <?php
                    $idO = $row['idOrder'];
                    $item_sql = "SELECT nameProduct, quantity
                                 FROM view_order_list
                                 WHERE idOrder = $idO";
                    $item_res = mysqli_query($conn, $item_sql);
                    while ($item = mysqli_fetch_assoc($item_res)) {
                        echo "• {$item['nameProduct']} <span class='badge'>x{$item['quantity']}</span><br>";
                    }
                    ?>
                </div>
            </td>
            <td class="text-center"><?= date('d/m/Y H:i', strtotime($row['dateOrder'])) ?></td>
            <td class="text-center">
                <span class="label label-<?= $labels[$st] ?>"><?= $status_names[$st] ?></span>
            </td>
            <td>
                <form action="order-status-back.php" method="POST" style="margin:0;">
                    <!-- ID xử lý nội bộ -->
                    <input type="hidden" name="order_id" value="<?= $row['idOrder'] ?>">
                    <!-- MÃ ĐƠN HIỂN THỊ GỬI MAIL -->
                    <input type="hidden" name="order_code" value="<?= $row['idOrder'] ?>">
                    <input type="hidden" name="customer_email" value="<?= $row['email'] ?>">

                    <div class="input-group">
                        <select name="status_val" class="form-control input-sm"
                                onchange="toggleReason(this)">
                            <?php foreach ($status_names as $k => $v): ?>
                                <option value="<?= $k ?>" <?= ($k == $st) ? 'selected' : '' ?>>
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" name="btn_update"
                                    class="btn btn-danger btn-sm">Cập nhật</button>
                        </span>
                    </div>
                    <input type="text" name="reason"
                           class="form-control input-sm reason-input"
                           placeholder="Lý do thất bại...">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-danger">Quay lại trang chủ</a>
</div>

<footer class="footer-admin">
    <div class="container-fluid text-center">
        © <?= date('Y') ?> <b>VTi Restaurant Admin</b> | Design by
        <span class="text-danger">Vanw Tít</span>
    </div>
</footer>

<script>
function toggleReason(select) {
    const reasonInput = select.closest('form').querySelector('.reason-input');
    reasonInput.style.display = (select.value == "5") ? "block" : "none";
    reasonInput.required = (select.value == "5");
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
