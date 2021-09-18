<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php 
            if (isset($_SESSION['add-cat'])) {
                echo $_SESSION['add-cat']?> <br/><br/><br/><?php ;
                unset($_SESSION['add-cat']);//Removing Session Message
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Image: </td>
                    <td>
                        <input type="file" name="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Feature: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                
                if (isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else {
                    $featured = "No";
                }
                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "No";
                }
                //check image is select or not
                if (isset($_FILES['image']['name'])) {
                    //upload image
                    $image_name = $_FILES['image']['name'];
                    if ($image_name!="") {
                        // Auto Rename image
                        // Get Extension of our image
                        $ext = end(explode('.',$image_name));
                        $image_name = "Food_Category_".$title.'_'.rand(000,999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;
                        $upload = move_uploaded_file($source_path,$destination_path);
                        //check whether image uploaded or not
                        if($upload==false){
                            $_SESSION['add-cat'] = "<div class='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop process
                            die();
                        }
                    }
                }else{
                    //don't upload image leave it blank
                    $image_name = "";
                }

                $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'";

                $res = mysqli_query($conn,$sql);

                if ($res==TRUE) {
                    $_SESSION['add-cat'] = "<div class='success'>Added Category Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                } else {
                    $_SESSION['add-cat'] = "<div class='error'>Failed to Add Category</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php')?>