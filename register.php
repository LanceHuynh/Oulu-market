<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $welcome =  "My Account";
    if(isset($_SESSION['start']) && time()>$_SESSION['start']+900){
        session_unset();
        session_destroy();
        $welcome = "Login";
    }else{
        $_SESSION['start'] = time();
    }
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

$form_appears = true;

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = $registration_succ_msg = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }
    elseif(!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	$email_err = "Invalid email format";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate username
	if(empty(trim($_POST["username"]))){
		$username_err = "Please enter username.";
    }else{
		//Check if username exists
		$sql = "SELECT id FROM user WHERE username = ?";

		if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username already exists.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
	}

    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO user (username, email, password, active, userLevel) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssii", $param_username, $param_email, $param_password, $param_active, $param_userLvl);

            // Set parameters
            $param_username = $username;
			$param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$param_active = 1;
			$param_userLvl = 2;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $registration_succ_msg = "You have been registered. Please proceed to <a href=\"http://www.students.oamk.fi/~t6dang00/Oulu-market/login.php\">login page.</a>";
				$form_appears = false;
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
            <a class="account" href="register.php">Register</a>
			<a class="account" href="contact.php">Contact</a>
		</div>
	</div>
</div>
<?php
	if($form_appears == false) { ?>
	<h4 style="text-align:center;">
		You have been registered. Please proceed to <a href="http://www.students.oamk.fi/~t6dang00/Oulu-market/login.php">login page.</a>
	</h4>
	<br>
	<br>
<?php } ?>
<section>
	 <?php if($form_appears == true){ ?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-up">
						<h1>Create an account</h1>
						<br/>
						<h3><?php echo $registration_succ_msg; ?></h3>
						<br />
						<h2>Personal Information</h2>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Email Address* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
									<input type="text" name="email"placeholder="Your email address" class="form-control" value="<?php echo $email; ?>"/>
									<span class="help-block"><?php echo $email_err; ?></span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Username* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
									<input type="text" name="username" placeholder="Your username" class="form-control" value="<?php echo $username; ?>"/>
									<span class="help-block"><?php echo $username_err; ?></span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Password* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
									<input type="password" name="password" placeholder="Your password" class="form-control" value="<?php echo $password; ?>"/>
									<span class="help-block"><?php echo $password_err; ?></span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Confirm Password* :</h4>
							</div>
							<div class="sign-up2 form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
									<input type="password" name="confirm_password" placeholder="Confirm password" class="form-control" value="<?php echo $confirm_password; ?>"/>
									<span class="help-block"><?php echo $confirm_password_err; ?></span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sub_home">
							<div class="sub_home_left">
								<input type="submit" value="Create">
							</div>
							<div class="sub_home_right">
								<p>Go Back to <a href="index.php">Home</a></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
			</div>
		</form>
	 <?php } ?>
		<!--footer section start-->
		<footer>
			<div class="footer-bottom text-center" style="position: fixed;bottom: 0px;width: 100%;">
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
