<?php
include('partials/menu.php');
?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Category</h1>
            <br>
            <?php
                if (isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']); // xoa session thong bao
                }

                if (isset($_SESSION['remove'])){
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']); // xoa session thong bao
                }

                if (isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']); // xoa session thong bao
                }

                if (isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']); // xoa session thong bao
                }

                if (isset($_SESSION['upload'])){
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']); // xoa session thong bao
                }

                if (isset($_SESSION['failed-remove'])){
                    echo $_SESSION['failed-remove'];
                    unset($_SESSION['failed-remove']); // xoa session thong bao
                }
            ?>
            <br><br><br>
<a href="add-category.php" class="btn-primary">Add Category</a>

<br><br><br>
<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>
    <?php
                    $sql = "SELECT * FROM tbl_category";

                    $res = mysqli_query($conn, $sql);

                    if ($res == TRUE){
                        $count = mysqli_num_rows($res); //Function to get all row in database

                        $sn = 1; // bien dem stt
                        if ($count>0){
                            //we have data in database
                            while($rows = mysqli_fetch_assoc($res)){
                                //using While loop to get all the data from database

                                $id = $rows['id'];
                                $title = $rows['title'];
                                $image_name = $rows['image_name'];
                                $featured = $rows['featured'];
                                $active = $rows['active'];
                                
                                ?>
                                    <tr>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $title; ?></td>
                                        <td>
                                            <?php 
                                            if ($image_name != ""){
                                                //Display the image
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }else
                                            {
                                                echo "<div class = 'error'>Image not added </div>";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?> &image_name=<?php echo $image_name;?>" class="btn-secondary">Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?> &image_name=<?php echo $image_name;?> " class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }else{
                            //we do not have data in database
                            echo "<tr> <td colspan = '7' class='error'> Category not Added Yet </td> </tr>";

                        }
                    }
                ?>

</table>
        </div>
    </div>
    <!-- Main Content Section End -->

<?php
include('partials/footer.php');
?>