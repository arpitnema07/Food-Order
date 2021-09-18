<?php
    include('../config/constants.php');
    //destroy session
    session_destroy();// Unsets $_SESSION['user'] 
    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>