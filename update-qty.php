<?php
session_start();

if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    header("Location: view-cart.php");
    exit();
}

$id = intval($_POST['id']);
$qty = intval($_POST['quantity']);

if ($qty < 1) $qty = 1;

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] = $qty;
}

header("Location: view-cart.php");
exit();
?>
