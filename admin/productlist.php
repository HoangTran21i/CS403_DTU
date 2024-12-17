<?php
include "header.php";
include "slider.php";
include "class/product_class.php";
?>
<?php
$product = new product;
$show_product = $product -> show_product();
?>
<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Product List</h1>
                <table>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Product price</th>
                        <th>Promotional price</th>
                        <th>Product image</th>
                        <th>Product image desc</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if($show_product){$i=0;
                        while($result = $show_product->fetch_assoc()) {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['product_id'] ?></td>
                        <td><?php echo $result['category_name'] ?></td>
                        <td><?php echo $result['brand_name'] ?></td>
                        <td><?php echo $result['product_price'] ?></td>
                        <td><?php echo $result['product_price_new'] ?></td>
                        <td><img src="uploads/<?php echo $result['product_img'] ?>" width="100" height="100" alt="product image"></td>
                        <td>
                            <?php
                            // Hiển thị ảnh mô tả nếu có
                            $product_id = $result['product_id'];
                            $show_product_desc = $product->show_product_img_desc($product_id);
                            if ($show_product_desc) {
                                while ($desc = $show_product_desc->fetch_assoc()) {
                                    echo '<img src="images_desc/' . $desc['product_img_desc'] . '" width="50" height="50" alt="description image">';
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <a href="productedit.php?product_id=<?php echo $result['product_id'] ?>">Update</a> | 
                            <a href="productdelete.php?product_id=<?php echo $result['product_id'] ?>"onclick="return confirm('Are you sure you want to delete this news?');">Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                    ?>
                </table>
            </div>
</div>

    </section>
</body>
</html>