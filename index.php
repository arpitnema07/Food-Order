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
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //create sql to fetch data from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Execute query
                $res = mysqli_query($conn,$sql);
                //count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0){
                    //category available
                    while ($row=mysqli_fetch_assoc($res)) {
                        //get the value
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL.'category-foods.php?category_id='.$id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                    if($image_name==""){
                                        echo "<div class='error'>Image not Available</div>";
                                    }else{
                                        ?>
                                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                            </a>
                        <?php
                    }
                }else{
                    //no category available
                    echo "<div class='error'>Category Not Available.</div>";
                }
            ?>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //getting food from database
                //sql query

                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                $res2 = mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($res2);
                if ($count2>0) {
                    while ($row2=mysqli_fetch_assoc($res2)) {
                        $id2 = $row2['id'];
                        $title2 = $row2['title'];
                        $price2 = $row2['price'];
                        $description2 = $row2['description'];
                        $image_name2 = $row2['image_name'];
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        if ($image_name=="") {
                                            echo "<div class='error'>Image Not Found.</div>";
                                        }else{
                                            ?>
                                                <img src="<?php echo SITEURL.'images/food/'.$image_name2;?>" alt="<?php echo $title2?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title2;?></h4>
                                    <p class="food-price"><?php echo '$'.$price2;?></p>
                                    <p class="food-detail">
                                    <?php echo $description2;?>
                                    </p>
                                    <br>

                                    <a href="order.php" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                    }
                }else{
                    echo "<div class='error'>Food Not Available.</div>";
                }
            ?>
            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>
