<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

if (empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit();
}

$item_total = 0;

if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += $item["price"] * $item["quantity"];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!empty($_POST['mod'])) {
        $_SESSION["payment_method"] = $_POST['mod'];
    }

    foreach ($_SESSION["cart_item"] as $item) {
       $SQL = "INSERT INTO users_orders(u_id, title, quantity, price, size, payment_method, status) 
        VALUES (
            '" . $_SESSION["user_id"] . "',
            '" . $item["title"] . "',
            '" . $item["quantity"] . "',
            '" . $item["price"] . "',
            '" . $item["size"] . "',
            '" . mysqli_real_escape_string($db, $_SESSION["payment_method"]) . "',
            'Order is being prepared'
        )";

        mysqli_query($db, $SQL);
    }

    $_SESSION["last_order_items"] = $_SESSION["cart_item"];
    $_SESSION["order_time"] = date("F d, Y h:i A");

    if (!empty($_SESSION["cart_item"])) {
        $first_item = reset($_SESSION["cart_item"]);
        if (!empty($first_item["res_id"])) {
            $_SESSION["last_res_id"] = $first_item["res_id"];
        }
    }

    unset($_SESSION["cart_item"]);
    header("Location: receipt.php");
    exit();
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout || Fruitshake Ordering System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div class="site-wrapper">
<header id="header" class="header-scroll top-header headrom">
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="" width="18%"> </a>
            <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                    <li class="nav-item"> <a class="nav-link active" href="shops.php">Shops</a> </li>
                    <li class="nav-item"> <a class="nav-link active" href="aboutus.html">About Us</a> </li>
                    <?php
                    if (empty($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
                              <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a></li>';
                    } else {
                        echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a></li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="page-wrapper">
    <div class="top-links">
        <div class="container">
            <ul class="row links">
                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="shops.php">Choose Shop</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Favorite Shake</a></li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and Pay</a></li>
            </ul>
        </div>
    </div>
    <div class="container m-t-30">
        <form action="" method="post">
            <div class="widget clearfix">
                <div class="widget-body">
                    <div class="cart-totals margin-b-20">
                        <h4>Cart Summary</h4>
                        <table class="table">
                            <tbody>
                                <tr><td>Cart Subtotal</td><td>₱<?= number_format($item_total, 2); ?></td></tr>
                                <tr><td>Delivery Charges</td><td>Free</td></tr>
                                <tr><td><strong>Total</strong></td><td><strong>₱<?= number_format($item_total, 2); ?></strong></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="payment-option">
                    <h5><strong>Payment Options</strong></h5>
<ul class="list-unstyled">
    <li>
        <label class="custom-control custom-radio m-b-20">
            <input name="mod" id="radioCod" checked value="COD" type="radio" class="custom-control-input" onclick="toggleOrderSummary()"> 
            <span class="custom-control-indicator"></span> 
            <span class="custom-control-description">Cash on Delivery</span>
        </label>
    </li>
    <li>
        <label class="custom-control custom-radio m-b-10">
            <input name="mod" id="radioPickup" type="radio" value="pickup" class="custom-control-input" onclick="toggleOrderSummary()"> 
            <span class="custom-control-indicator"></span> 
            <span class="custom-control-description">Pick Up</span>
        </label>
    </li>
</ul>

<!-- Order Summary (Only for COD) -->
<div id="orderSummary" style="display: block; background: #f9f9f9; padding: 15px; border-radius: 8px; margin-top: 10px;">
    <h5><strong>Delivery Details</strong></h5>
    <?php
    $user_id = $_SESSION['user_id'];
    $stmt = mysqli_prepare($db, "SELECT f_name, l_name, address, phone FROM users WHERE u_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $f_name, $l_name, $address, $phone);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    ?>

    <p><strong>Name:</strong> <?= htmlspecialchars($f_name . ' ' . $l_name) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
    <p><strong>Delivery Address:</strong> <?= htmlspecialchars($address) ?></p>

    <h5 class="mt-3"><strong>Items Ordered:</strong></h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION["cart_item"] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item["title"]) ?></td>
                    <td><?= ucfirst(htmlspecialchars($item["size"])) ?></td>
                    <td><?= $item["quantity"] ?></td>
                    <td>₱<?= number_format($item["price"] * $item["quantity"], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>₱<?= number_format($item_total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Place Order Button -->
<p class="text-xs-center">
    <input type="submit" onclick="return confirm('Do you want to confirm the order?');" name="submit" class="btn btn-success btn-block" value="Order Now">
</p>

<!-- JavaScript to toggle order summary -->
<script>
function toggleOrderSummary() {
    const isCod = document.getElementById("radioCod").checked;
    document.getElementById("orderSummary").style.display = isCod ? "block" : "none";
}
</script>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include "include/footer.php" ?>
</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/headroom.js"></script>
<script src="js/foodpicky.min.js"></script>
</body>
</html>
