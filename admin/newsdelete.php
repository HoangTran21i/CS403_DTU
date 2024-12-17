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
    // Xóa bài viết
    $delete_query = "DELETE FROM tbl_news WHERE news_id = $news_id";

    if ($conn->query($delete_query) === TRUE) {
        echo "<script>alert('The post has been deleted.!'); window.location.href='newslist.php';</script>";
    } else {
        echo "<script>alert('ERROR: " . $conn->error . "'); window.location.href='newslist.php';</script>";
    }
} else {
    echo "<script>alert('Invalid post ID!'); window.location.href='newslist.php';</script>";
}
?>
