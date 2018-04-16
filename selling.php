<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $welcome =  "My Account";
	$pleaseLogin = "Item information";
}else{
	$welcome = "Login";
	$pleaseLogin = "<span style=\"font-size:48px\">You must log in first to start selling!</span>";
}
?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Oulu Market</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Oulu Market" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<!--fonts-->
<link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!--//fonts-->
<!-- js -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!-- js -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>
<script>
  $(document).ready(function () {
    var mySelect = $('#first-disabled2');

    $('#special').on('click', function () {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function () {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });
  });
</script>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<link href="css/jquery.uls.css" rel="stylesheet"/>
<link href="css/jquery.uls.grid.css" rel="stylesheet"/>
<link href="css/jquery.uls.lcd.css" rel="stylesheet"/>
<!-- Source -->
<script src="js/jquery.uls.data.js"></script>
<script src="js/jquery.uls.data.utils.js"></script>
<script src="js/jquery.uls.lcd.js"></script>
<script src="js/jquery.uls.languagefilter.js"></script>
<script src="js/jquery.uls.regionfilter.js"></script>
<script src="js/jquery.uls.core.js"></script>
<link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css " />
<script src="js/easyResponsiveTabs.js"></script>
</head>
<?php
// Include config file
require_once 'database/connection.php';

// Define variables and initialize with empty values
$name = $description = $price = $category = "";
$name_err = $description_err = $price_err = $category_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Validate email
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name for your product.";
    }else{
		$name = trim($_POST["name"]);
	}
	if(empty(trim($_POST["description"]))){
        $description_err = "Please enter a short description for your product.";
    }else{
		$description = trim($_POST["description"]);
	}
	if(empty(trim($_POST["price"]))){
        $price_err = "Please enter a price for your product.";
    }else {
		$price = trim($_POST["price"]);
	}
	$category = $_POST['category'];
	if ($category == "Select Category")
	{
		$category_err = "Please select category.";
	}
	if (empty($_FILES))
	{
		$image_err = "Please upload image for your item.";
	}
	
	

    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err) && empty($category_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO items (item_name, description, category, price, verified, available, added_by, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssdiiib", $param_name, $param_description, $param_category, $param_price, $param_verified, $param_available, $param_added, $param_image);

            // Set parameters
            $param_name = $name;
			$param_description = $description;
			$param_category = $category;
			$param_price = $price;
			$param_verified = 0;
			$param_available = 1;
			$param_added = $_SESSION['id'];
			$param_image = "blob";

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //Succesfuly added
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
<body>
	<div class="header">
		<div class="container">
			<div class="logo">
				<a href="index.php">
					<img src="images/logo.png" alt="Logo" style="width:150px;height:150px;" />
					<span>Oulu</span>Market
				</a>
			</div>
			<div class="header-right">
				<a class="account" href="login.php">
					<?php echo $welcome; ?>
				</a>
				<a class="account" href="contact.php">Contact</a>
				<script>
				$('#myModal').modal('');
				</script>
			</div>
		</div>
	</div>
	<div class="main-banner banner text-center">
		<div class="container">
			<h1>
				The first bazaar
				<span class="segment-heading"> in Oulu</span> with delivery
			</h1>
			<p>Software development project 2</p>
		</div>
	</div>
	<!-- // Submit Ad -->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-up">
						<h1><?php echo $pleaseLogin; ?></h1>
						<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Item name* :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
									<input type="text" name="name" placeholder="Enter item name" class="form-control" value="<?php echo $name; ?>" />
									<span class="help-block">
										<?php echo $name_err; ?>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Description* :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
									<input type="text" name="description" placeholder="Enter short description" class="form-control" value="<?php echo $description; ?>" />
									<span class="help-block">
										<?php echo $description_err; ?>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Price* :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
									<input type="number" step="0.01" max="9999999999" name="price" placeholder="Enter price" 
										   class="form-control" value="<?php echo $price; ?>"
										   oninvalid="setCustomValidity('Price must be less then 10 numbers and have only 2 decimals')"
										   onchange="try{setCustomValidity('')}catch(e){}"/>
									<span class="help-block"><?php echo $price_err; ?>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Select Category* :</h4>
								</div>
								<div class="sign-up2">
									<select name="category" class="selectpicker show-tick custom">
										<option>Select Category</option>
										<option>Mobiles</option>
										<option>Electronics and Appliances</option>
										<option>Furniture</option>
										<option>Books, Sports and hobbies</option>
										<option>Fashion</option>
										<option>Kids</option>
									</select>
									<span class="help-block" style="color:RGB(169, 68, 68)">
										<?php echo $category_err; ?>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Image* :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
									<input type="file" id="fileselect" name="fileselect[]" style="margin-top:30px"/>
									<span class="help-block">
										<?php echo $image_err; ?>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub_home">
								<div class="sub_home_left">
									<input type="submit" value="Add item" />
								</div>
								<div class="clearfix"></div>
							</div>
						<?php } if(!isset($_SESSION['loggedin'])){ ?>
						<div style="text-align: center; margin-top: 100px">
							<div style="display: inline-block;">
								<a class="account" style="float: none" href="login.php">Login</a>
								<span>OR</span>
								<a class="account" style="float: none" href="register.php">Register</a>
							</div>
						</div>
						<?php } ?>
				</div>
			</div>
			<form>
			<!-- // Submit Ad -->
			<!--footer section start-->
			<footer>
				<div class="footer-bottom text-center">
					<div class="container">
						<div class="footer-logo">
							<a href="index.php">
								<span>Oulu</span>Market
							</a>
						</div>
						<div class="copyrights">
							<p>
								© 2018 OuluMarket. All Rights Reserved | Design by
								<a href="http://w3layouts.com/"> W3layouts</a>
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</footer>
			<!--footer section end-->
</body>
</html>
