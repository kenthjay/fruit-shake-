<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Shop || Fruitshake Ordering System</title>
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
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="" width="18%"> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="shops.php">Shops <span class="sr-only"></span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="aboutus.html">About Us<span class="sr-only"></span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="profile.php">Profile<span class="sr-only"></span></a> </li>
                        <?php
						if(empty($_SESSION["user_id"]))
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
							}
						else
							{		
								echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
								echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
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

                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="#">Choose Shop</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Favorite Shake</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                </ul>
            </div>
        </div>
        <div class="inner-page-hero bg-image" data-image-src="images/FRUITS.jpg">
            <div class="container" style="display: flex; justify-content: center; align-items: center; "><h1>Choose a Shop of you prefer.</h1> </div>
            
        </div>
        
        <div class="result-show">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                        <div class="bg-gray restaurant-entry">
                            <div class="row">
                             <?php
$ress = mysqli_query($db, "SELECT * FROM restaurant");
while ($rows = mysqli_fetch_array($ress)) {
    // Set map image fallback
    $map_image = !empty($rows['map_image']) ? $rows['map_image'] : 'map_placeholder.jpg';

    echo '
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <!-- Shop Main Image -->
            <div style="height: 200px; overflow: hidden;">
                <img src="admin/Res_img/' . htmlspecialchars($rows['image']) . '" class="card-img-top w-100" alt="Shop Image" style="height: 100%; object-fit: cover;">
            </div>

            <div class="card-body">
                <h5 class="card-title text-success fw-bold">' . htmlspecialchars($rows['title']) . '</h5>

                <ul class="list-unstyled small mb-3">
                    <li><i class="fa fa-map-marker text-danger me-2"></i><strong>Address:</strong> ' . htmlspecialchars($rows['address']) . '</li>
                    <li><i class="fa fa-envelope text-primary me-2"></i><strong>Email:</strong> ' . htmlspecialchars($rows['email']) . '</li>
                    <li><i class="fa fa-phone text-success me-2"></i><strong>Phone:</strong> ' . htmlspecialchars($rows['phone']) . '</li>
                    <li><i class="fa fa-clock-o text-warning me-2"></i><strong>Hours:</strong> ' . htmlspecialchars($rows['o_hr']) . ' - ' . htmlspecialchars($rows['c_hr']) . '</li>
                    <li><i class="fa fa-calendar text-info me-2"></i><strong>Days Open:</strong> ' . htmlspecialchars($rows['o_days']) . '</li>
                </ul>

                <!-- 📍 Map Image -->
                <div class="border rounded">
                    <img src="admin/Res_img/' . htmlspecialchars($map_image) . '" alt="Map Location" class="img-fluid w-100" style="height: 180px; object-fit: cover;">
                </div>
            </div>

            <div class="card-footer bg-transparent border-0">
                <div class="d-grid">
                    <a href="shakes.php?res_id=' . $rows['rs_id'] . '" class="btn btn-outline-success btn-sm">View Menu</a>
                </div>
            </div>
        </div>
    </div>';
}
?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <?php include "include/footer.php" ?>

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