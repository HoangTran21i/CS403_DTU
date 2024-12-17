<?php
include "database.php";
?>

<?php
// Lấy tham số lọc và sắp xếp
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$brand_name = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

// Tạo câu truy vấn sản phẩm
$where = [];
$where[] = "category_id = 1"; // Mã danh mục "Nam"
if (!empty($brand_name)) {
    $where[] = "brand_name = '" . $conn->real_escape_string($brand_name) . "'";
}
$where_clause = !empty($where) ? "WHERE " . implode(' AND ', $where) : '';

$order_clause = '';
if ($order === 'asc') {
    $order_clause = "ORDER BY product_price_new ASC"; // Sắp xếp theo giá tăng dần
} elseif ($order === 'desc') {
    $order_clause = "ORDER BY product_price_new DESC"; // Sắp xếp theo giá giảm dần
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
if ($offset < 0) {
    $offset = 0;  // Đảm bảo OFFSET không âm
}
// Truy vấn dữ liệu sản phẩm
$sql_product = "SELECT product_id, product_img, product_name, product_price, product_price_new FROM tbl_product $where_clause $order_clause LIMIT $products_per_page OFFSET $offset";
$result_product = $conn->query($sql_product);

?>

<?php
// Bao gồm file header
include('header.php');
?>
<?php
include "sidebar.php";
?>

                <div class="category-right row">
                    <div class="category-right-top-item">
                        <p>Male</p>
                    </div>
                    <div class="category-right-top-item">
                        <select name="sortSelect" id="sortSelect">
                            <option value="">--Sort by--</option>
                            <option value="asc"<?= $order === 'asc' ? 'selected' : '' ?>>Price increasing</option>
                            <option value="desc"<?= $order === 'desc' ? 'selected' : '' ?>>Price decreasing</option>
                            <option value="name_asc" <?= $order === 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                            <option value="name_desc" <?= $order === 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
                        </select>
                    </div>               
                    <div class="category-right-content">
                        <?php
                        if ($result_product->num_rows > 0) {
                            // Duyệt qua các sản phẩm và hiển thị thông tin
                            while ($row_product = $result_product->fetch_assoc()) {
                                // Thêm link tới trang product.php và truyền product_id
                                echo "<div class='category-right-content-item'>";
                                echo "<a href='/user/product.php?product_id=" . $row_product['product_id'] . "'>";
                                echo "<img src='/admin/uploads/" . $row_product['product_img'] . "' alt='" . $row_product['product_name'] . "'>";
                                echo "<h1>" . $row_product['product_name'] . "</h1>";
                                if (!empty($row_product['product_price_new'])) {
                                    // Nếu có giá trị cho product_price_new
                                    echo '<p>' . number_format($row_product['product_price'], 0, ',', '.') . '<sup>đ</sup></p>';
                                    echo "<h4>" . number_format($row_product['product_price_new'], 0, ',', '.') . "<sup>đ</sup></h4>";
                                } else {
                                    // Nếu không có giá trị cho product_price_new, chỉ hiển thị product_price
                                    echo '<h4>' . number_format($row_product['product_price'], 0, ',', '.') . '<sup>đ</sup></h4>';
                                }
                                echo "</a>"; // Kết thúc thẻ <a>
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Không có sản phẩm nào.</p>";
                        }
                        ?>
                    </div>
                    <div class="category-right-bottom row">
                        <div class="category-right-bottom-items">
                            <p>Showing <?= $result_product->num_rows ?> <span>|</span> <?= $total_products ?> products</p>
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
                            <span>&#187;</span> Last page
                        </p>
                        </div>
                    </div>
                </div>
    </section>


<?php
// Bao gồm file footer
include('footer.php');
?>
