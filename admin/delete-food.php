<?php
//Include Constants file

include('../config/constants.php');
//echo "Delete Page";
//Check id and image_name value is set or not

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //Get the value and delete
    //echo "get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if($image_name != "")
    {
        //image is Available. So remove it
        $path = "../images/food/" . $image_name;
        //remove the image
        $remove = unlink($path);
        //if failed the remove image then add an error message anad stop the process
        if ($remove == false)
        {
            //Set the session message
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Food Image</div>";
            header("location:" . SITEURL . 'admin/manage-food.php');
            die();
        }
    }

    //Delete Data from Database
    $sql = "DELETE FROM tbl_food WHERE id = $id";

    $res = mysqli_query($conn, $sql);

    if ($res == true){
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }else{
        //echo "Xoa That bai";
    
        $_SESSION['delete'] = "<div class='error'>Food Deleted Failed</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
    
}
else
{
    //Redirect to Manage Food Page
    $_SESSION['unauthorize']= "<div class='error'>Unauthorized Access</div>";
    header("location:" . SITEURL . 'admin/manage-food.php');
}
?>