<?php
include('partials/menu.php');
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
    <br><br>

    <?php
          if (isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']); // xoa session thong bao
        }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Enter title food">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" placeholder="Enter food price">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
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
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    </div>
</div>

<?php
include('partials/footer.php');
?>

<?php
if (isset($_POST['submit']))
{
    //Add the food in Database

    //1. Get the data from Form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    //Check radio btn featured and active
    if(isset($_POST['featured'])){
        $featured = $_POST['featured'];
    }else{
        $featured = "No";

    }

    if(isset($_POST['active'])){
        $active = $_POST['active'];
    }else{
        $active = "No";

    }

    //2. Upload the image if selected
   if (isset($_FILES['image']['name'])){
        //Upload the Image
        //To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        //Upload the Image only if image is selected
        if($image_name!="")
        {
            //Auto Rename out image
            //Extenstion
            $ext = end(explode('.',$image_name));
    
            //Rename the image
            $image_name = "Food_Name_".rand(000,999).'.'.$ext;
    
            $source_path = $_FILES['image']['tmp_name'];
    
            $destination_path = "../images/food/" . $image_name;
    
            //Finally Upload the Image
            $upload = move_uploaded_file($source_path,$destination_path);
    
            //Check whether the image is uploaded or not
            //And if the image is not uploaded then we will stop the process and redirect with the error message
            if ($upload == false){
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
    
                header("location:" . SITEURL . 'admin/add-food.php');
    
                //Stop the Process
                die();
            }

        }
    }
    else
    {
        //Dont upload Image an set the image_value as blank
        $image_name = "";
    }
    //3. Insert into database
    $sql2 = "INSERT INTO tbl_food SET
    title = '$title',
    description = '$description',
    price = '$price',
    image_name = '$image_name',
    category_id = '$category',
    featured = '$featured',
    active = '$active'
    ";

    $res2 = mysqli_query($conn, $sql2);

    if($res2 == true){

        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
    
        header("location:" . SITEURL . 'admin/manage-food.php');
    }else{
    
        $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
    
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
    //4. Redirect with Message to Manage Food page
}
?>


