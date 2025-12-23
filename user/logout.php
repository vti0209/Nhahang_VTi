<?php
	session_start(); // bắt đầu phiên
	session_unset(); // xóa tất cả các biến phiên
	session_destroy(); // hủy phiên hiện tại
	header('location:../index.php'); // chuyển hướng về trang chủ
	exit();
?>