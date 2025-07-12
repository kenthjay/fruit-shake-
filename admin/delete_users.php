<?php
session_start();
include("../connection/connect.php"); // your DB connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // redirect to admin login
    exit();



error_reporting(0);
session_start();
}

mysqli_query($db,"DELETE FROM users WHERE u_id = '".$_GET['user_del']."'");
header("location:all_users.php");  

?>
