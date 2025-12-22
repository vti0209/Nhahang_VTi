<?php 
require_once('../model/connect.php');

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM promotions WHERE id = $id"));

if (isset($_POST['updatepromotion'])) {
    $product_id = $_POST['product_id'];
    $contents = $_POST['contents'];

    mysqli_query($conn, "UPDATE promotions SET product_id='$product_id', contents='$contents' WHERE id=$id");

    header("Location: promotion-back.php?updated=1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sửa khuyến mãi</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Sửa khuyến mãi</h2>

    <form method="POST">

        <label>Chọn Món ăn:</label>
        <select name="product_id" class="form-control" required>
            <?php
                $sp = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($sp)) {
                    $selected = ($row['id'] == $data['product_id']) ? "selected" : "";
                    echo "<option $selected value='".$row['id']."'>".$row['name']."</option>";
                }
            ?>
        </select>

        <label>Nội dung:</label>
        <textarea class="form-control" name="contents" rows="5" required><?php echo $data['contents']; ?></textarea>

        <br>
        <button class="btn btn-primary" name="updatepromotion">Cập nhật</button>
    </form>

</div>

</body>
</html>
