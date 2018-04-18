<?php
	session_start();
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$welcome =  "My Account";

	if(time()>$_SESSION['expire']){
		session_destroy();
		$welcome = "Login";
		}
	}else{
	$welcome = "Login";
	}

	$_SESSION['start'] = time();
?>

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
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
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
			<a href="selling.php">Start selling</a>
			<a href="buying.php">Start buying</a>
	  </div>
	</div>
  <!-- Who we are -->
			<div class="trending-ads">
				<div class="container">
			</div>
			<div class="mobile-app">
				<div class="container">
					<div class="col-md-7 app-right">
						<h3>Oulu Market is the <span>BEST</span> way for Selling and buying second-hand goods</h3>
            <p>We are OAMK students. This site was create for Software Development project 2<br>
            GROUP 7: Dao Nguyen Thanh Hung, Huynh Hoang Lan, Kunik Jan, Glos Daniel</p>
					</div>
				</div>
			</div>
		</div>
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
