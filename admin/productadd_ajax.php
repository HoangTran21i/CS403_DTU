<?php
include "class/product_class.php";
$product = new product;

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';  // Kiểm tra nếu category_id tồn tại
?>

<?php 
// Kiểm tra xem category_id có giá trị hợp lệ
if ($category_id != '') {
    $show_brand_ajax = $product->show_brand_ajax($category_id);  // Lấy dữ liệu thương hiệu theo danh mục

    if ($show_brand_ajax->num_rows > 0) {  // Kiểm tra có thương hiệu nào không
        while ($result = $show_brand_ajax->fetch_assoc()) {
            echo '<option value="' . $result['brand_id'] . '">' . $result['brand_name'] . '</option>';
        }
    } else {
        echo '<option value="#">Không có loại sản phẩm</option>';  // Nếu không có thương hiệu
    }
} else {
    echo '<option value="#">Vui lòng chọn danh mục trước</option>';  // Nếu không có category_id
}
?>
