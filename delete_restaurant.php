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

mysqli_query($db,"DELETE FROM restaurant WHERE rs_id = '".$_GET['res_del']."'");
header("location:all_restaurant.php");  

?>
