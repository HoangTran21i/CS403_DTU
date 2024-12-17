<?php
include "class/product_class.php";
$product = new product;

$product_id = $_GET['product_id'];
$message = $product->delete_product($product_id);

echo "<script>alert('$message'); window.location.href='productlist.php';</script>";
?>
