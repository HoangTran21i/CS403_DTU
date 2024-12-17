<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
?>

<?php
$brand = new brand;
    $brand_id = $_GET['brand_id'];
    $get_brand = $brand -> get_brand($brand_id);
    if($get_brand) {
        $resultA = $get_brand -> fetch_assoc(); 
    }

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $category_id = $_POST['category_id'];
    $brand_name = $_POST['brand_name'];
    $update_brand = $brand -> update_brand($category_id, $brand_name, $brand_id);
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
                <h1>Update brand</h1> <br>
                <form action="" method="POST">
                    <select name="category_id" id="">
                        <option value="#">--Select Category--</option>
                        <?php
                            $show_category = $brand -> show_category();
                            if($show_category){while($rusult = $show_category -> fetch_assoc()){
                        ?>
                        <option <?php if($resultA['category_id']==$rusult['category_id']) {echo "SELECTED";} ?> value="<?php echo $rusult['category_id'] ?>"><?php echo $rusult['category_name']?></option>
                        <?php
                            }}
                        ?>
                    </select> <br>
                    <input name="brand_name" type="text" placeholder="Nhập tên loại sản phẩm" value="<?php echo $resultA['brand_name'] ?>">
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </section>

</body>
</html>