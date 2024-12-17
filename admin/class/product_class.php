<?php
include "database.php";
?>

<?php

class product {
    private $db;

    public function __construct() {
        $this -> db = new Database();
    }
    // Hiển thị danh mục
    public function show_category(){
        $query = "SELECT * FROM tbl_category ORDER BY category_id DESC";
        $result = $this -> db -> select($query);
        return $result;
    }
    // Hiển thị thương hiệu theo danh mục
    public function show_brand(){
        $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
        $result = $this -> db -> select($query);
        return $result;
    }
    // Hiển thị sản phẩm
    public function show_product() {
        $query = "SELECT 
                    tbl_product.product_id, 
                    tbl_product.product_name, 
                    tbl_product.product_price, 
                    tbl_product.product_price_new, 
                    tbl_product.product_desc, 
                    tbl_product.product_img, 
                    tbl_category.category_name, 
                    tbl_brand.brand_name 
                FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                ORDER BY tbl_product.product_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_product_img_desc($product_id) {
        $query = "SELECT product_img_desc FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // Hiển thị thương hiệu theo danh mục thông qua Ajax
    public function show_brand_ajax($category_id){
        $query = "SELECT * FROM tbl_brand WHERE category_id = '$category_id' ORDER BY brand_id DESC";
        $result = $this -> db -> select($query);
        return $result;
    }
    // Thêm sản phẩm vào cơ sở dữ liệu     
    public function insert_product($data, $files) {
        $product_name = $data['product_name'];
        $category_id = $data['category_id'];
        $brand_id = $data['brand_id'];
        $product_price = $data['product_price'];
        $product_price_new = $data['product_price_new'];
        $product_desc = $data['product_desc'];
        $product_img = $files['product_img']['name'];  
        move_uploaded_file($files['product_img']['tmp_name'], "uploads/" . $files['product_img']['name']);  // Di chuyển ảnh sản phẩm vào thư mục uploads
        // Insert vào bảng sản phẩm
        $query = "INSERT INTO tbl_product (product_name, category_id, brand_id, product_price, product_price_new, product_desc, product_img)
        VALUES ('$product_name', '$category_id', '$brand_id', '$product_price', '$product_price_new', '$product_desc', '$product_img')";
        $result = $this -> db -> insert($query);   
        if($result) {
            // Lấy id sản phẩm vừa thêm vào
            $query = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
            $result = $this -> db -> select($query) -> fetch_assoc();
            $product_id = $result['product_id'];

             // Kiểm tra xem có ảnh mô tả hay không (nếu có thì xử lý)
            if (isset($files['product_img_desc']) && is_array($files['product_img_desc']['name'])) {
                $filenames = $files['product_img_desc']['name'];
                $filttmp = $files['product_img_desc']['tmp_name'];

                foreach ($filenames as $key => $value) {
                    move_uploaded_file($filttmp[$key], "images_desc/" . $value);  // Di chuyển ảnh mô tả
                    $query = "INSERT INTO tbl_product_img_desc (product_id, product_img_desc) VALUES ('$product_id', '$value')";
                    $this->db->insert($query);  // Thêm ảnh mô tả vào bảng
                }
            } else {
                // Nếu chỉ có 1 ảnh mô tả, xử lý như một chuỗi
                $filename = $files['product_img_desc']['name'];
                if ($filename) {
                    // Di chuyển ảnh mô tả vào thư mục images_desc
                    move_uploaded_file($files['product_img_desc']['tmp_name'], "images_desc/" . $filename);  
                    // Thêm ảnh mô tả vào bảng
                    $query = "INSERT INTO tbl_product_img_desc (product_id, product_img_desc) VALUES ('$product_id', '$filename')";
                    $this->db->insert($query);  // Thêm ảnh mô tả vào bảng
                }
            }
        }
        return $result;
    }
    public function get_product($product_id) {
        $query = "SELECT tbl_product.*, tbl_category.category_name, tbl_brand.brand_name 
                FROM tbl_product 
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id 
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id 
                WHERE tbl_product.product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_product($product_id, $data, $files) {
        $product_name = isset($data['product_name']) ? $data['product_name'] : '';
        $category_id = isset($data['category_id']) ? $data['category_id'] : 0;
        $brand_id = isset($data['brand_id']) ? $data['brand_id'] : 0;
        $product_price = isset($data['product_price']) ? $data['product_price'] : 0;
        $product_price_new = isset($data['product_price_new']) ? $data['product_price_new'] : 0;
        $product_desc = isset($data['product_desc']) ? $data['product_desc'] : '';
        header('Location:productlist.php');
    
        // Xử lý ảnh chính
        if (!empty($files['product_img']['name'])) {
            $product_img = $files['product_img']['name'];
            move_uploaded_file($files['product_img']['tmp_name'], "uploads/" . $product_img);
            $query = "UPDATE tbl_product SET 
                        product_name = '$product_name',
                        category_id = '$category_id',
                        brand_id = '$brand_id',
                        product_price = '$product_price',
                        product_price_new = '$product_price_new',
                        product_desc = '$product_desc',
                        product_img = '$product_img' 
                    WHERE product_id = '$product_id'";
        } else {
            $query = "UPDATE tbl_product SET 
                        product_name = '$product_name',
                        category_id = '$category_id',
                        brand_id = '$brand_id',
                        product_price = '$product_price',
                        product_price_new = '$product_price_new',
                        product_desc = '$product_desc'
                    WHERE product_id = '$product_id'";
        }
        $result = $this->db->update($query);
    
        // Xử lý ảnh mô tả
        if (!empty($files['product_img_desc']['name'][0])) {
            $filename = $files['product_img_desc']['name'];
            $filetmp = $files['product_img_desc']['tmp_name'];
    
            foreach ($filename as $key => $value) {
                move_uploaded_file($filetmp[$key], "images_desc/" . $value);
                $query_desc = "INSERT INTO tbl_product_img_desc (product_id, product_img_desc) 
                            VALUES ('$product_id', '$value')";
                $this->db->insert($query_desc);
            }
        }
        return $result;
    }
    //Xóa product
    public function delete_product($product_id) {
        // Xóa ảnh mô tả
        $query_img_desc = "SELECT product_img_desc FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $product_img_desc = $this->db->select($query_img_desc);
    
        if ($product_img_desc) {
            while ($img = $product_img_desc->fetch_assoc()) {
                $product_img_desc_name = $img['product_img_desc'];
                if (file_exists("uploads_desc/$product_img_desc_name")) {
                    unlink("uploads_desc/$product_img_desc_name");
                }
            }
        }
    
        // Xóa dữ liệu trong bảng `tbl_product_img_desc`
        $query_delete_img_desc = "DELETE FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $this->db->delete($query_delete_img_desc);
    
        // Xóa dữ liệu trong bảng `tbl_product`
        $query_delete_product = "DELETE FROM tbl_product WHERE product_id = '$product_id'";
        $delete_product_result = $this->db->delete($query_delete_product);
    
        if ($delete_product_result) {
            return "Sản phẩm và thông tin liên quan đã được xóa thành công.";
        } else {
            return "Lỗi khi xóa sản phẩm.";
        }
    }
    
    //thêm size và quantity
    public function get_all_products() {
        $query = "SELECT * FROM tbl_product";
        $result = $this->db->select($query);
        return $result;
    }
    public function insert_product_size($product_id, $size, $quantity) {
        $query = "INSERT INTO tbl_product_sizes (product_id, size, quantity) 
                VALUES ('$product_id', '$size', '$quantity')";
        $result = $this->db->insert($query);
        if ($result) {
            echo "<script>alert('Size and Quantity added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add Size and Quantity.');</script>";
        }
        return $result;
    }
    



}

?>