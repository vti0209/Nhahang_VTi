<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once 'model/connect.php';

    if (isset($_POST['sendintroduce'])) 
    {
        // Lấy dữ liệu, tránh SQL injection cơ bản bằng mysqli_real_escape_string
        $name    = mysqli_real_escape_string($conn, trim($_POST['name']));
        $email   = mysqli_real_escape_string($conn, trim($_POST['email']));
        $title   = isset($_POST['title']) ? mysqli_real_escape_string($conn, trim($_POST['title'])) : '';
        $message = mysqli_real_escape_string($conn, trim($_POST['message']));

        // SQL insert (bảng iqntroduces)
        $sql = "INSERT INTO introduces(name, email, title, message, created) VALUES('$name', '$email', '$title', '$message', NOW())";
        $result = mysqli_query($conn, $sql);

        if ($result) 
        {
            header("Location:introduceshop.php?cs=success");
            exit();
        } 
        else 
        {
            header("Location:introduceshop.php?cf=failed");
            exit();
        }
    } 
    else 
    {
        // Nếu đi thẳng không qua form → về trang giới thiệu
        header("Location:introduceshop.php");
        exit();
    }
?>
