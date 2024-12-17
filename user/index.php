<?php
include "database.php";
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$brand_name = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
// Lấy số trang hiện tại từ tham số GET (nếu không có thì mặc định là trang 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4; // Số sản phẩm hiển thị trên mỗi trang
$offset = ($page - 1) * $items_per_page;

// Truy vấn dữ liệu sản phẩm với phân trang
$sql_product = "SELECT product_id, product_img, product_name, product_price, product_price_new 
                FROM tbl_product 
                LIMIT $items_per_page OFFSET $offset";
$result_product = $conn->query($sql_product);

// Đếm tổng số sản phẩm để tính tổng số trang
$sql_total = "SELECT COUNT(*) as total FROM tbl_product";
$result_total = $conn->query($sql_total);
$total_items = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<?php
include "header.php";
?>
    <!----------Slider---------->
    <section id="Slider">
        <div class="aspect-ratio-169">
            <img src="../images/slider_1.webp">
            <img src="../images/slider_2.webp">
            <img src="../images/slider_1.webp">
            <img src="../images/slider_2.webp">
            <img src="../images/slider_1.webp">
        </div>
        <div class="dot-container">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </section>
    <section class="category-show-content-container">
        <div class="category-show row">
            <div class="category-show-top-item">
                <p>Hot items</p>
            </div>
            <div class="category-show-top-item">
                <a href="user_collection.php">All products >></a>
            </div>
        </div>  
        <div class="category-right-content">
            <?php
            if ($result_product->num_rows > 0) {
                while ($row_product = $result_product->fetch_assoc()) {
                    echo "<div class='category-right-content-item'>";
                    echo "<a href='/user/product.php?product_id=" . $row_product['product_id'] . "'>";
                    echo "<img src='/admin/uploads/" . $row_product['product_img'] . "' alt='" . $row_product['product_name'] . "'>";
                    echo "<h1>" . $row_product['product_name'] . "</h1>";
                    echo '<p>' . number_format($row_product['product_price'], 0, ',', '.') . '<sup>đ</sup></p>';
                    echo "<h4>" . number_format($row_product['product_price_new'], 0, ',', '.') . "<sup>đ</sup></h4>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Không có sản phẩm nào.</p>";
            }
            ?>
        </div>
    </section>

    <!----------app-container---------->
    <section class="app-container">
        <p>Download app</p>
        <div class="app-google">
            <a href="https://apps.apple.com/us/app"><img src="../images/appstore.jpg"></a>
            <a href="https://play.google.com/store"><img src="../images/ggplay.jpg"></a>
        </div>
        <p>Get news</p>
        <input type="text" id="emailInput" placeholder="Nhập email của bạn...">
        <button type="submit" id="sendButton">Send</button>
    </section>
<!----------footer---------->
<div class="footer-top">
        <li><a href="/user/index.php"><img src="/images/logopage.jpg"></a></li>
        <li><a href="/user/user_contact.php">Contact</a></li>
        <li><a href="">Recruitment</a></li>
        <li><a href="">About us</a></li>
        <li>
            <a href="https://www.facebook.com/" class="fab fa-facebook-f"></a>
            <a href="https://www.instagram.com/" class="fa-brands fa-square-instagram"></a>
            <a href="https://www.youtube.com/" class="fab fa-youtube"></a>
        </li>
    </div>
    <div class="footer-center">
        <p>Duy Tan University<br>
            Địa chỉ: DaNang, VietNam <br>
            Hotline: <b>0123456</b>.
        </p>
    </div>
    <div class="footer-bottom">
        @DTU All rights reserved
    </div>  

<script src="/js/script.js"></script>
<script src="/js/slider.js"></script>
<script>
    document.getElementById("sendButton").addEventListener("click", function(event) {
        event.preventDefault(); // Ngăn hành động mặc định nếu nằm trong form
        const inputField = document.getElementById("emailInput"); // Sử dụng id cụ thể
        const email = inputField.value.trim(); // Lấy giá trị email trong ô input
        if (email) {
            alert("Send successfully!");
        } else {
            alert("Please enter your email!");
        }
    });
</script>
</script>
</body>
</html>

