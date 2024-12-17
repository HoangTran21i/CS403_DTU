<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website_bando";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email_user']; // Email nhận từ hidden input

    // Tìm user_id dựa trên email
    $query_user = "SELECT user_id FROM tbl_user_data WHERE email_user = ?";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bind_param("s", $email);
    $stmt_user->execute();
    $result = $stmt_user->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $user_id = $user['user_id'];

        // Thêm thông tin cá nhân vào bảng tbl_user_info
        $sql = "INSERT INTO tbl_user_info (user_id, full_name, phone_number, address, date_of_birth) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $full_name, $phone_number, $address, $date_of_birth);

        if ($stmt->execute()) {
            echo "<script>alert('Thông tin cá nhân được lưu thành công!'); window.location.href = '/login.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi lưu thông tin cá nhân.');</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy người dùng với email này.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 100%;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <div class="info-form">
        <div class="info-form-container">
            <h1>Thông Tin Cá Nhân</h1>
            <form method="POST" action="info_user.php">
                <input type="hidden" name="email_user" value="<?php echo htmlspecialchars($_GET['email_user']); ?>">

                <label for="full_name">Họ và Tên:</label>
                <input type="text" id="full_name" name="full_name" placeholder="Nhập họ và tên của bạn..." required><br><br>

                <label for="phone_number">Số Điện Thoại:</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="Nhập số điện thoại..." required><br><br>

                <label for="address">Địa Chỉ:</label>
                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ của bạn..." required><br><br>

                <label for="date_of_birth">Ngày Sinh:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>

                <button type="submit">Lưu Thông Tin</button>
            </form>
        </div>
    </div>
</body>
</html>
