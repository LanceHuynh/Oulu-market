<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$welcome =  "My Account";
	header("location: welcome.php");
}
else{
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
	<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
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
</head>
<?php
	// Include config file
	require_once 'database/connection.php';
	// Define variables and initialize with empty values
	// $login is used for either email or username
	$login = $password = "";
	$login_err = $password_err = "";

	function is_email($str)
	{
		//If the input string is an e-mail, returns true
		if(filter_var($str, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		// Check if email or username is empty
		if(empty(trim($_POST["login"]))){
			$login_err = 'Please enter your email or username.';
		} else{
			$login = trim($_POST["login"]);
		}

		// Check if password is empty
		if(empty(trim($_POST['password']))){
			$password_err = 'Please enter your password.';
		} else{
			$password = trim($_POST['password']);
		}

		// Validate credentials
		if(empty($login_err) && empty($password_err)){

			$sql_mail = "SELECT email, password, id FROM user WHERE email = ?";

			$sql_usr = "SELECT username, password, id FROM user WHERE username = ?";

			if(is_email($login)){
				$stmt = mysqli_prepare($link, $sql_mail);
			}else{
				$stmt = mysqli_prepare($link, $sql_usr);
			}

			if($stmt){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_login);

				// Set parameters
				$param_login = $login;

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){

					// Store result
					mysqli_stmt_store_result($stmt);

					// Check if email exists, if yes then verify password
					if(mysqli_stmt_num_rows($stmt) == 1){
						// Bind result variables
						mysqli_stmt_bind_result($stmt, $login, $hashed_password, $id);

						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $hashed_password)) {

								/* Password is correct, so start a new session and
								save the username to the session */
								$_SESSION['loggedin'] = true;
								$_SESSION['login'] = $login;
								$_SESSION['id'] = $id;
								header("location: index.php");
							}else{
								// Display an error message if password is not valid
								$password_err = 'The password you entered was not valid.';
								
							}
						}
					}else{
						// Display an error message if email doesn't exist
						$login_err = 'No account was found with that email or username.';
					}
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}

			}else{
				// Close statement
				mysqli_stmt_close($stmt);
			}
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
			</div>
		</div>
	</div>
	<section>
	        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	        	<div class="sign-in-wrapper">
	        		<div class="graphs">
	        			<div class="sign-up">
							<h1>Log in to your account</h1>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Email Or Username :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($login_err)) ? 'has-error' : ''; ?>">
										<input type="text" name="login" placeholder="Your email or username" class="form-control" value="<?php echo $login; ?>"/>
										<span class="help-block"><?php echo $login_err; ?></span>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="sign-u">
								<div class="sign-up1">
									<h4>Password :</h4>
								</div>
								<div class="sign-up2 form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
										<input type="password" name="password" placeholder="Your password" class="form-control" value="<?php echo $password; ?>"/>
										<span class="help-block"><?php echo $password_err; ?></span>

								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub_home">
								<div class="sub_home_left">
									<input type="submit" value="Log in">
								</div>
								<div class="sub_home_right">
									<p>Go Back to <a href="index.php">Home</a></p>
								</div>

								<div class="clearfix"> </div>
							</div>
							<div class ="sub_home">
								<p id="dont_have_account">Don't have an account? <a href="register.php">Sign up now</a>.</p>
							</div>
           				</div>
           			</div>
           		</div>
		    </form>

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
	</section>
</body>
</html>
