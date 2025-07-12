<!DOCTYPE html>
<html lang="en">
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




if(isset($_POST['submit'])) {     
    // Check if any required fields are empty
    if(empty($_POST['d_name']) || empty($_POST['about']) || $_POST['price_small'] == '' || $_POST['price_medium'] == '' || $_POST['price_large'] == '' || $_POST['res_name'] == '') {  
        $error =  '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>All fields must be filled!</strong>
                    </div>';
    } else {
        // Process the image upload
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.', $fname);
        $extension = strtolower(end($extension));  
        $fnew = uniqid() . '.' . $extension;
        $store = "Res_img/dishes/" . basename($fnew);                   

        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {        
            if ($fsize >= 1000000) { // Check if the image size exceeds 1MB
                $error =  '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max Image Size is 1024KB!</strong> Try a different image.
                          </div>';
            } else {
                // Insert the data into the database with price_small, price_medium, and price_large
                $sql = "INSERT INTO dishes(rs_id, title, slogan, price_small, price_medium, price_large, img) 
                        VALUES('".$_POST['res_name']."', '".$_POST['d_name']."', '".$_POST['about']."', '".$_POST['price_small']."', '".$_POST['price_medium']."', '".$_POST['price_large']."', '".$fnew."')";
                mysqli_query($db, $sql); 
                move_uploaded_file($temp, $store);
  
                // Success message
                $success =  '<div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                New dish added successfully.
                            </div>';
            }
        } elseif ($extension == '') {
            $error =  '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Select an image</strong>
                        </div>';
        } else {
            $error =  '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid extension!</strong> Only PNG, JPG, or GIF are accepted.
                        </div>';
        }
    }
}



	
	
	










?>

                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta name="description" content="">
                    <meta name="author" content="">
                    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
                    <title>Update Menu</title>
                    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
                    <link href="css/helper.css" rel="stylesheet">
                    <link href="css/style.css" rel="stylesheet">

                </head>

                <body class="fix-header">

                    <div class="preloader">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                        </svg>
                    </div>

                    <div id="main-wrapper">

                        <div class="header">
                            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="dashboard.php">

                                        <span><img src="images/logo.png" alt="homepage" class="dark-logo" /></span>
                                    </a>
                                </div>
                                <div class="navbar-collapse">

                                    <ul class="navbar-nav mr-auto mt-md-0">
                                    </ul>

                                    <ul class="navbar-nav my-lg-0">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/logo.png" alt="user" class="profile-pic" /></a>
                                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                                <ul class="dropdown-user">
                                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>

                        <div class="left-sidebar">

                            <div class="scroll-sidebar">

                                <nav class="sidebar-nav">
                                    <ul id="sidebarnav">
                                        <li class="nav-devider"></li>
                                        <li class="nav-label">Home</li>
                                        <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                                        <li class="nav-label">Log</li>
                                        <li> <a href="all_users.php"> <span><i class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Restaurant</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="all_restaurant.php">All Restaurants</a></li>
                                                <li><a href="add_category.php">Add Category</a></li>
                                                <li><a href="add_restaurant.php">Add Restaurant</a></li>

                                            </ul>
                                        </li>
                                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery" aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="all_menu.php">All Menues</a></li>
                                                <li><a href="add_menu.php">Add Menu</a></li>


                                            </ul>
                                        </li>
                                        <li> <a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>

                                    </ul>
                                </nav>

                            </div>

                        </div>

                        <div class="page-wrapper">


                            <div class="container-fluid">



                                <?php  echo $error;
									        echo $success; ?>




                                <div class="col-lg-12">
                                    <div class="card card-outline-primary">
                                        <div class="card-header">
                                            <h4 class="m-b-0 text-white">EDIT SHAKE</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action='' method='post' enctype="multipart/form-data">
                                                <div class="form-body">
                                                    <?php $qml ="select * from dishes where d_id='$_GET[menu_upd]'";
													$rest=mysqli_query($db, $qml); 
													$roww=mysqli_fetch_array($rest);
														?>
                                                    <hr>
                                                    <div class="row p-t-20">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Dish Name</label>
                                                                <input type="text" name="d_name" value="<?php echo $roww['title'];?>" class="form-control" placeholder="Morzirella">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group has-danger">
                                                                <label class="control-label">About</label>
                                                                <input type="text" name="about" value="<?php echo $roww['slogan'];?>" class="form-control form-control-danger" placeholder="slogan">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row p-t-20">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Small Price </label>
                                                                <input type="text" name="price_small" value="<?php echo $roww['price'];?>" class="form-control" placeholder="₱">
                                                            </div>
                                                        </div>

                                                        <div class="row p-t-20">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Medium Price </label>
                                                                <input type="text" name="price_medium" value="<?php echo $roww['price'];?>" class="form-control" placeholder="₱">
                                                            </div>
                                                        

                                                        </div>
                                                        <div class="row p-t-20">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Large Price </label>
                                                                <input type="text" name="price_large" value="<?php echo $roww['price'];?>" class="form-control" placeholder="₱">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group has-danger">
                                                                <label class="control-label">Image</label>
                                                                <input type="file" name="file" id="lastName" class="form-control form-control-danger" placeholder="12n">
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Select Category</label>
                                                                <select name="res_name" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                                                    <option>--Select Restaurant--</option>
                                                                    <?php $ssql ="select * from restaurant";
													$res=mysqli_query($db, $ssql); 
													while($row=mysqli_fetch_array($res))  
													{
                                                       echo' <option value="'.$row['rs_id'].'">'.$row['title'].'</option>';;
													}  
                                                 
													?>
                                                                </select>
                                                            </div>
                                                        </div>



                                                    </div>

                                                </div>
                                        </div>
                                        <div class="form-actions">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Save">
                                            <a href="all_menu.php" class="btn btn-inverse">Cancel</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php include "include/footer.php" ?>

                        </div>

                    </div>

                    </div>

                    </div>

                    <script src="js/lib/jquery/jquery.min.js"></script>
                    <script src="js/lib/bootstrap/js/popper.min.js"></script>
                    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
                    <script src="js/jquery.slimscroll.js"></script>
                    <script src="js/sidebarmenu.js"></script>
                    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
                    <script src="js/custom.min.js"></script>

                </body>

                </html>