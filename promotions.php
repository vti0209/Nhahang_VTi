<?php
    require_once('model/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Khuyến mãi - VTi Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <meta name="title" content="VTi Restaurant - Khuyến mãi"/>
    <meta name="description" content="Danh sách khuyến mãi mới nhất từ VTi Restaurant" />
    <meta name="keywords" content="khuyến mãi thời trang, giảm giá, ưu đãi VTi Restaurant" />
    <meta name="author" content="Hôih My" />
    <meta name="author" content="Y Blir" />

    <link rel="icon" type="image/png" href="../images/logohong.png">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="../js/mylishop.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>
    <script src='../js/wow.js'></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <!-- back to top -->
    <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- header -->
    <?php include 'model/header.php'; ?>
    <!-- /header -->

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="../index.php">Trang chủ</a></li>
            <li>Khuyến mãi</li>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="titles">
                    <center><h3><strong> DANH SÁCH KHUYẾN MÃI </strong></h3></center>
                </div>

                <?php 
                    $sql = "SELECT promotions.*, products.name AS product_name 
                            FROM promotions 
                            JOIN products ON promotions.product_id = products.id
                            ORDER BY promotions.id DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="panel panel-info wow fadeInUp" data-wow-delay="0.2s">
                        <div class="panel-heading">
                            <strong><?php echo $row['product_name']; ?></strong>
                        </div>
                        <div class="panel-body">
                            <?php echo nl2br($row['contents']); ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

<script>
    new WOW().init();
</script>

</body>
</html>
