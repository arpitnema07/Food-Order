<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
          <!-- Button to add food -->
          <br> <br>
          <?php
                if (isset($_SESSION['add-food'])) {
                    echo $_SESSION['add-food']?> <br/><br/><br/><?php ;
                    unset($_SESSION['add-food']);//Removing Session Message
                }
                if (isset($_SESSION['delete-food'])) {
                    echo $_SESSION['delete-food']?> <br/><br/><br/><?php ;
                    unset($_SESSION['delete-food']);//Removing Session Message
                }
                if (isset($_SESSION['update-food'])) {
                    echo $_SESSION['update-food']?> <br/><br/><br/><?php ;
                    unset($_SESSION['update-food']);//Removing Session Message
                }
          ?>
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br> <br> 
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * FROM tbl_food";
                $res = mysqli_query($conn,$sql);
                if ($res==TRUE) {
                    $count = mysqli_num_rows($res);
                    if ($count>0) {
                        //data found
                        $num=1;
                        while ($row=mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $description =$row['description'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $category_id = $row['category_id'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>
                                <tr>
                                    <td><?php echo $num++?>.</td>
                                    <td><?php echo $title?></td>
                                    <td><?php echo $description?></td>
                                    <td><?php echo $price?></td>
                                    <td>
                                        <?php 
                                            if ($image_name!="") {
                                                //display image
                                                ?>
                                                    <img src="<?php echo SITEURL.'images/food/'.$image_name ?>" width="100px">
                                                <?php 
                                            }else {
                                                echo "<div class='error'>Image not found.</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured?></td>
                                    <td><?php echo $active?></td>
                                    <td> 
                                        <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id?>" class="btn-secondary">Update Food</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name?>" class="btn-danger">Delete Food</a>
                                    </td>
                                </tr>
            
                            <?php

                        }
                    }else{
                        //no data found
                        echo "<tr><td colspan='6'><div class='error'>No Food Found.</div></td></tr>";
                        
                    }
                }
            ?>
        </table>
    </div>
</div>
<?php include('partials/footer.php')?>
