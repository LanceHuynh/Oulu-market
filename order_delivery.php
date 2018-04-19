<?php
session_start();
$_SESSION['start'] = time();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$welcome =  "My Account";
	$pleaseLogin = "You are about to order item below";
	if(time()>$_SESSION['start']+900){
		session_unset();
		session_destroy();
		$welcome = "Login";
	}
}else{
	$welcome = "Login";
	$pleaseLogin = "<span style=\"font-size:48px\">You must log in first to order an item!</span>";
}

	
// Include config file
require_once 'database/connection.php';
if (isset($_POST["id"])) {
	$query = "select * from items where id ='".$_POST["id"]."';";
	$result= $link->query($query);
	$set = $result->fetch_assoc();
}

//Declare variables
$name = $address = $number = "";
$name_err = $address_err = $number_err = "";
$item_id = $user_id = $order_delivery_message = "";

if(isset($_POST['order'])){
	//Validate contact information
	if(empty(trim($_POST["name"]))){
		$name_err = "Please enter your name";
	}else{
		$name = trim($_POST["name"]);
	}
	if(empty(trim($_POST["address"]))){
		$address_err = "Please enter your address";
	}else{
		$address = trim($_POST["address"]);
	}
	if(empty(trim($_POST["number"]))){
		$number_err = "Please enter your phone number";
	}else{
		$number = trim($_POST["number"]);
	}

	if (empty($name_err) && empty($address_err) && empty($number_err))
	{
		$sql = "INSERT INTO delivery (item_id, bought_by, name, address, contact_num, status) VALUES (?, ?, ?, ?, ?, ?)";

		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "iissii", $param_itemID, $param_boughtBy, $param_name, $param_address, $param_contactNum, $param_status);

			$param_itemID = 1;
			$param_boughtBy = $_SESSION['id'];
			$param_name = $name;
			$param_address = $address;
			$param_contactNum = $number;
			$param_status = 0;

			if(mysqli_stmt_execute($stmt)){
				header("location: welcome.php");
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
	<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/bootstrap-select.css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- for-mobile-apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Oulu Market" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //for-mobile-apps -->
	<!--fonts-->
	<link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css' />
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
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
	<link href="css/jquery.uls.css" rel="stylesheet" />
	<link href="css/jquery.uls.grid.css" rel="stylesheet" />
	<link href="css/jquery.uls.lcd.css" rel="stylesheet" />
	<!-- Source -->
	<script src="js/jquery.uls.data.js"></script>
	<script src="js/jquery.uls.data.utils.js"></script>
	<script src="js/jquery.uls.lcd.js"></script>
	<script src="js/jquery.uls.languagefilter.js"></script>
	<script src="js/jquery.uls.regionfilter.js"></script>
	<script src="js/jquery.uls.core.js"></script>
	<link rel="stylesheet" href="css/flexslider.css" media="screen" />
</head>
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
			</div>
		</div>
	</div>
	<section>
		<form action="welcome.php" method="post">
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-up">
						<h1>
							<?php echo $pleaseLogin; ?>
						</h1>
						<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
						<div class="item-price" width="80%">
							<div class="product-name">
								<p class="p-price">Name</p>
								<h3 class="rate">
									<?php echo $set['item_name']?>
								</h3>
								<div class="clearfix"></div>
							</div>
							<div class="product-price">
								<p class="p-price">Price</p>
								<h3 class="rate">
									<?php echo $set['price']?>
								</h3>
								<div class="clearfix"></div>
							</div>
							
							<img src="<?php echo $set['image_path']?>" style="width:100%; height:40%; margin-bottom:3%;">
							
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Your name* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
								<input type="text" name="name" placeholder="Your name" class="form-control" value="<?php echo $name; ?>" />
								<span class="help-block">
									<?php echo $name_err; ?>
								</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Your address* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
								<input type="text" name="address" placeholder="Your username" class="form-control" value="<?php echo $address; ?>" />
								<span class="help-block">
									<?php echo $address_err; ?>
								</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Your phone* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($number_err)) ? 'has-error' : ''; ?>">
								<input type="number" name="number" placeholder="Your number" class="form-control" value="<?php echo $number; ?>" />
								<span class="help-block">
									<?php echo $number_err; ?>
								</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="sub_home">
							<div class="sub_home_left">
								<input type="hidden" name="id" value="<?php echo $_POST['id']?>">
								<input id="order" type="submit" name="delivery"  value="Confirm Delivery" />
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
			</div>
		</form>
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
							� 2018 OuluMarket. All Rights Reserved | Design by
							<a href="http://w3layouts.com/"> W3layouts</a>
						</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</footer>
		<!--footer section end-->
	</section>
</body>
</html>