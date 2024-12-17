<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên người dùng cơ sở dữ liệu (thường là "root")
$password = "";  // Mật khẩu cơ sở dữ liệu
$dbname = "website_bando";  // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $email = $_POST['email_admin'];  // Lấy email từ input
    $password = $_POST['password_admin'];  // Lấy mật khẩu từ input

    // Bảo vệ dữ liệu khỏi SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Thực hiện câu lệnh INSERT vào bảng admin_data
    $sql = "INSERT INTO tbl_admin_data (email_admin, password_admin) VALUES ('$email', '$password_hashed')";

    if ($conn->query($sql) === TRUE) {
        echo "Đăng ký thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
}
?>

<!-- Form HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng Ký Admin</title>
    <link rel="stylesheet" href="/user/style1.css">
</head>
<body>
    <div class="signup">
        <div class="signup_container">
            <h1>Đăng Ký ADMIN</h1>
            <form method="POST" action="http://localhost:3000/admin/register_admin.php">
                <h5>Email</h5>
                <input type="text" name="email_admin" placeholder="Vui lòng nhập email của bạn..." required />
                <h5>Password</h5>
                <input type="password" name="password_admin" placeholder="Vui lòng nhập mật khẩu..." required />
                <button type="submit">Đăng Ký</button>
            </form>
        Bạn đã có tài khoản admin? <a href="/login.php">Đăng nhập admin ngay!</a>
        </div>
    </div>
</body>
</html>
