<?php
    include('../config/constants.php');
    //get the id of admin to delete
    $id = $_GET['id'];
    //create sql query to delete the admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    //execute query
    $res = mysqli_query($conn,$sql);
    //check whether the query execute successfully
    if($res==TRUE){
        //Admin Deleted
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }else{
        //failed
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //redirect to manage admin page with a msg

?>