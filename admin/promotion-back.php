<?php 
require_once('../model/connect.php');

// Xóa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM promotions WHERE id = $id");
    header("Location: promotion-back.php?deleted=1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Khuyến mãi</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
                <li><a href="index.php"><i class="bi bi-house-door"></i> Trang chủ Admin</a></li>
                <li class="active"><a href="product.php"><i class="bi bi-box-seam"></i> Ẩm Thực</a></li>
                <li><a href="category.php"><i class="bi bi-tags"></i> Danh mục</a></li>
                <li><a href="promotion-back.php"><i class="bi bi-percent"></i> Khuyến mãi</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <?php echo $_SESSION['admin'] ?? 'Admin VTi Restaurant'; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php"><i class="bi bi-person"></i> Thông tin</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php" class="text-danger">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h2 class="text-center">QUẢN LÝ KHUYẾN MÃI</h2>

    <a href="promotion-add.php" class="btn btn-success">+ Thêm khuyến mãi</a>
    <br><br>

    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Món ăn</th>
            <th>Nội dung</th>
            <th>Hành động</th>
        </tr>

        <?php
            $sql = "SELECT promotions.*, products.name AS product_name
                    FROM promotions 
                    JOIN products ON promotions.product_id = products.id";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['contents']; ?></td>
            <td>
                <a href="promotion-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a onclick="return confirm('Xóa?')" 
                   href="promotion-back.php?delete=<?php echo $row['id']; ?>" 
                   class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php } ?>

    </table>
<div><a href="index.php" class="btn btn-danger"> Quay lại trang chủ</a></div>
</div>

</body>
</html>
