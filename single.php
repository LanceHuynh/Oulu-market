<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
$_SESSION['start'] = time();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
$welcome =  "My Account";

if(time()>$_SESSION['start']+900){
	session_unset();
	session_destroy();
	$welcome = "Login";
	}
}else{
$welcome = "Login";
}

require_once 'database/connection.php';

$query = "select * from items where id ='".$_POST["id"]."';";
$result= $link->query($query);
$set = $result->fetch_assoc();
echo "<script>var id =".$_POST["id"]." </script>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Information</title>
	<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/bootstrap-select.css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- for-mobile-apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Resale Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
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
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$("#buy-button").click(function(event) {
				event.preventDefault();
				/* Act on the event */
				    var object={};
                    object.id = id;
                    object.buy = true;
					var util = {};
                    util.post = function() {
                        var $form = $('<form>', {
                            action: 'buying.php',
                            method: 'post'
                        });

                        $.each(object, function(key, val) {
                         console.log(object);
                         $('<input>').attr({
                             type: "hidden",
                             name: key,
                             value: val
                         }).appendTo($form);
                        });
                            $form.appendTo('body').submit();
                    };
                    util.post();
			});
		});
	</script>
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
				<script>
					$('#myModal').modal('');
				</script>
			</div>
		</div>
	</div>
		<!--single-page-->
		<div class="single-page main-grid-border">
			<div class="container">
				<div class="product-desc">
					<div class="col-md-7 product-view">
						<h2>
							<?php echo $set['item_name']?>
						</h2>
						<p>
							Added at <?php echo $set['added_at']?>
						</p>
						<img src="<?php echo $set['image_path']?>">
						<!-- FlexSlider -->
						<script defer src="js/jquery.flexslider.js"></script>
						<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

						<script>
					// Can also be used with $(document).ready()
					$(window).load(function() {
					  $('.flexslider').flexslider({
						animation: "slide",
						controlNav: "thumbnails"
					  });
					});
						</script>
						<!-- //FlexSlider -->
						<div class="product-details">
							<h4>
								<strong></strong>
							</h4>
							<p>
								<strong></strong>
							</p>
							<p>
								<strong>Summary:</strong><?php echo $set["description"]?>
							</p>

						</div>
					</div>
					<div class="col-md-5 product-details-grid">
						<div class="item-price">
							<div class="product-price">
								<p class="p-price">Price</p>
								<h3 class="rate">
									<?php echo $set['price']?>
								</h3>
								<div class="clearfix"></div>
							</div>
							<div class="condition">
								<p class="p-price">Condition</p>
								<h4>Good</h4>
								<div class="clearfix"></div>
							</div>
							<div class="itemtype">
								<p class="p-price">Item type</p>
								<h4>
									<?php echo $set["category"]?>
								</h4>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<br>
					<a href="" id="buy-button" class="btn btn-warning btn-md" role="button">Buy</a>
				</div>
			</div>
		</div>
		<!--//single-page-->
		<!--footer section start-->
		<footer>
			<div class="footer-bottom text-center">
				<div class="container">
					<div class="footer-logo">
						<a href="index.html">
							<span>Oulu</span>Market
						</a>
					</div>
					<div class="footer-social-icons">
						<ul>
							<li>
								<a class="facebook" href="#">
									<span>Facebook</span>
								</a>
							</li>
							<li>
								<a class="twitter" href="#">
									<span>Twitter</span>
								</a>
							</li>
							<li>
								<a class="flickr" href="#">
									<span>Flickr</span>
								</a>
							</li>
							<li>
								<a class="googleplus" href="#">
									<span>Google+</span>
								</a>
							</li>
							<li>
								<a class="dribbble" href="#">
									<span>Dribbble</span>
								</a>
							</li>
						</ul>
					</div>
					<div class="copyrights">
						<p>
							© 2018 Oulu Market. All Rights Reserved | Design by
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