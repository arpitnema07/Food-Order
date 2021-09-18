<?php
    include('../config/constants.php');
    if (isset($_GET['id']) AND isset($_GET['image_name'])) {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //delete image
        if ($image_name!="") {
            $path = "../images/food/".$image_name;
            $remove = unlink($path);
            if ($remove==FALSE) {
                $_SESSION['delete-cat'] = "<div class='error'>Failed to Remove Image Image</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn,$sql);
        //check whether the query execute successfully
        if($res==TRUE){
            //Category Deleted
            $_SESSION['delete-food'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }else{
            //failed
            $_SESSION['delete-food'] = "<div class='error'>Failed to delete Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }else{
        //failed
        $_SESSION['delete-food'] = "<div class='error'>Error Occurred</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    
?>