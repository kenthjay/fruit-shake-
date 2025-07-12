<?php
session_start();
include("connection/connect.php");

if (!empty($_GET["action"])) {
    $productId = isset($_POST['dish_id']) ? (int) htmlspecialchars($_POST['dish_id']) : (isset($_GET['id']) ? (int) htmlspecialchars($_GET['id']) : '');

    $quantity = isset($_POST['quantity']) ? (int) htmlspecialchars($_POST['quantity']) : 0;
    $size = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : (isset($_GET['size']) ? htmlspecialchars($_GET['size']) : 'small');

    // Unique item key = product ID + size
    $item_key = $productId . '_' . $size;

    switch ($_GET["action"]) {
        case "add":
    // Only proceed if quantity and product ID are valid
    if ($quantity > 0 && !empty($productId)) {
        $stmt = $db->prepare("SELECT * FROM dishes WHERE d_id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $productDetails = $stmt->get_result()->fetch_object();

        // Get price based on size
        if ($size === 'small') {
            $price = $productDetails->price_small;
        } elseif ($size === 'medium') {
            $price = $productDetails->price_medium;
        } else {
            $price = $productDetails->price_large;
        }

        // ✅ Get restaurant/shop ID from dishes table
        $res_id = $productDetails->rs_id;

        // ✅ Include res_id in cart item
        $item_key = $productId . '_' . $size;
        $itemArray = [
            $item_key => [
                'title' => $productDetails->title,
                'd_id' => $productDetails->d_id,
                'quantity' => $quantity,
                'price' => $price,
                'size' => $size,
                'res_id' => $res_id
            ]
        ];

        // Merge or add to cart
        if (!empty($_SESSION["cart_item"])) {
            if (array_key_exists($item_key, $_SESSION["cart_item"])) {
                $_SESSION["cart_item"][$item_key]["quantity"] += $quantity;
            } else {
                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
            }
        } else {
            $_SESSION["cart_item"] = $itemArray;
        }

        // ✅ Redirect to shakes.php with restaurant ID after adding to cart
        header("location: shakes.php?res_id=" . $res_id);
        exit();
    }
    break;



        case "remove":
            // Remove single item using ID + size
            if (!empty($_SESSION["cart_item"]) && array_key_exists($item_key, $_SESSION["cart_item"])) {
                unset($_SESSION["cart_item"][$item_key]);

                if (empty($_SESSION["cart_item"])) {
                    unset($_SESSION["cart_item"]);
                }
            }

            // Redirect back to shakes with res_id to prevent reloading issues
            if (isset($_GET['res_id'])) {
                header("location:shakes.php?res_id=" . $_GET['res_id']);
                exit();
            }
            break;

        case "empty":
            unset($_SESSION["cart_item"]);
            break;

        case "check":
            header("location:checkout.php");
            exit();
            break;
    }
}
?>
