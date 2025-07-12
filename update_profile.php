<?php
session_start();
include 'connection/profileconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $sql = "UPDATE users SET f_name = ?, l_name = ?, phone = ?, address = ? WHERE u_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $f_name, $l_name, $phone, $address, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>
