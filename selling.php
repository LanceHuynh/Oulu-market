<?php
	session_start();
	$_SESSION['start'] = time();

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$welcome =  "My Account";
	$pleaseLogin = "Item information";
		
	if(time()>$_SESSION['start']+900){
		session_unset();
		session_destroy();
		$welcome = "Login";
		}
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
/* Upload an image to mysql database.*/

// Check for post data.
require_once 'database/connection.php';

$name = $description = $price = $category = $image = "";
$name_err = $description_err = $price_err = $category_err = $image_err = "";

if ($_POST && !empty($_FILES)) {
	$formOk = true;

	if(empty(trim($_POST["name"]))){
		$name_err = "Please enter a name for your product.";
		$formOk = false;
	}else{
		$name = trim($_POST["name"]);
	}
	if(empty(trim($_POST["description"]))){
		$description_err = "Please enter a short description for your product.";
		$formOk = false;
	}else{
		$description = trim($_POST["description"]);
	}
	if(empty(trim($_POST["price"]))){
		$price_err = "Please enter a price for your product.";
		$formOk = false;
	}else {
		$price = trim($_POST["price"]);
	}
	$category = $_POST['category'];
	if ($category == "Select Category"){
		$category_err = "Please select category.";
		$formOk = false;
	}

	//Assign Variables
	$path = $_FILES['image']['tmp_name'];
	$ImgName = $_FILES['image']['name'];
	$size = $_FILES['image']['size'];
	$type = $_FILES['image']['type'];

	if ($_FILES['image']['error'] || !is_uploaded_file($path)) {
		$image_err = "Error in uploading file. Please try again.";
	}

	//check file extension
	if ($formOk && !in_array($type, array('image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif'))) {
		$image_err = "Unsupported file extension. Supported extensions are JPG / PNG.";
	}
	// check for file size.
	if ($formOk && filesize($path) > 500000) {
		$image_err = "File size must be less than 500 KB.";
	}
	if (file_exists($target_file))
	{
		$image_err = "File with same name already exists.";
	}
	

	if ($formOk) {
		// read file contents
		$image = file_get_contents($path);

		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		if (empty($name_err) && empty($description_err) && empty($price_err) && empty($category_err) && empty($image_err)) {

			$image = mysqli_real_escape_string($link, $image);
			$sql = "INSERT INTO items (item_name, description, category, price, verified, available, added_by, image_path) VALUES ('{$name}', '{$description}', '{$category}', '{$price}', 0, '1', '{$_SESSION['id']}', '{$target_file}')";

			if (mysqli_query($link, $sql)) {
				echo("Image was uploaded");
				header("location: welcome.php");
			} else {
				echo("Image was NOT uploaded");
			}
			mysqli_close($link);
		}
	}
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
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
										<option>Furnitures</option>
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
									<input type="hidden" name="MAX_FILE_SIZE" value="500000">
									<input type="file" name="image" style="margin-top:30px"/>
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
			</form>
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
