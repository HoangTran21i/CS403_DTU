<?php
session_start();
include "database.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website_bando";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập trước khi truy cập trang này.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth  = $_POST['date_of_birth'];

    // Lấy user_id từ session
    $user_id = $_SESSION['user_id'];

    if (!empty($user_id)) {
        // Cập nhật thông tin người dùng
        $sql_update = "
            UPDATE tbl_user_info
            SET full_name = ?, phone_number = ?, address = ?, date_of_birth = ?
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssssi", $full_name, $phone_number, $address, $date_of_birth, $user_id);

        if ($stmt->execute()) {
            $message = "Cập nhật thông tin thành công!";
        } else {
            $message = "Cập nhật thất bại: " . $conn->error;
        }
    } else {
        $message = "Không tìm thấy thông tin người dùng.";
    }
}

// Hiển thị thông tin người dùng để chỉnh sửa
$user_id = $_SESSION['user_id'];
$sql_user_info = "SELECT * FROM tbl_user_info WHERE user_id = ?";
$stmt = $conn->prepare($sql_user_info);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
} else {
    die("Không tìm thấy thông tin người dùng.");
}
include "header.php";
?>

    <div class="info-container">
        <h1>Cập Nhật Thông Tin</h1>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="POST" action="">
            <label for="full_name">Họ và Tên:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $user_info['full_name']; ?>" required><br><br>

            <label for="phone_number">Số Điện Thoại:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $user_info['phone_number']; ?>" required><br><br>

            <label for="address">Địa Chỉ:</label>
            <input type="text" id="address" name="address" value="<?php echo $user_info['address']; ?>" required><br><br>

            <label for="date_of_birth">Ngày Sinh:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" 
            value="<?php echo htmlspecialchars($user_info['date_of_birth']); ?>" required><br><br>
            <button type="submit">Update Thông Tin</button>
        </form>
        <a href="index.php">Quay lại trang chủ</a>
    </div>
<?php include "footer.php"; ?>
