<?php
    //Authorization - Access Control
    //check whether the user is logged in or not
    if (!isset($_SESSION['user'])) {
        //user is not set

        $_SESSION['not-log-in'] = "<div class='error text-center'>Please Login to Access Admin Panel.</div>";
        // redirect to login page
        header('location:'.SITEURL.'admin/login.php');
    }
?>