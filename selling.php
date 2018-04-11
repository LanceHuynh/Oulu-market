<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $welcome =  "My Account";
}else{
	$welcome = "Login";
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
$name = $description = $price = "";
$name_err = $description_err = $price_err = "";

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

    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO items (item_name, description, category, price, verified, available, added_by, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssiiiib", $param_name, $param_description, $param_category, $param_price, $param_verified, $param_available, $param_added, $param_image);

            // Set parameters
            $param_name = $name;
			$param_description = $description;
			$param_category = 1;
			$param_price = $price;
			$param_verified = 0;
			$param_available = 1;
			$param_added = $_SESSION['id'];
			$param_image = "";

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $registration_succ = "You have been registered. Please proceed to <a href=\"http://www.students.oamk.fi/~t6dang00/Oulu-market/login.php\">login page.</a>";
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
        <a href="index.php"><img src="images/logo.png" alt="Logo" style="width:150px;height:150px;"><span>Oulu</span>Market</a>
      </div>
      <div class="header-right">
      <a class="account" href="login.php"><?php echo $welcome; ?></a>
      <a class="account" href="contact.php">Contact</a>
				<script>
				$('#myModal').modal('');
				</script>
			</div>
		</div>
		</div>
	<div class="main-banner banner text-center">
	  <div class="container">
      <h1>The first bazaar<span class="segment-heading">    in Oulu</span> with delivery</h1>
			<p>Software development project 2</p>
	  </div>
	</div>
	<div class="submit-ad main-grid-border">
		<div class="container">
			<h3><?php echo $not_loggedin; ?></h3>
			<h2 class="head">Submit an item for selling.</h2>
			<div class="post-ad-form">
				<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<label>Select Category <span>*</span></label>
					<select class="category">
						<option>Select Category</option>
						<option>Mobiles</option>
						<option>Electronics and Appliances</option>
						<option>Furniture</option>
						<option>Books, Sports and hobbies</option>
						<option>Fashion</option>
						<option>Kids</option>
					</select>
					<div class="clearfix"></div>
					<label>Add product name<span>*</span></label>
					<input type="text" class="phone" placeholder="" name="name">
					<span class="help-block"><?php echo $name_err; ?></span>
					<div class="clearfix"></div>
					<label>Add Description <span>*</span></label>
					<textarea class="mess" placeholder="Write few lines about your item" name="description"></textarea>
					<span class="help-block"><?php echo $description_err; ?></span>
					<div class="clearfix"></div>
					<label>Enter product price<span>*</span></label>
					<input type="text" class="phone" placeholder="" name="price">
					<span class="help-block"><?php echo $price_err; ?></span>
					<div class="clearfix"></div>
				<div class="upload-ad-photos">
				<label>Photo for your item :</label>
					<div class="photos-upload-view">
						<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />

						<div>
							<input type="file" id="fileselect" name="fileselect[]" multiple="multiple" />
							<div id="filedrag">or drop files here</div>
						</div>

						<div id="submitbutton">
							<button type="submit">Upload Files</button>
						</div>

						<div id="messages">
						<p>Status Messages</p>
						</div>
						</div>
					<div class="clearfix"></div>
						<script src="js/filedrag.js"></script>
				</div>
					<div class="personal-details">
						<div class="clearfix"></div>
						<p class="post-terms">By clicking <strong>post Button</strong> you accept our Terms of Use and Privacy Policy</p>
					<input type="submit" value="Post">
					<div class="clearfix"></div>
					</div>
					</form>
			</div>
		</div>
	</div>
	<!-- // Submit Ad -->
	<!--footer section start-->
		<footer>
			<div class="footer-bottom text-center">
			<div class="container">
				<div class="footer-logo">
					<a href="index.php"><span>Oulu</span>Market</a>
				</div>
				<div class="copyrights">
					<p> © 2018 OuluMarket. All Rights Reserved | Design by  <a href="http://w3layouts.com/"> W3layouts</a></p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		</footer>
        <!--footer section end-->
</body>
</html>
