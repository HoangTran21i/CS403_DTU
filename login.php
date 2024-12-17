<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "website_bando";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $error_message = "";

    // Kiểm tra trong bảng `tbl_user_data`
    $sql_user = "SELECT * FROM tbl_user_data WHERE email_user = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        if (password_verify($password, $row_user['password_user'])) {
            // Lưu user_id và email vào session
            $_SESSION['user_id'] = $row_user['user_id'];
            $_SESSION['email'] = $row_user['email_user'];
            header("Location: /user/index.php"); // Điều chỉnh đường dẫn nếu cần
            exit();
        }
    }

    $error_message = "Email hoặc mật khẩu không chính xác.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="user/style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"/>
</head>
<body>
    <div class="login">
        <div class="login_container">
            <h1>Đăng Nhập</h1>
            <form method="POST" action="login.php">
            <h5>Email</h5>
            <input type="text" name="email" placeholder="Nhập email đã đăng ký..." required />
            <h5>Password</h5>
            <input type="password" name="password" placeholder="Nhập mật khẩu của bạn..." required />
            <a href="login_admin.php">Đăng nhập admin?</a>
            <button type="submit">Đăng Nhập</button>
            </form>
            <div class="error_message">
                <?php if (!empty($error_message)) echo "<p>$error_message</p>"; ?>
            </div>
            Bạn chưa có tài khoản? <a href="user/register.php">Tạo tài khoản ngay</a>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>
