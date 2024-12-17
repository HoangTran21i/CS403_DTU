<?php
session_start();
include('database.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// Xử lý các thao tác giỏ hàng (thêm, cập nhật, xóa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $product_id = $_POST['product_id'];
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $size = $_POST['product_size'] ?? '';

    if ($product_id <= 0 || empty($size)) {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không hợp lệ.']);
        exit();
    }

    switch ($action) {
        case 'add':
            if ($quantity <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Số lượng không hợp lệ.']);
                exit();
            }
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            $stmt = $conn->prepare("SELECT * FROM tbl_cart WHERE product_id = ? AND user_id = ? AND size = ?");
            $stmt->bind_param("iis", $product_id, $user_id, $size);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Sản phẩm đã tồn tại, cập nhật số lượng
                $stmt = $conn->prepare("UPDATE tbl_cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ? AND size = ?");
                $stmt->bind_param("iiis", $quantity, $product_id, $user_id, $size);
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $stmt = $conn->prepare("INSERT INTO tbl_cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiis", $user_id, $product_id, $size, $quantity);
            }
            $stmt->execute();
            break;
        case 'update':
            if ($quantity > 0) {
                $stmt = $conn->prepare("UPDATE tbl_cart SET quantity = ? WHERE product_id = ? AND user_id = ? AND size = ?");
                $stmt->bind_param("iiis", $quantity, $product_id, $user_id, $size);
                $stmt->execute();
            }
            break;
        case 'delete':
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE cart_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $product_id, $user_id);  // Sử dụng cart_id và user_id để xóa đúng sản phẩm
            $stmt->execute();
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ.']);
            exit();
    }

    // Tính lại tổng giá trị giỏ hàng sau khi thao tác
    $stmt = $conn->prepare(
        "SELECT SUM(c.quantity * p.product_price_new) AS total_price " .
        "FROM tbl_cart c " .
        "INNER JOIN tbl_product p ON c.product_id = p.product_id " .
        "WHERE c.user_id = ?"
    );
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_price = $row['total_price'] ?? 0;

    echo json_encode(['status' => 'success', 'total_price' => number_format($total_price, 0, ',', '.') . " VND"]);
    exit();
}

// Lấy danh sách sản phẩm trong giỏ hàng
$stmt = $conn->prepare(
    "SELECT c.cart_id, c.quantity, p.product_name, p.product_price_new, p.product_img, c.size " .
    "FROM tbl_cart c " .
    "INNER JOIN tbl_product p ON c.product_id = p.product_id " .
    "WHERE c.user_id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
// Tính tổng giá trị giỏ hàng
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['quantity'] * $item['product_price_new'];
}
?>
<?php include "header.php"; ?>

<section class="cart">
    <div class="container">
        <h1>Cart</h1>
        <?php if (count($cart_items) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><img src="/admin/uploads/<?php echo $item['product_img']; ?>" alt="" width="50px"></td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo number_format($item['product_price_new'], 0, ',', '.'); ?> VND</td>                   
                        <td>
                            <input type="number" value="<?php echo $item['quantity']; ?>" min="1" 
                                data-product-id="<?php echo $item['cart_id']; ?>" class="update-quantity">
                        </td>
                        <td><?php echo number_format($item['quantity'] * $item['product_price_new'], 0, ',', '.'); ?> VND</td>
                        <td>
                            <button class="delete-item" data-product-id="<?php echo $item['cart_id']; ?>">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;"><?php echo number_format($total_price, 0, ',', '.') . "<sup>đ</sup>"; ?></td>
                </tr>
            </tbody>
        </table>
            <button class="btn-checkout"><a href="payment.php">Thanh toán</a></button>
    <?php else: ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
    </div>
</section>
<script>
    $(document).on('change', '.update-quantity', function () {
    const productId = $(this).data('product-id');
    const quantity = $(this).val();

    $.post('cart.php', { action: 'update', product_id: productId, quantity: quantity }, function (data) {
        const response = JSON.parse(data);
        if (response.status === 'success') {
            $('#total-price').text(response.total_price);
            location.reload();
        }
    });
});
// Handle delete action
document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-product-id');
            const userId = <?php echo $user_id; ?>;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Remove the cart item row
                        const row = document.querySelector(`button[data-product-id="${cartId}"]`).closest('tr');
                        row.remove();

                        // Update the total price
                        document.querySelector('.total-price').innerText = response.total_price;
                    } else {
                        alert(response.message);
                    }
                }
            };
            xhr.send('action=delete&product_id=' + cartId + '&user_id=' + userId);
        });
    });

    // Handle quantity update
    document.querySelectorAll('.update-quantity').forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.getAttribute('data-product-id');
            const newQuantity = this.value;
            const userId = <?php echo $user_id; ?>;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Update the total price
                        document.querySelector('.total-price').innerText = response.total_price;
                    } else {
                        alert(response.message);
                    }
                }
            };
            xhr.send('action=update&product_id=' + cartId + '&quantity=' + newQuantity + '&user_id=' + userId);
        });
    });
</script>
<?php include "footer.php"; ?>
