<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bộ sưu tập</title>
</head>
<body>
    <!----------header---------->
    <header>
        <div class="logo">
            <a href="index.php"> <img src="../images/logopage.jpg"></a>
        </div>
        <div class="menu">
                <?php
                // Hiển thị danh mục
                if ($result_category->num_rows > 0) {
                    while ($row_category = $result_category->fetch_assoc()) {
                        // Tạo URL cho category
                        $category_name = strtolower($row_category['category_name']); // Chuyển thành chữ thường
                        $category_url = "user_" . $category_name . ".php"; // Tạo tên file đích

                        echo "<li><a href='" . $category_url . "'>" . $row_category['category_name'] . "</a>";
                        
                        // Hiển thị thương hiệu theo từng danh mục
                        if (isset($brands_by_category[$row_category['category_id']])) {
                            echo "<ul class='sub-menu'>";
                            foreach ($brands_by_category[$row_category['category_id']] as $brand) {
                                // Tạo URL cho brand
                                $brand_name = strtolower(str_replace(' ', '_', $brand)); // Chuyển thành chữ thường và thay khoảng trắng bằng _
                                $brand_url = "brand_" . $brand_name . ".php"; // Tạo tên file đích

                                echo "<li><a href='" . $brand_url . "'>" . $brand . "</a></li>";
                            }
                            echo "</ul>";
                        }
                        echo "</li>";
                    }
                } else {
                    echo "<li>Không có danh mục.</li>";
                }
                ?>
        </div>
        <div class="others">
            <li>
                <form action="search.php" method="GET" style="display: flex; align-items: center;">
                    <input name="keyword" placeholder="Search..." type="text" required>
                    <button type="submit" style="background: none; border: none; cursor: pointer;"><i class="fas fa-search"></i></button>       
                </form>
            </li>
            <li><a class="fa fa-user" href="info_user_edit.php"></a></li>
            <li><a class="fa fa-shopping-bag" href="cart.php"></a></li>
            <li><a class="fa-solid fa-right-from-bracket" href="/logout.php"></a></li>
        </div>
    </header>