<?php
include "header.php";
include "slider.php";
include "class/product_class.php";
?>

<?php
$product = new product;
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $insert_product = $product -> insert_product($_POST, $_FILES);
}
?>

<div class="admin-content-right">
<div class="admin-content-right-product_add">
                <h1>Add products</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Enter product name<span style="color: red;">*</span></label>
                    <input name="product_name" required type="text">

                    <label for="">--Select Category--<span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="#">--Select--</option>
                        <?php 
                            $show_category = $product -> show_category();
                            if($show_category) {while($result = $show_category -> fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result['category_id'] ?> "><?php echo $result['category_name'] ?></option>
                        <?php 
                            }}
                        ?>
                    </select>
                    
                    <label for="">Select Brand<span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <label for="">Select Brand<span style="color: red;">*</span></label>
                        <option value="#">--Select--</option>
                    </select>

                    <label for="">Product price<span style="color: red;">*</span></label>
                    <input name="product_price" type="text" required>

                    <label for="">Promotional price<span style="color: red;">*</span></label>
                    <input name="product_price_new" type="text">

                    <label for="">Product Description<span style="color: red;">*</span></label>
                    <textarea required name="product_desc" id="" cols="30" rows="10"></textarea>

                    <label for="">Product image<span style="color: red;">*</span></label>
                    <input name="product_img" type="file">

                    <label for="">Product image desc<span style="color: red;">*</span></label>
                    <input name="product_img_desc" multiple type="file">
                    
                    <button type="submit">Add</button>
                </form>
            </div>
        </div>
    </section>

</body>


<script>
    // Ajax để cập nhật danh sách loại sản phẩm khi chọn danh mục
    $(document).ready(function(){
        $("#category_id").change(function(){
            var category_id = $(this).val();
            if(category_id != '#') {
                $.get("productadd_ajax.php", {category_id: category_id}, function(data){
                    $("#brand_id").html(data);  // Cập nhật danh sách thương hiệu
                });
            } else {
                $("#brand_id").html("<option value='#'>--Chọn--</option>");
            }
        });
    });
</script>
</html>