<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "website_bando";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID bài viết
$news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : 0;

if ($news_id > 0) {
    // Lấy thông tin bài viết
    $query = "SELECT * FROM tbl_news WHERE news_id = $news_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $news = $result->fetch_assoc();
    } else {
        echo "<script>alert('Không tìm thấy bài viết!'); window.location.href='newslist.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID bài viết không hợp lệ!'); window.location.href='newslist.php';</script>";
    exit;
}

// Xử lý cập nhật bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news_title = $conn->real_escape_string($_POST['news_title']);
    $news_content = $conn->real_escape_string($_POST['news_content']);

    $news_image = $news['news_image']; // Lấy ảnh cũ
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images_news/';
        $file_name = basename($_FILES['news_image']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['news_image']['tmp_name'], $target_file)) {
            $news_image = $file_name;
        }
    }

    $update_query = "UPDATE tbl_news SET 
                        news_title = '$news_title', 
                        news_content = '$news_content', 
                        news_image = '$news_image' 
                    WHERE news_id = $news_id";

    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Cập nhật bài viết thành công!'); window.location.href='newslist.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
    }
}

include "header.php";
include "slider.php";
?>

<div class="admin-content-right">
    <div class="admin-content-right-news_add">
        <h1>Edit news</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="news_title">Title:</label>
            <input type="text" id="news_title" name="news_title" value="<?php echo htmlspecialchars($news['news_title']); ?>" required>

            <label for="news_content">Content:</label>
            <textarea id="news_content" name="news_content" rows="6" required><?php echo htmlspecialchars($news['news_content']); ?></textarea>

            <label for="news_image">Image new:</label>
            <input type="file" id="news_image" name="news_image" accept="image/*">
            <?php if (!empty($news['news_image'])) { ?>
                <p>Current photo:</p>
                <img src="images_news/<?php echo $news['news_image']; ?>" alt="News Image" style="width: 100px; height: auto;">
            <?php } ?>

            <button type="submit">Update article</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
