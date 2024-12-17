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

// Truy vấn danh sách tin tức
$query = "SELECT * FROM tbl_news ORDER BY news_id DESC";
$result = $conn->query($query);

include "header.php";
include "slider.php";


?>

<div class="admin-content-right">
    <div class="admin-content-right-category_list">
        <h1>News List</h1>
        <table>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>New images</th>
                <th>Date posted</th>
                <th>Action</th>
            </tr>
            <?php
            $i = 1;
            // Kiểm tra và hiển thị kết quả
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['news_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['news_title']); ?></td>
                        <td class="truncate-text"><?php echo htmlspecialchars($row['news_content']); ?></td>
                        <td>
                            <?php if (!empty($row['news_image'])) { ?>
                                <img src="images_news/<?php echo htmlspecialchars($row['news_image']); ?>" alt="News Image" style="width: 100px; height: auto;">
                            <?php } else { ?>
                                No image
                            <?php } ?>
                        </td>
                        <td><?php echo $row['news_date']; ?></td>
                        <td>
                            <a href="newsedit.php?news_id=<?php echo $row['news_id']; ?>">Update</a> |
                            <a href="newsdelete.php?news_id=<?php echo $row['news_id']; ?>" onclick="return confirm('Are you sure you want to delete this news?');">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } 
            ?>
        </table>
    </div>
</div>
</section>
</body>
</html>
