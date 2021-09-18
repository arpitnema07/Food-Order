<?php
    include('../config/constants.php');
    if (isset($_GET['id']) AND isset($_GET['image_name'])) {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //delete image
        if ($image_name!="") {
            $path = "../images/category/".$image_name;
            $remove = unlink($path);
            if ($remove==FALSE) {
                $_SESSION['delete-cat'] = "<div class='error'>Failed to Remove Category Image</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        $res = mysqli_query($conn,$sql);
        //check whether the query execute successfully
        if($res==TRUE){
            //Category Deleted
            $_SESSION['delete-cat'] = "<div class='success'>Category Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }else{
            //failed
            $_SESSION['delete-cat'] = "<div class='error'>Failed to delete Category</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }else{
        //failed
        $_SESSION['delete-cat'] = "<div class='error'>Error Occurred</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    
?>