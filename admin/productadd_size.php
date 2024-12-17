<?php
include "header.php";
include "slider.php";
include "class/product_class.php";

$product = new product;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];

    $insert_size_quantity = $product->insert_product_size($product_id, $size, $quantity);
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-product_add">
        <h1>Add Size and Quantity</h1>
        <form action="" method="post">
            <label for="">Select Product<span style="color: red;">*</span></label>
            <select name="product_id" required>
                <option value="">-- Select Product --</option>
                <?php 
                    $product_list = $product->get_all_products();
                    if ($product_list) {
                        while ($result = $product_list->fetch_assoc()) {
                ?>
                <option value="<?php echo $result['product_id']; ?>">
                    <?php echo $result['product_name']; ?>
                </option>
                <?php
                        }
                    }
                ?>
            </select>

            <label for="">Size<span style="color: red;">*</span></label>
            <input name="size" type="text" required placeholder="e.g., S, M, L, XL">

            <label for="">Quantity<span style="color: red;">*</span></label>
            <input name="quantity" type="number" required placeholder="Enter quantity">

            <button type="submit">Add</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
