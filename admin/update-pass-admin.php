<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if (isset($_POST['submit'])) {
        //get data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);
        // //check whether user with id and current password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        // //execute query
        $res = mysqli_query($conn,$sql);

        if($res == TRUE){
            $count = mysqli_num_rows($res);
            if ($count==1) {
                //User exist password can be changed
                //check weather new pass and confirm match
                if($new_password==$confirm_password){
                //    echo "Password Match";
                    $sql2 = "UPDATE tbl_admin SET 
                            password='$new_password' WHERE id=$id";
                    $res2 = mysqli_query($conn,$sql2);
                    if ($res2==TRUE) {
                        $_SESSION['update-pass-result'] = "Password changed Successfully";
                        header('location:'.SITEURL.'admin/manage-admin.php');                        
                    }else{
                        $_SESSION['update-pass-result'] = "Couldn't change Password Error Occurred";
                        header('location:'.SITEURL.'admin/manage-admin.php'); 
                    }
                }else{
                    $_SESSION['update-pass-result'] = "Password doesn't match";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }else{
                $_SESSION['update-pass-result'] = "User not found";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
    }
?>


<?php include('partials/footer.php')?>
