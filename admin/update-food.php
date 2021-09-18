<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
            if (!isset($_GET['id'])) {
                $_SESSION['update-food'] = "<div class='error'>Can't find the Category.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
            if (isset($_SESSION['update-food'])) {
                echo $_SESSION['update-food']?> <br/><br/><br/><?php ;
                unset($_SESSION['update-food']);//Removing Session Message
            }
            //get id of selected category
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_food WHERE id=$id";
            $res = mysqli_query($conn,$sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);
                if ($count==1) {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $description =$row['description'];
                    $price =$row['price'];
                    $cur_img_name = $row['image_name'];
                    $category_id = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                }else{
                    $_SESSION['update-food'] = "<div class='error'>Can't find the Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food" value="<?php echo $title;?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="Description of the food."><?php echo $description;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if ($cur_img_name!="") {
                                ?> <img src="<?php echo SITEURL.'images/food/'.$cur_img_name?>" width="100px"><?php                               
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
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                                //create php code to display category from database 
                                // create sql query to get all active category
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute query
                                $res2 = mysqli_query($conn,$sql2);
                                //count rows
                                $count2 = mysqli_num_rows($res2);
                                //if count is greater then zero we have category else we don't have category
                                if($count2>0){
                                        //we have category
                                    while ($row2=mysqli_fetch_assoc($res2)) {
                                        //get the details
                                        $id2 = $row2['id'];
                                        $title2 = $row2['title'];
                                        ?> <option <?php if($id2==$category_id) echo 'selected' ?> value="<?php echo $id2; ?>"> <?php echo $title2; ?> </option> <?php
                                    }

                                }else{
                                    //we don't have category
                                    ?> <option value="0">No Category Found</option> <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") echo 'checked'?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") echo 'checked'?> type="radio" name="featured" value="No"> No
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
                        <input type="submit" value="Update Food" name="submit" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if (isset($_POST['submit'])) {
        //get all value from form
        $id3 = $_POST['id'];
        $cur_img_name3 = $_POST['current_image'];
        $title3 = $_POST['title'];
        $description3 =$_POST['description'];
        $price3 = $_POST['price'];
        $category_id3 =$_POST['category_id'];
        $featured3 = $_POST['featured'];
        $active3 = $_POST['active'];

        //update image if new selected
        //check if image is selected or not
        if(isset($_FILES['new_image']['name'])){
            //get image details
            $image_name3 = $_FILES['new_image']['name'];

            if ($image_name3!="") {
                //image available
                $ext = end(explode('.',$image_name3));
                $image_name3 = "Food_Name_".$title3.'_'.rand(000,999).'.'.$ext;
                
                $source_path = $_FILES['new_image']['tmp_name'];
                $destination_path = "../images/food/".$image_name3;
                $upload = move_uploaded_file($source_path,$destination_path);
                //check whether image uploaded or not
                if($upload==false){
                    $_SESSION['update-cat'] = "<div class='error'>Failed to upload image.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    //stop process
                    die();
                }
                if ($cur_img_name3!="") {
                    $remove_path = "../images/food/".$cur_img_name3;
                    $remove = unlink($remove_path);
                    if ($remove==FALSE) {
                        $_SESSION['update-cat'] = "<div class='error'>Failed to Remove Food Image</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }
                }
                
            }else {
                $image_name3 = $cur_img_name3;
            }
            
        }else {
            $image_name3 = $cur_img_name3;
        }
        

        // update category
        $sql3 = "UPDATE tbl_food SET
        title = '$title3',
        description = '$description3',
        price = '$price3',
        image_name = '$image_name3',
        category_id = '$category_id3',
        featured = '$featured3',
        active = '$active3'
        WHERE id='$id3'";

        $res3 = mysqli_query($conn,$sql3);
        $error = mysqli_error($conn);

        //redirect according result
        if ($res3==TRUE) {

            $_SESSION['update-food'] = "<div class='success'>Food Updated Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }else{
            $_SESSION['update-food'] = "<div class='error'>Failed to Update Food $error</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }
?>


<?php include('partials/footer.php')?>
