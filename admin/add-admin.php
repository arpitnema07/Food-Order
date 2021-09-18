<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);//Removing Session Message
            }
        ?>
        <br>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php')?>


<?php
    // Process the value from Form and save it in Database
    // check when the button is clicked
    if(isset($_POST['submit'])){
        //button clicked
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);// one way password encryption method

        //sql query to data in database
        $sql = "INSERT INTO tbl_admin SET 
        full_name='$full_name',
        username='$username',
        password='$password' ";
        // Execute Query and Save data in database
        $res = mysqli_query($conn,$sql) or die(mysqli_errno($conn));

        // Check Query Executed or not
        if($res==TRUE){
            //data inserted
            //create a session variable to display massage
            $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
            //redirect
            header("location:".SITEURL.'admin/manage-admin.php');
        }else{
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //redirect
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>