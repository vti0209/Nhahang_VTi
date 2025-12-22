<?php
session_start();

// Nếu giỏ hàng trống → chuyển về trang giỏ hàng
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: view-cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>

    <style>
        .checkout-img {
            width: 70px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="container mt-4">
    <h2 class="text-center text-danger">Xác nhận thông tin thanh toán</h2>
    <hr>

    <div class="row">
        <!-- ------- GIỎ HÀNG ------- -->
        <div class="col-md-7">
            <h4>Sản phẩm trong đơn hàng</h4>
            <table class="table table-bordered">
                <thead class="bg-info text-center">
                    <tr>
                        <th>Hình</th>
                        <th>Sản phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tạm tính</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $total = 0;

                foreach ($_SESSION['cart'] as $item):

                    $saleprice = isset($item['saleprice']) ? $item['saleprice'] : 0;

                    if ($saleprice > 0) {
                        $final_price = $item['price'] - ($item['price'] * ($saleprice / 100));
                    } else {
                        $final_price = $item['price'];
                    }

                    $subtotal = $final_price * $item['quantity'];
                    $total += $subtotal;
                ?>

                    <tr class="text-center">
                        <td><img src="<?php echo $item['image']; ?>" class="checkout-img"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($final_price, 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

            <h3 class="text-right text-success">
                Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ
            </h3>
        </div>

        <!-- ------- FORM KHÁCH HÀNG ------- -->
        <div class="col-md-5">
            <h4> Thông tin khách hàng</h4>

            <form action="checkout-success.php" method="POST">

                <div class="form-group mt-3">
                    <label><b>Họ và tên:</b></label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="form-group mt-3">
                    <label><b>Email nhận hóa đơn:</b></label>
                    <input type="email" name="email" class="form-control" required> 
                </div>
                <div class="form-group mt-3">
                    <label><b>Số điện thoại:</b></label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="form-group mt-3">
                    <label><b>Địa chỉ nhận hàng:</b></label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group mt-3">
                    <label><b>Ghi chú:</b></label>
                    <textarea name="note" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-block mt-4">
                    Xác nhận đặt hàng
                </button>
            </form>

            <a href="view-cart.php" class="btn btn-secondary btn-block mt-2">
                Quay lại giỏ hàng
            </a>
        </div>
    </div>
</div>

</body>
</html>
