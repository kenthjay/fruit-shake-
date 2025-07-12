<?php
session_start();
include("connection/connect.php");
date_default_timezone_set("Asia/Manila");

if (empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Generate receipt number
$receipt_number = strtoupper(uniqid('FS-'));

// Fetch user info
$user_id = $_SESSION["user_id"];
$user_query = mysqli_query($db, "SELECT f_name, l_name, address, phone FROM users WHERE u_id = '$user_id'");
$user = mysqli_fetch_assoc($user_query);

// Get restaurant/shop name using saved res_id
$store_name = "adwd";
if (!empty($_SESSION["last_res_id"])) {
    $res_id = $_SESSION["last_res_id"];
    $res_query = mysqli_query($db, "SELECT title FROM restaurant WHERE rs_id = '$res_id'");
    if ($res = mysqli_fetch_assoc($res_query)) {
        $store_name = $res["title"];
    }
}

// Get payment method from session
$payment_method = $_SESSION["payment_method"] ?? 'Not specified';

$payment_label = ($payment_method === 'COD') ? 'Cash on Delivery' : (($payment_method === 'pickup') ? 'Pick Up' : $payment_method);


// Order timestamp
$order_time = date("F d, Y h:i A");

// Get order items
$items = $_SESSION["last_order_items"] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt || Fruitshake Ordering System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .receipt-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 25px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
        }
        .receipt-title {
            text-align: center;
            margin-bottom: 25px;
        }
        .receipt-table th, .receipt-table td {
            text-align: center;
        }
        .thank-you {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
<div class="receipt-container">
    <h2 class="receipt-title"><?= htmlspecialchars($store_name) ?></h2>
    <p><strong>Receipt No:</strong> <?= $receipt_number ?></p>
    <p><strong>Date:</strong> <?= $order_time ?></p>
<p><strong>Payment Method:</strong> <?= htmlspecialchars($payment_label) ?></p>


    <hr>

    <h5>Customer Information</h5>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['f_name'] . " " . $user['l_name']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>

    <hr>

    <h5>Order Details</h5>
    <table class="table table-bordered receipt-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): 
            $subtotal = $item["price"] * $item["quantity"];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item["title"]) ?></td>
                <td><?= ucfirst($item["size"]) ?></td>
                <td><?= $item["quantity"] ?></td>
                <td>₱<?= number_format($item["price"], 2) ?></td>
                <td>₱<?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>₱<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="thank-you">
        <P>Please present this receipt when claiming your order</p>
        <p>Thank you for ordering with <?= htmlspecialchars($store_name) ?>!</p>
        <p>We hope to serve you again soon 💖</p>
    </div>
    <div class="mt-4" style="text-align: right;">
    <a href="your_orders.php" class="btn btn-primary">Proceed</a>
</div>
</div>
</body>
</html>
