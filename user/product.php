<?php
session_start();  // Khởi tạo session
include "database.php";
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
    exit;
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$sql_product = "SELECT * FROM tbl_product WHERE product_id = $product_id";
$result_product = $conn->query($sql_product);
$product = $result_product->fetch_assoc();
if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$sql_sizes = "SELECT * FROM tbl_product_sizes WHERE product_id = $product_id";
$result_sizes = $conn->query($sql_sizes);
$sizes = [];
while ($row_size = $result_sizes->fetch_assoc()) {
    $sizes[$row_size['size']] = $row_size['quantity'];
}

$sql_desc_images = "SELECT * FROM tbl_product_img_desc WHERE product_id = $product_id";
$result_desc_images = $conn->query($sql_desc_images);

$brand_id = $product['brand_id'];
$sql_related_products = "SELECT * FROM tbl_product WHERE brand_id = $brand_id LIMIT 4"; // Giới hạn lấy 4 sản phẩm liên quan
$result_related_products = $conn->query($sql_related_products);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $size = $_POST['product_size'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;

    if (empty($size) || intval($quantity) <= 0) {
        die("Vui lòng chọn size và số lượng hợp lệ.");
    }
    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_cart WHERE product_id = ? AND user_id = ? AND size = ?");
    $stmt->bind_param("iis", $product_id, $user_id, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE tbl_cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ? AND size = ?");
        $stmt->bind_param("iiis", $quantity, $product_id, $user_id, $size);
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $product_id, $size, $quantity);
    }
    $stmt->execute();
    header("Location: cart.php");
    exit;
}
?>
<?php
include "header.php";
?>
    <!----------product---------->
    <section class="product">
        <div class="container">
        </div>
        <div class="product-content row">
            <div class="product-content-left row">
                <div class="product-content-left-big-img">
                    <img src="/admin/uploads/<?php echo $product['product_img']; ?>" alt="">
                </div>
                <div class="product-content-left-small-img">
                <?php
                // Lấy ảnh mô tả từ bảng tbl_product_img_desc
                $sql_desc_images = "SELECT * FROM tbl_product_img_desc WHERE product_id = $product_id";
                $result_desc_images = $conn->query($sql_desc_images);
                while ($desc_image = $result_desc_images->fetch_assoc()) {
                    echo '<img src="/admin/images_desc/' . htmlspecialchars($desc_image['product_img_desc']) . '" alt="">';
                }
                ?>
                </div>
            </div>
            <div class="product-content-right">

                <div class="product-content-right-product-name">
                    <h1><?php echo $product['product_name']; ?></h1>
                    <p>HOTS</p>
                </div>

                <div class="product-content-right-product-price">
                    <p><?php echo number_format($product['product_price_new'], 0, ',', '.') . "<sup>đ</sup>"; ?></p>
                </div>

                <div class="product-content-right-product-color">
                    <p><span style="font-weight: bold;">Status: </span>: 
                    <?php 
                        // Kiểm tra tình trạng hàng
                        $total_quantity = array_sum($sizes); // Tính tổng số lượng của tất cả các size
                        if ($total_quantity > 0) {
                            echo "In stock";
                        } else {
                            echo "Out of stock";
                        }
                    ?>
                    <span style="color: red;">*</span>
                    </p>
                </div>

                <div class="product-content-right-product-size">
                <p style="font-weight: bold; margin-top: 10px;">Size:</p>
                    <div class="size">
                        <form id="size-form">
                            <?php foreach ($sizes as $size => $quantity): ?>
                                <label>
                                    <input type="radio" name="product_size" value="<?php echo htmlspecialchars($size); ?>" <?php echo $quantity > 0 ? '' : 'disabled'; ?>>
                                    <span><?php echo htmlspecialchars($size); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>

                <div class="quantity">
                    <p style="font-weight: bold;">Quantity:</p>
                    <input type="number" min="1" max="<?php echo $total_quantity; ?>" value="1" id="quantity_input">
                </div>
                <p style="color: red;">Please select quantity</p>

                <div class="product-content-right-product-button">
                    <form method="POST" action="">
                        <input type="hidden" name="product_size" id="selected-size-input">
                        <input type="hidden" name="quantity" id="selected-quantity-input">
                        <button type="submit" name="add_to_cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Add to cart</p>
                        </button>
                    </form>

                    <button><a href="/user/user_collection.php"><p>Find at store</p></a></button>
                </div>
                <div class="product-content-right-product-icon">
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-phone-alt"><a href="/contact.php"></i><p>HOTLINE</p></a>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-comments"><a href="/contact.php"></i><p>CHAT</p></a>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-envelope"><a href="/contact.php"></i><p>MAIL</p></a>
                    </div>
                </div>
                <div class="product-content-right-product-QR">
                    <img src="/images/QRCode.jpg" alt="">
                </div>
                <div class="product-content-right-bottom">
                    <div class="product-content-right-bottom-top">
                        &#8744;
                    </div>
                    <div class="product-content-right-bottom-content-big">
                        <div class="product-content-right-bottom-content-title row">
                            <div class="product-content-right-bottom-content-title-item chitiet">
                                <p><b>Detail</b></p>
                            </div>
                            <div class="product-content-right-bottom-content-title-item baoquan">
                                <p>Decribe</p>
                            </div>
                        </div>
                        <div class="product-content-right-bottom-content">
                            <div class="product-content-right-bottom-content-chitiet">
                                <?php echo nl2br(htmlspecialchars($product['product_desc'])); ?>
                            </div>
                            <div class="product-content-right-bottom-content-baoquan">                                
                                <p><strong>Product name:</strong> <?php echo $product['product_name']; ?></p>
                                <p><strong>Product price:</strong> <?php echo number_format($product['product_price_new'], 0, ',', '.') . "<sup>đ</sup>"; ?></p>
                                <p><strong>Size:</strong> <span id="selected-size">Chưa chọn</span></p>
                                <p><strong>Quantity:</strong> <span id="selected-quantity">1</span></p>
                                <p><strong>Status:</strong> 
                                    <?php 
                                        $total_quantity = array_sum($sizes); // Tính tổng số lượng của tất cả các size
                                        if ($total_quantity > 0) {
                                            echo "In stock";
                                        } else {
                                            echo "Out of stock";
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!----------product-related---------->
    <section class="product-related row">
        <div class="product-related-title">
            <p>Related Products</p>
        </div>
        <?php
        if ($result_related_products->num_rows > 0) {
            while ($related_product = $result_related_products->fetch_assoc()) {
                echo '<div class="product-related-item">';
                echo '<img src="/admin/uploads/' . $related_product['product_img'] . '" alt="">';
                echo '<h1>' . $related_product['product_name'] . '</h1>';
                echo '<p>' . number_format($related_product['product_price'], 0, ',', '.') . '<sup>đ</sup></p>';
                echo '<h4>' . number_format($related_product['product_price_new'], 0, ',', '.') . '<sup>đ</sup></h4>';
                echo '</div>';
            }
        } else {
            echo '<p>Không có sản phẩm liên quan.</p>';
        }
        ?>
    </section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const sizeForm = document.getElementById('size-form');
    const quantityInput = document.getElementById('quantity_input');
    const selectedSizeInput = document.getElementById('selected-size-input');
    const selectedQuantityInput = document.getElementById('selected-quantity-input');
    const selectedSizeSpan = document.getElementById('selected-size');
    const selectedQuantitySpan = document.getElementById('selected-quantity');

    // Khi chọn size
    sizeForm.addEventListener('change', function () {
        const selectedSize = document.querySelector('input[name="product_size"]:checked');
        if (selectedSize) {
            selectedSizeInput.value = selectedSize.value;  // Gán giá trị size vào input ẩn
            selectedSizeSpan.textContent = selectedSize.value;  // Hiển thị size đã chọn
        }
    });

    // Khi thay đổi số lượng
    quantityInput.addEventListener('input', function () {
        const quantity = quantityInput.value;
        selectedQuantityInput.value = quantity;  // Gán số lượng vào input ẩn
        selectedQuantitySpan.textContent = quantity;  // Hiển thị số lượng đã chọn
    });
});
</script>
<?php
include "footer.php";
?>