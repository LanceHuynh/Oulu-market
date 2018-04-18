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

    $(".focus-layout").on('click', function(event) {
    	event.preventDefault();
    	/* Act on the event */
    	var category = $(this).find("h4").text();
    	var object = {};
    	object.category = category;
    	var util = {};
		util.post = function() {
	    	var $form = $('<form>', {
	        	action: 'furnitures.php',
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
<!--Styles for search bar-->
<style>
	#search_bar_container{text-align: center}
	#search_bar {
		background: #fff;
	    width: 81%;
	    outline: none;
	    padding: 11px 10px 10px 10px;
	    font-size: 13px;
	    color: #c4c4c4;
	}
	#search_bar_button{
		background: url(images/search.png) no-repeat 13px 11px rgba(24, 169, 158, 0.47);
	    width: 44px;
	    height: 39px;
	    border: none;
	    padding: 0;
	    margin-top: 0;
	}
</style>
<!--End Styles for search bar-->
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
	</div>
	<div class="main-banner banner text-center">
	  <div class="container">
			<h1>The first bazaar<span class="segment-heading">    in Oulu</span> with delivery</h1>
			<p>Software development project 2</p>
	  </div>
	</div>
		<!-- content-starts-here -->
		<div class="content">
			<div class="categories">
				<div class="container">
					<form id=search_bar_container method="post" action="furnitures.php">
						<input id="search_bar" name="input" type="text" value="Product name..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Product name...';}" required="">
						<input id="search_bar_button" type="submit" value=" ">
					</form>
					<div class="col-md-2 focus-grid">
						<a href="mobiles.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-mobile"></i></div>
									<h4 class="clrchg">Mobiles</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-2 focus-grid">
						<a href="electronics-appliances.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-laptop"></i></div>
									<h4 class="clrchg"> Electronics & Appliances</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-2 focus-grid">
						<a href="furnitures.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-wheelchair"></i></div>
									<h4 class="clrchg">Furnitures</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-2 focus-grid">
						<a href="books-sports-hobbies.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-book"></i></div>
									<h4 class="clrchg">Books, Sports & Hobbies</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-2 focus-grid">
						<a href="fashion.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-asterisk"></i></div>
									<h4 class="clrchg">Fashion</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-2 focus-grid">
						<a href="kids.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="fa fa-gamepad"></i></div>
									<h4 class="clrchg">Kids</h4>
								</div>
							</div>
						</a>
					</div>
					<div class="clearfix"></div>
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
