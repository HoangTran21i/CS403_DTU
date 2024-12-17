<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên người dùng cơ sở dữ liệu
$password = "";  // Mật khẩu cơ sở dữ liệu
$dbname = "website_bando";  // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Khởi tạo biến và thông báo lỗi
$message = '';
$news_title = $news_content = $news_image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news_title = $conn->real_escape_string($_POST['news_title']);
    $news_content = $conn->real_escape_string($_POST['news_content']);

    // Kiểm tra và xử lý file upload ảnh
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images_news/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }
        $file_name = basename($_FILES['news_image']['name']);
        $target_file = $upload_dir . $file_name;

        // Kiểm tra và di chuyển file tải lên
        if (move_uploaded_file($_FILES['news_image']['tmp_name'], $target_file)) {
            $news_image = $file_name;
        } else {
            $message = "<p>Lỗi khi tải lên tệp ảnh.</p>";
        }
    }

    // Chỉ chèn dữ liệu nếu các trường bắt buộc có giá trị
    if (!empty($news_title) && !empty($news_content) && !empty($news_image)) {
        $sql = "INSERT INTO tbl_news (news_title, news_content, news_image) 
                VALUES ('$news_title', '$news_content', '$news_image')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Bài viết đã được thêm thành công!');</script>";
        } else {
            echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin trước khi gửi!');</script>";
}
}

include "header.php";
include "slider.php";

?>
<div class="admin-content-right">
    <div class="admin-content-right-news_add">
        <h1>Add news</h1>
        <?php echo $message; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="news_title">Title: <span style="color: red;">*</span></label>
            <input type="text" id="news_title" name="news_title" required>

            <label for="news_content">Content: <span style="color: red;">*</span></label>
            <textarea id="news_content" name="news_content" rows="6" required></textarea>

            <label for="news_image">Image new: <span style="color: red;">*</span></label>
            <input type="file" id="news_image" name="news_image" accept="image/*" required>

            <button type="submit">Add news</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
