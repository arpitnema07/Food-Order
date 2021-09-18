<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            if (!isset($_GET['id'])) {
                $_SESSION['update-cat'] = "<div class='error'>Can't find the Category.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
            if (isset($_SESSION['update-cat'])) {
                echo $_SESSION['update-cat']?> <br/><br/><br/><?php ;
                unset($_SESSION['update-cat']);//Removing Session Message
            }
            //get id of selected category
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id=$id";
            $res = mysqli_query($conn,$sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);
                if ($count==1) {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $cur_img_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                }else{
                    $_SESSION['update-cat'] = "<div class='error'>Can't find the Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if ($cur_img_name!="") {
                                ?> <img src="<?php echo SITEURL.'images/category/'.$cur_img_name?>" width="100px"><?php                               
                            }else{
                                ?> <p class="error">Image not found</p> <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="new_image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") echo 'checked'?> type="radio" name="featured" value="Yes" >Yes
                        <input <?php if($featured=="No") echo 'checked'?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") echo 'checked'?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") echo 'checked'?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $cur_img_name;?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if (isset($_POST['submit'])) {
        //get all value from form
        $id = $_POST['id'];
        $cur_img_name = $_POST['current_image'];
        $title = $_POST['title'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        //update image if new selected
        //check if image is selected or not
        if(isset($_FILES['new_image']['name'])){
            //get image details
            $image_name = $_FILES['new_image']['name'];

            if ($image_name!="") {
                //image available
                $ext = end(explode('.',$image_name));
                $image_name = "Food_Category_".$title.'_'.rand(000,999).'.'.$ext;
                
                $source_path = $_FILES['new_image']['tmp_name'];
                $destination_path = "../images/category/".$image_name;
                $upload = move_uploaded_file($source_path,$destination_path);
                //check whether image uploaded or not
                if($upload==false){
                    $_SESSION['update-cat'] = "<div class='error'>Failed to upload image.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //stop process
                    die();
                }
                if ($cur_img_name!="") {
                    $remove_path = "../images/category/".$cur_img_name;
                    $remove = unlink($remove_path);
                    if ($remove==FALSE) {
                        $_SESSION['update-cat'] = "<div class='error'>Failed to Remove Category Image</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                    }
                }
                
            }else {
                $image_name = $cur_img_name;
            }
            
        }else {
            $image_name = $cur_img_name;
        }
        

        // update category
        $sql2 = "UPDATE tbl_category SET
        title = '$title',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'
        WHERE id='$id'";

        $res2 = mysqli_query($conn,$sql2);
        //redirect according result
        if ($res2==TRUE) {
            $_SESSION['update-cat'] = "<div class='success'>Category Updated Successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }else{
            $_SESSION['update-cat'] = "<div class='error'>Failed to Update Category</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

    }
?>


<?php include('partials/footer.php')?>
