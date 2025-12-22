<?php
session_start();

/* Xóa toàn bộ session */
$_SESSION = [];
session_unset();
session_destroy();

/* Quay về trang đăng nhập admin */
header("Location: login.php?logout=success");
exit;
