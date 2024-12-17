<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "website_bando";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $error_message = "";

    // Kiểm tra trong bảng `tbl_admin_data`
    $sql_admin = "SELECT * FROM tbl_admin_data WHERE email_admin = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $row_admin = $result_admin->fetch_assoc();
        if (password_verify($password, $row_admin['password_admin'])) {
            $_SESSION['email'] = $email;
            header("Location: /admin/categoryadd.php");
            exit();
        }
    }

    $error_message = "Email hoặc mật khẩu không chính xác.";
}
?>

<!DOCTYPE html>
<html lang="en">
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
            <h1>Đăng Nhập ADMIN</h1>
            <form method="POST" action="login_admin.php">
            <h5>Email</h5>
            <input type="text" name="email" placeholder="Nhập email đã đăng ký..." required />
            <h5>Password</h5>
            <input type="password" name="password" placeholder="Nhập mật khẩu của bạn..." required />
            <a href="login.php">Đăng nhập khách hàng?</a>
            <button type="submit">Đăng Nhập</button>
            </form>
            <div class="error_message">
                <?php if (!empty($error_message)) echo "<p>$error_message</p>"; ?>
            </div>
            Bạn chưa có tài khoản Admin? <a href="admin/register_admin.php">Tạo tài khoản admin ngay</a>
        </div>
    </div>
</body>
<script src="./js/main.js"></script>
</html>
