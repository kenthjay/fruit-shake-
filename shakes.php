<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0);
session_start();

include_once 'product-action.php'; 



?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Shakes || Fruitshake Ordering System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.jpg" alt="" width="18%"> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="shops.php">Shops</a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="aboutus.html">About Us</a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="profile.php">Profile<span class="sr-only"></span></a> </li>
                        <?php
                        if(empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
                            <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
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
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="shakes.php?res_id=<?php echo $_GET['res_id']; ?>">Pick Your Favorite Shake</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                </ul>
            </div>
        </div>

        <div class="container m-t-30">
            <div class="row">
                <div class="col-md-8">
                    <div class="menu-widget" id="2">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">MENU</h3>
                        </div>
                        <?php  
$stmt = $db->prepare("SELECT * FROM dishes WHERE rs_id = ?");
$stmt->bind_param("i", $_GET['res_id']);
$stmt->execute();
$products = $stmt->get_result();

if ($products->num_rows > 0) {
    foreach($products as $product) {
?>
<div class="food-item">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-8">
            <form method="post" action="shakes.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>">
                <div class="rest-logo pull-left">
                    <a class="restaurant-logo pull-left" href="#">
                        <img src="admin/Res_img/dishes/<?php echo $product['img']; ?>" alt="Food logo">
                    </a>
                </div>
                <div class="rest-descr">
                    <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                    <p><?php echo $product['slogan']; ?></p>
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info">
            <span class="price pull-left">₱<span id="price-<?php echo $product['d_id']; ?>"><?php echo $product['price_small']; ?></span></span>
            <input class="b-r-0" type="text" name="quantity" style="margin-left:30px;" value="1" size="2" />
            
            <!-- Dropdown for Size Selection -->
            <select class="form-control b-r-0 size-select" data-dish-id="<?php echo $product['d_id']; ?>" name="size" id="size-<?php echo $product['d_id']; ?>">
                <option value="small" data-price="<?php echo $product['price_small']; ?>">Small - ₱<?php echo $product['price_small']; ?></option>
                <option value="medium" data-price="<?php echo $product['price_medium']; ?>">Medium - ₱<?php echo $product['price_medium']; ?></option>
                <option value="large" data-price="<?php echo $product['price_large']; ?>">Large - ₱<?php echo $product['price_large']; ?></option>
            </select>
            <input type="hidden" name="price" value="<?php echo $product['price_small']; ?>" class="selected-price" />
            <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add To Cart" />
        </div>
            </form>
    </div>
</div>
<?php
    }
}
?>

                    </div>
                </div>
                
                <!-- Cart Section -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <div class="widget widget-cart">
    <div class="widget-heading">
        <h3 class="widget-title text-dark">Your Cart</h3>
    </div>
    <div class="order-row bg-white">
        <div class="widget-body">
            <?php
            $item_total = 0;
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $item) {
                    $size = ucfirst($item["size"]);  // Capitalize size
                    $price = $item["price"];
                    $quantity = $item["quantity"];
                    $subtotal = $price * $quantity;
            ?>
            <div class="title-row">
                <?php echo $item["title"]; ?> (Size: <?php echo $size; ?>)
                <a href="shakes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>&size=<?php echo $item["size"]; ?>">
                    <i class="fa fa-trash pull-right"></i>
                </a>
            </div>
            <div class="form-group row no-gutter">
                <div class="col-xs-8">
                    <input type="text" class="form-control b-r-0" value="₱<?php echo number_format($subtotal, ); ?>" readonly>
                </div>
                <div class="col-xs-4">
                    <input class="form-control" type="text" readonly value="<?php echo $quantity; ?>">
                </div>
            </div>
            <?php
                    $item_total += $subtotal;
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>
    </div>
    <div class="widget-body">
        <div class="price-wrap text-xs-center">
            <p>TOTAL</p>
            <h3 class="value"><strong>₱<?php echo number_format($item_total, ); ?></strong></h3>
            <p>Free Delivery!</p>
            <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check" class="btn btn-success btn-lg active">Checkout</a>
        </div>
    </div>
</div>


                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Dynamic Size Selection and Price Update -->
        <script>
    document.querySelectorAll('.size-select').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            var dishId = this.getAttribute('data-dish-id');
            var selectedOption = this.options[this.selectedIndex];
            var selectedPrice = selectedOption.getAttribute('data-price');
            
            // Update displayed price for the selected size
            document.getElementById('price-' + dishId).innerText = selectedPrice;
            
            // Update hidden price input to capture the updated price on form submission
            this.closest('form').querySelector('.selected-price').value = selectedPrice;
        });
    });
</script>


<?php include "include/footer.php" ?>
</body>
</html>
