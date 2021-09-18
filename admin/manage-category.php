<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Category</h1>
          <!-- Button to add category -->
        <br>
        <br> 
        <?php 
            if (isset($_SESSION['add-cat'])) {
                echo $_SESSION['add-cat']?> <br/><br/><br/><?php ;
                unset($_SESSION['add-cat']);//Removing Session Message
            }
            if (isset($_SESSION['delete-cat'])) {
                echo $_SESSION['delete-cat']?> <br/><br/><br/><?php ;
                unset($_SESSION['delete-cat']);//Removing Session Message
            }
            if (isset($_SESSION['update-cat'])) {
                echo $_SESSION['update-cat']?> <br/><br/><br/><?php ;
                unset($_SESSION['update-cat']);//Removing Session Message
            }
        ?>
        <a href="<?php echo SITEURL?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br> <br> 
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn,$sql);
                if ($res==TRUE) {
                    $count = mysqli_num_rows($res);
                    if ($count>0) {
                        //data found
                        $num=1;
                        while ($row=mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>
                                <tr>
                                    <td><?php echo $num++?>.</td>
                                    <td><?php echo $title?></td>
                                    <td>
                                        <?php 
                                            if ($image_name!="") {
                                                //display image
                                                ?>
                                                    <img src="<?php echo SITEURL.'images/category/'.$image_name ?>" width="100px">
                                                <?php 
                                            }else {
                                                echo "<div class='error'>Image not found.</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured?></td>
                                    <td><?php echo $active?></td>
                                    <td> 
                                        <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id?>" class="btn-secondary">Update Category</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name?>" class="btn-danger">Delete Category</a>
                                    </td>
                                </tr>
            
                            <?php

                        }
                    }else{
                        //no data found
                        ?>
                        <tr>
                            <td colspan="6"><div class="error">No Category Found.</div></td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </table>
    </div>
</div>
<?php include('partials/footer.php')?>