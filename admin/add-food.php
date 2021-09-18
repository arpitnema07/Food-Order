<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="Description of the food."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                                //create php code to display category from database 
                                // create sql query to get all active category
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute query
                                $res = mysqli_query($conn,$sql);
                                //count rows
                                $count = mysqli_num_rows($res);
                                //if count is greater then zero we have category else we don't have category
                                if($count>0){
                                        //we have category
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        //get the details
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?> <option value="<?php echo $id; ?>"> <?php echo $title; ?> </option> <?php
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
                        <input type="submit" value="Add Food" name="submit" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>


        <?php
            //check whether submit clicked
            if (isset($_POST['submit'])) {
                //add food in database
                // echo "Clicked";
                //get data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category =$_POST['category'];

                //check the radio button iis selected or not
                if (isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }else{
                    $featured = "No"; //setting default value
                }
                
                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "No"; //setting default value
                }
                // check whether the select image button is clicked or not
                //only then upload image
                if(isset($_FILES['image']['name'])){
                    //get details of selected image
                    $image_name = $_FILES['image']['name'];
                    //check whether image is selected or not
                    if($image_name!=""){
                        //Image select
                        //rename image
                        $ext =end(explode('.',$image_name));
                        $image_name = "Food_Name_".$title.'_'.rand(000,999).'.'.$ext;
                        // source path is the current location of the image
                        $source_path = $_FILES['image']['tmp_name'];
                        // destination path is the path where image to be uploaded
                        $destination_path = "../images/food/".$image_name;
                        //upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);
                        //check whether image uploaded or not
                        if($upload==false){
                            $_SESSION['add-food'] = "<div class='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop process
                            die();
                        }
                    }
                }else{
                    $image_name = '';
                }
                //insert data into database
                $sql2 = "INSERT INTO tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'";

                $res = mysqli_query($conn,$sql2);
                // redirect with msg
                if ($res==TRUE) {
                    $_SESSION['add-food'] = "<div class='success'>Added Food Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                } else {
                    $_SESSION['add-food'] = "<div class='error'>Failed to Add Food</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                }
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php')?>