<?php include('partials/menu.php')?>
<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <!-- Button to add admin -->
        <br> <br>

        <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add']?> <br/><br/><br/><?php ;
                unset($_SESSION['add']);//Removing Session Message
            }
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete']?> <br/><br/><br/><?php ;
                unset($_SESSION['delete']);//Removing Session Message
            }
            if (isset($_SESSION['update-pass-result'])) {
                echo $_SESSION['update-pass-result']?> <br/><br/><br/><?php ;
                unset($_SESSION['update-pass-result']);//Removing Session Message
            }
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update']?> <br/><br/><br/><?php ;
                unset($_SESSION['update']);//Removing Session Message
            }
        ?>
        
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br> <br> 
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php 
                //Query to get all admin
                $sql = "SELECT * FROM tbl_admin";
                //Execute the query
                $res = mysqli_query($conn,$sql);
                //check whether the query is execute or not
                if($res==TRUE){
                    //Count number of rows present
                    $count = mysqli_num_rows($res);
                    //check number of rows
                    $num = 1;
                    if($count>0){
                        while ($row=mysqli_fetch_assoc($res)) {
                           //using while loop to get all the data from database
                           //while loop will run as long as we have data in database
                           
                           //get individual data
                           $id = $row['id'];
                           $full_name = $row['full_name'];
                           $username = $row['username'];
                           //Display the value in our table

                           ?>
                                <tr>
                                    <td><?php echo $num++?></td>
                                    <td><?php echo $full_name?></td>
                                    <td><?php echo $username?></td>
                                    <td> 
                                        <a href="<?php echo SITEURL;?>admin/update-pass-admin.php?id=<?php echo $id?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>

                            <?php
                        }
                    }
                } 
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php')?>
