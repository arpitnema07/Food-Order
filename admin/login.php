<?php include('../config/constants.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <hr>
        <br>
        <?php
            if (isset($_SESSION['login'])) {
                    echo $_SESSION['login']?> <br/><br/><?php ;
                    unset($_SESSION['login']);//Removing Session Message
                }
            if (isset($_SESSION['not-log-in'])) {
                echo $_SESSION['not-log-in']?> <br/><?php ;
                unset($_SESSION['not-log-in']);//Removing Session Message
            }
        ?>
        <form action="" method="post" class="text-center">
            Username: 
            <input class="input-field" type="text" name="username" placeholder="Enter Username">
            <br> <br>
            Password: 
            <input class="input-field" type="password" name="password" placeholder="Enter Password">
            
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary login-btn">
        </form>
        <br>
        <p class="text-center">Created By <a href="www.instagram.com/arpit__nema">Arpit Nema</a></p>
    </div>
</body>
</html>

<?php
    //check when submit button is clicked
    if (isset($_POST['submit'])) {
        //get data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        //sql to check username and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        //execute query
        $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if ($res==TRUE) {
            echo $count = mysqli_num_rows($res);
            if ($count==1) {
                    //user found
                    $_SESSION['login'] = "<div class='success'>Login Successfully</div>";
                    $_SESSION['user'] = $username;//to check whether the user is logged in or not
                    header('location:'.SITEURL.'admin');
            }else {
                //user not found
                $_SESSION['login'] = "<div class='error text-center'>Username and Password Doesn't match</div>";
                header('location:'.SITEURL.'admin/login.php');
            }
        }   
    }
?>
