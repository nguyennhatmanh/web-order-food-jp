<?php
include('partials/menu.php');
?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>
            <br><br>

            <?php
                //1. Lay id cua Admin can sua
                $id = $_GET['id'];
                //2. Cau lenh lay ra du lieu de do len cac textbox
                $sql = "SELECT * FROM tbl_admin WHERE id = $id";

                $res = mysqli_query($conn, $sql);

                if ($res == true){
                    $count = mysqli_num_rows($res);

                    if ($count == 1){
                        $row = mysqli_fetch_assoc($res);

                        $full_name = $row['full_name'];
                        $username = $row['username'];
                    }else{
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                }
            ?>
            <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
    <!-- Main Content Section End -->

<?php
if (isset($_POST['submit'])){
    //echo "btn cl";

    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //cau lenh update
    $sql = "UPDATE tbl_admin SET 
    full_name = '$full_name',
    username = '$username'
    WHERE id = '$id'
    ";

    $res = mysqli_query($conn, $sql);

    if ($res == true){
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }else{
        $_SESSION['update'] = "<div class='success'>Failed to update</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
}
?>

 <?php
include('partials/footer.php');
?>
