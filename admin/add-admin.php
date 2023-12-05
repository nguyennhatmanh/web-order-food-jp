<?php
include('partials/menu.php');
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
    <br><br>

    <?php
    if (isset($_SESSION['add'])){
        echo $_SESSION['add'];
        unset($_SESSION['add']); // xoa session thong bao
    }
    ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Add Admin" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');
?>

<?php
    //Process the Value from Form and Save it in Database

    if(isset($_POST["submit"])){
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];
        $password = md5($_POST["password"]); //ma hoa mat khau

        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";
        
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res == true){
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            //redirect Page to Manage Admin
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }else{
            //echo "Failed Inserted";
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //redirect Page to Manage Admin
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
    }
?>