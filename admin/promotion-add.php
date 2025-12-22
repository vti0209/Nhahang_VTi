<?php 
require_once('../model/connect.php');

if (isset($_POST['addpromotion'])) {
    $product_id = $_POST['product_id'];
    $contents = $_POST['contents'];

    $sql = "INSERT INTO promotions(product_id, contents) VALUES('$product_id', '$contents')";
    mysqli_query($conn, $sql);

    header("Location: promotion-back.php?added=1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm khuyến mãi</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Thêm khuyến mãi</h2>

    <form method="POST">

        <label>Chọn Món ăn:</label>
        <select name="product_id" class="form-control" required>
            <option value="">-- Chọn Món ăn --</option>
            <?php
                $sp = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($sp)) {
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
            ?>
        </select>

        <label>Nội dung:</label>
        <textarea class="form-control" name="contents" rows="5" required></textarea>

        <br>
        <button class="btn btn-primary" name="addpromotion">Thêm</button>
    </form>

</div>

</body>
</html>
