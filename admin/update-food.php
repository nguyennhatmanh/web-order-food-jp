<?php
include('partials/menu.php');
?>
            <?php
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];

                    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

                    $res2 = mysqli_query($conn, $sql2);

                    $row2 = mysqli_fetch_assoc($res2);

                    $title = $row2['title'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $featured = $row2['featured'];
                    $active = $row2['active'];

                }else
                {
                    header("location:" . SITEURL . 'admin/manage-food.php');
                    
                }
            ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br><br>

            <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>

                <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" id="" cols="30" rows="5"><?php echo $description;?></textarea>
                </td>
                </tr>

                <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price;?>">
                </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                    <?php
                            if ($current_image != "")
                            {
                                //Display Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image;?>" alt="" width="100px">
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
                <td>Category: </td>
                <td>
                    <select name="category" id="">

                    <?php
                             //Create PHP code to display categories from Database
                             $sql =" SELECT * FROM tbl_category WHERE active = 'Yes'";

                             $res = mysqli_query($conn,$sql);
 
                             $count = mysqli_num_rows($res);
 
                             if ($count > 0)
                             {
                                 //We have category
                                 while ($row=mysqli_fetch_assoc($res))
                                 {
                                     //get all details of categories
                                     $category_id = $row['id'];
                                     $category_title = $row['title'];
 
                                     ?>
                                     <option <?php if($current_category==$category_id) {echo "Selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                     <?php
                                 }
                             }else
                             {
                                 //We do not have category
                                 ?>
                                 <option value="0">No Category Found</option>
                                 <?php
                             } 
                    ?>                       
                    </select>
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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
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
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];
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
            $string = explode('.',$image_name);
            $ext = end($string);
    
            //Rename the image
            $image_name = "Food_Name_".rand(000,999).'.'.$ext;
    
            $source_path = $_FILES['image']['tmp_name'];
    
            $destination_path = "../images/food/" . $image_name;
    
            //Finally Upload the Image
            $upload = move_uploaded_file($source_path,$destination_path);
    
            //Check whether the image is uploaded or not
            //And if the image is not uploaded then we will stop the process and redirect with the error message
            if ($upload == false){
                $_SESSION['failed-upload'] = "<div class='error'>Failed to Upload Image</div>";
    
                header("location:" . SITEURL . 'admin/manage-food.php');
    
                //Stop the Process
                die();
            }

            //Remove current image if available
            if ($current_image != ""){
                $remove_path = "../images/food/" . $current_image;
                $remove = unlink($remove_path);
    
                if ($remove == false)
                {
                    //Set the session message
                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
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
    $sql3 = "UPDATE tbl_food SET 
    title = '$title',
    description = '$description',
    price = '$price',
    image_name = '$image_name',
    category_id = '$category',
    featured = '$featured',
    active = '$active'
    WHERE id = '$id'
    ";

    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true){
        $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }else{
        $_SESSION['update'] = "<div class='success'>Failed to update Food</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
}
?>

 <?php
include('partials/footer.php');
?>