<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
function connect_db() {
    $host = 'localhost';
    $db = 'restaurant_vtiet27a';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Lỗi kết nối CSDL: " . $e->getMessage());
    }
}

function send_reset_email($recipient_email, $reset_link) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hotrai84@gmail.com'; 
        $mail->Password   = 'ptjr uekf eptt uhgw'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        //Recipients
        $mail->setFrom('hotrai84@gmail.com', 'VTiRestaurant');
        $mail->addAddress($recipient_email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Yêu cầu Đặt lại Mật khẩu của bạn';
        $mail->Body    = "
            <h2>Yêu cầu Đặt lại Mật khẩu</h2>
            <p>Chào bạn,</p>
            <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Vui lòng nhấp vào liên kết sau để đặt mật khẩu mới (liên kết có giá trị trong 1 giờ):</p>
            <p><a href=\"$reset_link\">$reset_link</a></p>
            <p>Nếu bạn không yêu cầu việc này, vui lòng bỏ qua email này.</p>
            <p>Trân trọng,<br>
            Đội ngũ VTi</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Ghi lại lỗi gửi mail
        error_log("Gửi mail thất bại: {$mail->ErrorInfo}. Link Reset: {$reset_link}");
        return false;
    }
}

// --- 2. LOGIC ĐIỀU HƯỚNG ---

$action = $_GET['action'] ?? '';
$token = $_GET['token'] ?? '';
$message = '';
$db = connect_db();

// Xử lý POST cho Form Nhập Email
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'request_link') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Vui lòng nhập địa chỉ email hợp lệ.";
    } else {
        try {
            // 1. Kiểm tra Email tồn tại (Sửa: SELECT id thay vì user_id)
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?"); 
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                // Thông báo chung để tránh tiết lộ thông tin email
                $message = "Nếu email này tồn tại trong hệ thống, chúng tôi đã gửi liên kết đặt lại mật khẩu.";
            } else {
                // Sửa: Lấy ID người dùng từ cột 'id'
                $user_id = $user['id']; 
                
                // 2. Tạo Token và Thời gian Hết hạn (1 giờ)
                $token = bin2hex(random_bytes(32));
                $expiry_time = date("Y-m-d H:i:s", time() + 3600);

                // 3. Lưu Token vào DB (Bảng reset_tokens phải có cột user_id)
                // Xóa token cũ nếu có
                $db->prepare("DELETE FROM reset_tokens WHERE user_id = ?")->execute([$user_id]);
                $stmt = $db->prepare("INSERT INTO reset_tokens (user_id, token, expiry_time) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $token, $expiry_time]);

                // 4. Gửi Email
                $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/forgotpass.php?action=reset&token=" . $token;
                if (send_reset_email($email, $reset_link)) {
                    $message = "Liên kết đặt lại mật khẩu đã được gửi đến địa chỉ email **$email**. Vui lòng kiểm tra hộp thư của bạn (cả thư mục Spam).";
                } else {
                    $message = "Lỗi khi gửi email. Vui lòng thử lại sau.";
                    // Gợi ý cho người dùng kiểm tra error_log
                    error_log("Vui lòng kiểm tra log lỗi gửi mail chi tiết hơn.");
                }
            }
        } catch (PDOException $e) {
            $message = "Lỗi hệ thống CSDL: " . $e->getMessage();
        }
    }
// Xử lý POST cho Form Đặt Mật Khẩu Mới
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'update_password') {
    $token_post = $_POST['token'] ?? '';
    $user_id_post = $_POST['user_id'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirm_password) || empty($user_id_post) || empty($token_post)) {
        $message = "Thông tin không đầy đủ. Vui lòng thử lại từ email.";
    } elseif ($password !== $confirm_password) {
        $message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } elseif (strlen($password) < 6) {
        $message = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
        try {
            // 1. Xác thực lại Token (Chắc chắn nó vẫn hợp lệ và chưa hết hạn)
            // Kiểm tra trong reset_tokens (phải có cột user_id)
            $stmt = $db->prepare("SELECT user_id FROM reset_tokens WHERE token = ? AND user_id = ? AND expiry_time > NOW()");
            $stmt->execute([$token_post, $user_id_post]);
            $token_check = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$token_check) {
                $message = "Yêu cầu đặt lại mật khẩu không hợp lệ, đã hết hạn hoặc đã được sử dụng.";
            } else {
                // 2. Mã hóa và Cập nhật Mật khẩu (Sửa: UPDATE users WHERE id thay vì user_id)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?"); 
                $stmt->execute([$hashed_password, $user_id_post]);

                // 3. Xóa Token đã sử dụng
                $db->prepare("DELETE FROM reset_tokens WHERE token = ?")->execute([$token_post]);

                $message = "Mật khẩu của bạn đã được cập nhật thành công! Vui lòng Đăng Nhập.";
                header("Location: login.php?status=reset_success");
                exit();
            }
        } catch (PDOException $e) {
            $message = "Lỗi hệ thống khi cập nhật mật khẩu: " . $e->getMessage();
        }
    }
}
// --- 3. HIỂN THỊ HTML ---
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu & Đặt Lại</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="fortgot.css">
</head>
<body>
  <div class="container">
    <!-- <h2>Chức Năng Quên Mật Khẩu</h2> -->
     <br>
    <br>
    <?php if ($message): ?>
        <p style="color: <?php echo strpos($message, 'thành công') !== false ? 'green' : 'red'; ?>; font-weight: bold;"><?php echo $message; ?></p>
        <?php if ($action == 'reset' && !empty($token) && strpos($message, 'thành công') === false): ?>
            <p><a href="forgotpass.php">Yêu cầu liên kết mới</a></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php 
    // KIỂM TRA ACTION ĐỂ HIỂN THỊ FORM PHÙ HỢP

    if ($action == 'reset' && !empty($token)) {
        // --- LOGIC KIỂM TRA TOKEN ĐỂ HIỂN THỊ FORM ĐẶT LẠI MẬT KHẨU MỚI ---
        $user_id_token = null;
        $error_reset = '';

        try {
            // Kiểm tra Token trong DB
            $stmt = $db->prepare("SELECT user_id, expiry_time FROM reset_tokens WHERE token = ?");
            $stmt->execute([$token]);
            $token_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$token_data) {
                $error_reset = "Liên kết đặt lại mật khẩu không hợp lệ hoặc đã bị sử dụng.";
            } else {
                $current_time = new DateTime();
                $expiry_time = new DateTime($token_data['expiry_time']);

                if ($current_time > $expiry_time) {
                    $error_reset = "Liên kết đặt lại mật khẩu đã hết hạn. Vui lòng yêu cầu lại.";
                } else {
                    // Token hợp lệ
                    $user_id_token = $token_data['user_id'];
                }
            }
        } catch (PDOException $e) {
            $error_reset = "Lỗi hệ thống khi kiểm tra token.";
        }

        if ($error_reset) {
            echo '<p style="color: red;">' . $error_reset . '</p>';
            echo '<p><a href="forgotpass.php">Yêu cầu liên kết mới</a></p>';
        } elseif ($user_id_token) {
            // Hiển thị form nếu token hợp lệ
            ?>
            <h3>Đặt Mật Khẩu Mới</h3>
            <form action="forgotpass.php" method="POST">
                <input type="hidden" name="form_type" value="update_password">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id_token); ?>">

                <label for="password">Mật khẩu mới:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                
                <label for="confirm_password">Xác nhận Mật khẩu mới:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                <button type="submit">Cập Nhật Mật Khẩu</button>
            </form>
            <?php
        }
    } else {
        // --- HIỂN THỊ FORM YÊU CẦU LINK ---
        ?>
        <h3>Yêu Cầu Đặt Lại Mật Khẩu</h3>
        <form action="forgotpass.php" method="POST">
            <input type="hidden" name="form_type" value="request_link">
            <label for="email">Nhập Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <button type="submit">Gửi Yêu Cầu</button>
        </form><br>
        <p><a href="user/login.php">Quay lại Đăng Nhập</a></p>
        <?php
    }
    ?>
    </div>
</body>
</html>