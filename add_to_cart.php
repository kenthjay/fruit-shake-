<?php
session_start();
$dish_id = $_POST['dish_id'];
$size_price = explode(" - ", $_POST['size']); // [size, price]

$item = array(
    'd_id' => $dish_id,
    'size' => $size_price[0],
    'price' => $size_price[1],
    'quantity' => 1
);

// Initialize cart
if (!isset($_SESSION["cart_item"])) {
    $_SESSION["cart_item"] = array();
}

// Add to cart
$_SESSION["cart_item"][] = $item;

echo "success";
?>
