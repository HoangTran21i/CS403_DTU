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
    die("Connection failed: " . $conn->connect_error);
}

// Lấy danh mục từ bảng tbl_category
$sql_category = "SELECT category_id, category_name FROM tbl_category";
$result_category = $conn->query($sql_category);

// Lấy thương hiệu từ bảng tbl_brand
$sql_brand = "SELECT brand_name, category_id FROM tbl_brand";
$result_brand = $conn->query($sql_brand);

// Lưu trữ thương hiệu theo category_id
$brands_by_category = [];
if ($result_brand->num_rows > 0) {
    while ($row_brand = $result_brand->fetch_assoc()) {
        $brands_by_category[$row_brand['category_id']][] = $row_brand['brand_name'];
    }
}
?>
