<?php
session_start();
include 'connection/profileconnect.php'; // ✅ Correct path to connect.php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT f_name, l_name, phone, address FROM users WHERE u_id = ?";
$stmt = $conn->prepare($sql); // ✅ Should now work
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($f_name, $l_name, $phone, $address);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Home || Fruitshake Ordering System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   

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
						if(empty($_SESSION["user_id"])) // if user is not login
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
</head>
<body>
   <div class="page-wrapper">

            <div class="container">
                <ul>


                </ul>
            </div>
            
            <section class="contact-page inner-page">
                <div class="container ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-body">
                                    

                                    <h2>Profile</h2>
    <form action="update_profile.php" method="POST">
        <label for="f_name">First Name:</label><br>
        <input type="text" name="f_name" value="<?= htmlspecialchars($f_name) ?>" required><br><br>

        <label for="l_name">Last Name:</label><br>
        <input type="text" name="l_name" value="<?= htmlspecialchars($l_name) ?>" required><br><br>

        <label for="phone">Mobile Number:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" required><br><br>

        <label for="address">Delivery Address:</label><br>
        <textarea name="address" rows="4" required><?= htmlspecialchars($address) ?></textarea><br><br>

        <input type="submit" value="Update Profile">
    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </section>
            



        </div>
</body>
</html>
