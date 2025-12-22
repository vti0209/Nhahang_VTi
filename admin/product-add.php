<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
    require_once('../model/connect.php');
    error_reporting(1);

    if (isset($_GET['notimage'])) {
        $noimage = 'Vui lòng chọn hình ảnh hợp lệ!';
    } else {
        $noimage = '';
    }
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Thêm Món ăn </h1>
            </div><!-- /.col-lg-12 -->

            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="productadd-back.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label> Tên Món ăn </label>
                        <input type="text" class="form-control" name="txtName" placeholder="Nhập tên Món ăn"
                            required />
                    </div>
                    <!-- //Tên Món ăn -->

                    <div class="form-group">
                        <label> Danh mục Món ăn </label>
                        <select class="form-control" name="category">
                            <?php
                            $sql = "SELECT * FROM categories";
                            $result = mysqli_query($conn,$sql);
                            if($result)
                            {
                                while($row = mysqli_fetch_assoc($result))
                                {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                                }
                            }
                       ?>
                        </select>
                    </div>
                    <!-- //Danh mục Món ăn -->

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label> Giá Món ăn </label>
                                <input type="number" class="form-control" name="txtPrice"
                                    placeholder="Nhập giá Món ăn" min="20000" required />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label> Phần trăm giảm (nếu có) </label>
                                <input type="number" class="form-control" name="txtSalePrice"
                                    placeholder="Nhập phần trăm giá giảm" value="0" min="0" max="50" />
                            </div>
                        </div>
                    </div>
                    <!-- //Giá Món ăn -->

                    <div class="form-group">
<label> Số lượng Món ăn </label>
                        <input type="number" class="form-control" name="txtNumber" placeholder="Nhập số lượng Món ăn"
                            required />
                    </div>
                    <!-- //Số lượng Món ăn -->

                    <div class="form-group">
                        <label> Chọn hình ảnh Món ăn </label>
                        <input type="file" name="FileImage" required>
                        <span style="color: red"><?php echo $notimage; ?></span>
                    </div>
                    <!-- //Chọn hình ảnh Món ăn -->

                    <div class="form-group">
                        <label> Nhập từ cho khách hàng tìm kiếm </label>
                        <input class="form-control" name="txtKeyword" placeholder="Nhập từ khóa tìm kiếm" />
                    </div>
                    <!-- //Nhập từ cho khách hàng tìm kiếm -->

                    <div class="form-group">
                        <label> Mô tả Món ăn </label>
                        <textarea class="form-control" rows="3" name="txtDescript"></textarea>
                    </div>
                    <!-- //Mô tả Món ăn -->

                    <div class="row">
                        <div>
                            <button type="submit" name="addProduct" class="btn btn-warning btn-block btn-lg"> Thêm</button><br>
                        <div>
                            <button type="reset" class="btn btn-default btn-block btn-lg" style="background: gray; color:white;"> Thiết lập lại </button>
                        </div>
                        <!-- //Button Reset -->
                    </div>
                    <!-- /.row -->
                </form>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->