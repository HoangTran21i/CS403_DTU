<?php
include "header.php";
include "slider.php";
include "class/category_class.php";
?>

<?php
$category = new category;
$show_category = $category -> show_category();
?>

<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Category List</h1>
                <table>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if($show_category){$i=0;
                        while($result = $show_category->fetch_assoc()) {$i++;
                    
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['category_id'] ?></td>
                        <td><?php echo $result['category_name'] ?></td>
                        <td><a href="categoryedit.php?category_id=<?php echo $result['category_id'] ?>">Update</a>|<a href="categorydelete.php?category_id=<?php echo $result['category_id'] ?>"onclick="return confirm('Are you sure you want to delete this news?');">Delete</a></td>
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