<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên người dùng cơ sở dữ liệu
$password = "";  // Mật khẩu cơ sở dữ liệu
$dbname = "website_bando";  // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý logic đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $email = $_POST['email_user'];
    $password = $_POST['password_user'];

    // Bảo vệ dữ liệu khỏi SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Mã hóa mật khẩu
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Thực hiện câu lệnh INSERT
    $sql = "INSERT INTO tbl_user_data (email_user, password_user) VALUES ('$email', '$password_hashed')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng sang trang `user_info.php` kèm theo email người dùng
        header("Location: info_user.php?email_user=" . urlencode($email));
        exit();
    } else {
        echo "<script>alert('Có lỗi xảy ra: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!-- Giao diện HTML -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="signup">
        <div class="signup_container">
            <h1>Đăng Ký</h1>
            <form method="POST" action="">
                <h5>Email</h5>
                <input type="email" name="email_user" placeholder="Vui lòng nhập email của bạn..." required>
                <h5>Password</h5>
                <input type="password" name="password_user" placeholder="Vui lòng nhập mật khẩu..." required>
                <button type="submit">Đăng Ký</button>
            </form>
            Bạn đã có tài khoản? <a href="/login.php">Đăng nhập ngay!</a>
        </div>
    </div>
</body>
</html>
