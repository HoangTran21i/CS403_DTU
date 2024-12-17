<?php
session_start();
include "database.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Bắt đầu giao dịch (transaction) để đảm bảo mọi thao tác xóa đều thành công hoặc không có gì thay đổi nếu gặp lỗi
$conn->begin_transaction();

try {
    // Lấy danh sách các sản phẩm trong giỏ hàng của người dùng
    $stmt = $conn->prepare(
        "SELECT c.product_id, c.size, c.quantity, p.product_price_new " .
        "FROM tbl_cart c " .
        "INNER JOIN tbl_product p ON c.product_id = p.product_id " .
        "WHERE c.user_id = ?"
    );
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Duyệt qua từng sản phẩm trong giỏ hàng và xóa khỏi bảng tbl_product_sizes và tbl_cart
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $size = $row['size'];
        $quantity = $row['quantity'];

        // Cập nhật số lượng trong bảng tbl_product_sizes
        $stmt = $conn->prepare(
            "UPDATE tbl_product_sizes SET quantity = quantity - ? WHERE product_id = ? AND size = ?"
        );
        $stmt->bind_param("iis", $quantity, $product_id, $size);
        $stmt->execute();

        // Kiểm tra nếu số lượng trong tbl_product_sizes giảm xuống 0 hoặc âm thì xóa bản ghi đó
        $stmt = $conn->prepare(
            "DELETE FROM tbl_product_sizes WHERE product_id = ? AND size = ? AND quantity <= 0"
        );
        $stmt->bind_param("is", $product_id, $size);
        $stmt->execute();
    }

    // Sau khi xóa, xóa tất cả các sản phẩm trong giỏ hàng của người dùng
    $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Cam kết (commit) giao dịch
    $conn->commit();

    // Lưu thông báo thanh toán thành công vào session
    $_SESSION['payment_message'] = "Thanh toán thành công! Cảm ơn bạn đã mua sắm. Sản phẩm của bạn đã được xử lý.";


} catch (Exception $e) {
    // Nếu có lỗi, rollback giao dịch
    $conn->rollback();
    // Lưu thông báo lỗi vào session
    $_SESSION['payment_message'] = "Lỗi xảy ra trong quá trình thanh toán.";
}

include "header.php";
?>

<section class="payment">
    <div class="container">
    <?php
        // Kiểm tra nếu có thông báo trong session và hiển thị
        if (isset($_SESSION['payment_message'])) {
            echo "<h1>" . $_SESSION['payment_message'] . "</h1>";
            // Sau khi hiển thị thông báo, bạn có thể xóa nó khỏi session để không hiển thị lại trong lần sau
            unset($_SESSION['payment_message']);
        }
        ?>
        <p>Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ để xác nhận đơn hàng.</p>
        <a href="/user/index.php" style="color: brown; font-size: 20px;">Quay lại trang chủ</a>
    </div>
</section>

<?php include "footer.php"; ?>
