<?php
require_once('../model/connect.php');

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action']; // 0 để khóa, 1 để mở

    // Câu lệnh cập nhật trạng thái
    $sql = "UPDATE users SET status = $action WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: user.php?bs=1");
    } else {
        header("Location: user.php?bf=1");
    }
} else {
    header("Location: user.php");
}
?>