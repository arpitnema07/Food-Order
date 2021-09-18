<?php include('partials-front/menu.php'); ?>
    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL.'food-search.php' ?>" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->



    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //display food from database that are active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
                $res = mysqli_query($conn,$sql);
                $count = mysqli_num_rows($res);
                if($count>0){
                    while($row=mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        if($image_name==""){
                                            echo "<div class='error'>Image not available.</div>"; 
                                        }else{
                                            ?>
                                                <img src="<?php echo SITEURL.'images/food/'.$image_name?>" alt="<?php $title?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title?></h4>
                                    <p class="food-price">$<?php echo $price?></p>
                                    <p class="food-detail"><?php echo $description?></p>
                                    <br>

                                    <a href="order.php" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                    }
                }else{
                    echo "<div class='error'>Food not available.</div>";
                }
            
            ?>
            <div class="clearfix"></div>
        </div>

    </section>
    <!-- Food Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>