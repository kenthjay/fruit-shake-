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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the order status
    $query = "UPDATE users_orders SET status='$status' WHERE o_id='$order_id'";
    mysqli_query($db, $query);

    // Redirect back to the orders page
    header("Location: all_orders.php");
    exit;
}
?>
