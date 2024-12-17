<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
?>

<?php
$brand = new brand;
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $category_id = $_POST['category_id'];
    $brand_name = $_POST['brand_name'];
    $insert_brand = $brand -> insert_brand($category_id, $brand_name);
}
?>
<style>
    select {
        height: 30px;
        width: 200px;
    }
</style>
<div class="admin-content-right">
            <div class="admin-content-right-category_add">
                <h1>Add brand</h1> <br>
                <form action="" method="POST">
                    <select name="category_id" id="">
                        <option value="#">--Select Category--</option>
                        <?php
                            $show_category = $brand -> show_category();
                            if($show_category){while($rusult = $show_category -> fetch_assoc()){
                        ?>
                        <option value="<?php echo $rusult['category_id'] ?>"><?php echo $rusult['category_name']?></option>
                        <?php
                            }}
                        ?>
                    </select> <br>
                    <input name="brand_name" type="text" placeholder="Nhập tên loại sản phẩm">
                    <button type="submit">Add brand</button>
                </form>
            </div>
        </div>
    </section>

</body>
</html>