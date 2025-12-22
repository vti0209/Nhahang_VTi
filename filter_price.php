<?php
    require_once('model/connect.php');
    $prd = 0;
    if (isset($_SESSION['cart'])) {
        $prd = count($_SESSION['cart']);
    }

    // Lấy giá trị từ form (Sử dụng $_REQUEST để nhận cả POST và GET)
    $searchKeyword = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
    $minPrice = isset($_REQUEST['min_price']) ? $_REQUEST['min_price'] : 0;
    $maxPrice = isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : 999999999;

    // Khởi tạo câu lệnh SQL cơ bản
    $sql = "SELECT id, image, name, price FROM products WHERE 1=1";

    // Nếu có từ khóa tìm kiếm
    if (!empty($searchKeyword)) {
        $sql .= " AND name LIKE '%$searchKeyword%'";
    }

    // Lọc theo khoảng giá
    if ($maxPrice > 0) {
        $sql .= " AND price >= $minPrice AND price <= $maxPrice";
    }

    $resultSearch = mysqli_query($conn, $sql);
    $totalnumber = ($resultSearch) ? mysqli_num_rows($resultSearch) : 0;
?>