<?php
//Include constants.php here
include('../config/constants.php');

//1. Lay ra id cua admin can xoa
$id = $_GET['id'];
//2. tao cau lenh xoa
$sql = "DELETE FROM tbl_admin WHERE id = $id";

$res = mysqli_query($conn, $sql);

if ($res == true){
    //echo "Da Xoa";

    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
    header("location:" . SITEURL . 'admin/manage-admin.php');
}else{
    //echo "Xoa That bai";

    $_SESSION['delete'] = "<div class='error'>Admin Deleted Failed</div>";
    header("location:" . SITEURL . 'admin/manage-admin.php');
}
//3. Tao loi nhan xoa thanh cong/that bai
?>