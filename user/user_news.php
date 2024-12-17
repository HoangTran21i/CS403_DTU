<?php
include "database.php"; // Kết nối cơ sở dữ liệu

// Truy vấn danh sách bài viết tin tức
$sql_news = "SELECT news_id, news_title, news_content, news_image, news_date FROM tbl_news ORDER BY news_date DESC";
$result_news = $conn->query($sql_news);
?>

    <?php include "header.php"; ?>

    <section class="news-section">
        <div class="container">
            <h2>News</h2>
            <div class="news-list">
                <?php if ($result_news && $result_news->num_rows > 0): ?>
                    <?php while ($row = $result_news->fetch_assoc()): ?>
                        <div class="news-item">
                            <a href="news_detail.php?news_id=<?php echo $row['news_id']; ?>">
                                <?php if ($row['news_image']): ?>
                                    <img src="/admin/images_news/<?php echo $row['news_image']; ?>" alt="<?php echo $row['news_title']; ?>">
                                <?php endif; ?>
                                <h3><?php echo $row['news_title']; ?></h3>
                                <p><?php echo substr($row['news_content'], 0, 150); ?>...</p>
                                <span class="date"><?php echo date("d-m-Y", strtotime($row['news_date'])); ?></span>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No news yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>