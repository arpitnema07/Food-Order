<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php 
                //create sql to fetch data from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
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
                            <a href="<?php echo SITEURL.'category-foods.php?category_id='.$id?>">
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

<?php include('partials-front/footer.php'); ?>
