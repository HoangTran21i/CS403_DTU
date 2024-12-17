<?php
include "database.php";

// Lấy tham số lọc và sắp xếp
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$brand_name = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

// Tạo câu truy vấn sản phẩm
$where = [];
if ($category_id > 0) {
    $where[] = "category_id = $category_id";
}
if (!empty($brand_name)) {
    $where[] = "brand_name = '" . $conn->real_escape_string($brand_name) . "'";
}
$where_clause = !empty($where) ? "WHERE " . implode(' AND ', $where) : '';

$order_clause = '';
if ($order === 'asc') {
    $order_clause = "ORDER BY product_price_new ASC"; // Sắp xếp theo giá giảm dần
} elseif ($order === 'desc') {
    $order_clause = "ORDER BY product_price_new DESC"; // Sắp xếp theo giá tăng dần
} elseif ($order === 'name_asc') {
    $order_clause = "ORDER BY product_name ASC";  // Sắp xếp theo tên A-Z
} elseif ($order === 'name_desc') {
    $order_clause = "ORDER BY product_name DESC";  // Sắp xếp theo tên Z-A
}

// Truy vấn tổng số sản phẩm
$sql_total = "SELECT COUNT(*) AS total FROM tbl_product $where_clause";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_products = $total_row['total'];  // Tổng số sản phẩm

// Định nghĩa số sản phẩm mỗi trang
$products_per_page = 8;
$total_pages = ceil($total_products / $products_per_page);  // Số trang tổng cộng

// Lấy trang hiện tại từ URL
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

// Tính toán OFFSET cho truy vấn SQL
$offset = ($current_page - 1) * $products_per_page;

// Lấy từ khóa tìm kiếm
$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : "";

// Điều kiện FIND cho tìm kiếm
$find_clause = "WHERE product_name LIKE '%$keyword%'";

// Truy vấn sản phẩm theo từ khóa
$sql = "SELECT product_id, product_img, product_name, product_price, product_price_new 
        FROM tbl_product $where_clause $order_clause $find_clause 
        LIMIT $products_per_page OFFSET $offset";
$result = $conn->query($sql);
?>

<?php
include "header.php";
?>
<?php
include "sidebar.php";
?>

                <div class="category-right row">
                    <div class="category-right-top-item">
                        <p>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"</p>
                    </div>
                    <div class="category-right-top-item">
                        <select name="sortSelect" id="sortSelect">
                            <option value="">--Sắp xếp--</option>
                            <option value="asc"<?= $order === 'asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                            <option value="desc"<?= $order === 'desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                            <option value="name_asc" <?= $order === 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                            <option value="name_desc" <?= $order === 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                        </select>
                    </div>               
                    <div class="category-right-content">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='category-right-content-item'>";
                                echo "<img src='/admin/uploads/" . htmlspecialchars($row['product_img']) . "' alt='" . htmlspecialchars($row['product_name']) . "'>";
                                echo "<h1>" . htmlspecialchars($row['product_name']) . "</h1>";
                                echo "<p>" . number_format($row['product_price_new'], 0, ',', '.') . "<sup>đ</sup></p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Không tìm thấy sản phẩm phù hợp.</p>";
                        }
                        ?>
                    </div>
                    <div class="category-right-bottom row">
                        <div class="category-right-bottom-items">
                            <p>Hiển thị <?= $products_per_page ?> <span>|</span> <?= $total_products ?> sản phẩm</p>
                        </div>
                        <div class="category-right-bottom-items">
                        <p>
                            <span>&#171;</span> 
                            <?php
                            // Hiển thị các trang
                            for ($i = 1; $i <= $total_pages; $i++) {
                                // Kiểm tra xem trang hiện tại có phải là trang này không
                                if ($i == $current_page) {
                                    echo "<span>$i</span>";
                                } else {
                                    echo "<a href='?category_id=$category_id&order=$order&page=$i'>$i</a>";
                                }
                                if ($i < $total_pages) {
                                    echo " ";
                                }
                            }
                            ?>
                            <span>&#187;</span> Trang cuối
                        </p>
                        </div>
                    </div>
                </div>
            </section>
<?php
include "footer.php";
?>