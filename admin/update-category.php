<?php
include('partials/menu.php');
?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>
            <br><br>

            <?php
                $id = $_GET['id'];
                //2. Cau lenh lay ra du lieu de do len cac textbox
                $sql = "SELECT * FROM tbl_category WHERE id = $id";

                $res = mysqli_query($conn, $sql);

                if ($res == true){
                    $count = mysqli_num_rows($res);

                    if ($count == 1){
                        $row = mysqli_fetch_assoc($res);

                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }else{
                        header("location:" . SITEURL . 'admin/manage-category.php');
                    }
                }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if ($current_image != "")
                            {
                                //Display Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>" alt="" width="100px">
                                <?php
                            }
                            else
                            {
                                //Display Message
                                echo "<div class = 'error'>Image Not Added </div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") echo "checked"; ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") echo "checked"; ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") echo "checked"; ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") echo "checked"; ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
    <!-- Main Content Section End -->

<?php
if (isset($_POST['submit'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //Updating new image if selected
    //Check image selected or not
    if (isset($_FILES['image']['name']))
    {
        //Get the iamge details
        $image_name = $_FILES['image']['name'];

        //Check image is available or not
        if ($image_name != "")
        {
            //Image Available
            //Upload the new image
                        //Auto Rename out image
            //Extenstion
            $ext = end(explode('.',$image_name));
    
            //Rename the image
            $image_name = "Food_Category_".rand(000,999).'.'.$ext;
    
            $source_path = $_FILES['image']['tmp_name'];
    
            $destination_path = "../images/category/" . $image_name;
    
            //Finally Upload the Image
            $upload = move_uploaded_file($source_path,$destination_path);
    
            //Check whether the image is uploaded or not
            //And if the image is not uploaded then we will stop the process and redirect with the error message
            if ($upload == false){
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
    
                header("location:" . SITEURL . 'admin/manage-category.php');
    
                //Stop the Process
                die();
            }

            //Remove current image if available
            if ($current_image != ""){
                $remove_path = "../images/category/" . $current_image;
                $remove = unlink($remove_path);
    
                if ($remove == false)
                {
                    //Set the session message
                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                    header("location:" . SITEURL . 'admin/manage-category.php');
                    die();
                }
            }

        }else
        {
            $image_name = $current_image;
        }
    }
    else
    {
        $image_name = $current_image;
    }

    //cau lenh update
    $sql = "UPDATE tbl_category SET 
    title = '$title',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    WHERE id = '$id'
    ";

    $res = mysqli_query($conn, $sql);

    if ($res == true){
        $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-category.php');
    }else{
        $_SESSION['update'] = "<div class='success'>Failed to update Category</div>";
        header("location:" . SITEURL . 'admin/manage-category.php');
    }
}
?>

 <?php
include('partials/footer.php');
?>