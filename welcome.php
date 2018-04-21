<?php
    // Initialize the session
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['login']) || empty($_SESSION['login'])){
		header("location: login.php");
		exit;
    }

    require_once 'database/connection.php';

    if (isset($_POST['delivery'])) {
        $query = "UPDATE delivery SET name ='".$_POST['name']."', address ='".$_POST['address']."', contact_num =".$_POST['number'].", ordered_at = CURRENT_TIMESTAMP WHERE item_id = ".$_POST['id'].";";
        $result= $link->query($query);
        ;
    } elseif (isset($_POST['shipping'])) {
        $query = "INSERT INTO shipping (item_id, owner_id, buyers_name, address, ordered_at, contact_num, status) VALUES (".$_POST['id'].",".$_SESSION['id'].",'".$_POST['name']."','".$_POST['address']."',CURRENT_TIMESTAMP,0,0);";
        $result= $link->query($query);
    }

    if (isset($_POST['claim'])) {
        $query = "DELETE FROM items where id = {$_POST['id']};";
        $result= $link->query($query);
    
    }

    $query = "SELECT items.id,item_name,price,added_at,verified,available,ordered_at,image_path,address  FROM items LEFT JOIN shipping ON items.id = shipping.item_id WHERE added_by = {$_SESSION['id']}";
    $result= $link->query($query);
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
    $javascript = json_encode($set);
    echo "<script>var js_array =".$javascript." </script>";

    $query = "SELECT user.id as 'User ID', items.id, added_by, item_name, description, image_path, price, category,address , ordered_at, available, added_at from (items inner join delivery on  items.id = delivery.item_id) inner join user on delivery.bought_by = user.id where user.id = ".$_SESSION['id'].";";
    $result= $link->query($query);
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
    $javascript = json_encode($set);
    echo "<script>var js_array1 =".$javascript." </script>";
?>


    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Oulu Market</title>
        <link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Oulu Market" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <!--fonts-->
        <link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
                <link href="css/template.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/welcome.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="js/handlebars-v4.0.11.js"></script>

        <style type="text/css">

            body{ font: 14px sans-serif; text-align: center; }

        </style>
        <script id="template" type="text/x-handlebars-template">
            <li class="item-list" data-id="{{id}}">
                <img src="{{image_path}}" alt="">
                <section class="list-left">
                    <h5 class="title">{{item_name}}</h5>
                    <span class="adprice">{{price}}</span>
                </section>
                <section class="list-right">
                    <span class="date">{{added_at}}</span>
                    <span class="data" style="visibility: hidden;">{{address}}</span>
                    <br>
                     <span class="verify">{{verified}}</span>
                     <br>
                     <span class="available verified">{{available}}</span>
                     <br>
                     <span class="ordered_at">Shipping service was order at {{ordered_at}}</span>
                    <a href="order_shipping.php" class="btn btn-danger btn-md shipping" role="button">Order Shipping</a>
                    <a href="#" class="btn btn-success btn-md claim" role="button" style="display: none;">Claim</a>
                </section>

                <div class="clearfix"></div>
            </li>
        </script>

        <script id="template1" type="text/x-handlebars-template">
            <li class="item-list" data-id="{{id}}">
                <img src="{{image_path}}" alt="">
                <section class="list-left">
                    <h5 class="title">{{item_name}}</h5>
                    <span class="adprice">{{price}}</span>
                </section>
                <section class="list-right">
                    <span class="method">{{address}}</span>
                    <br>
                    <span class="ordered_at">Delivery service was order at {{ordered_at}}</span>
                    <a href="order_delivery.php" class="btn btn-warning btn-md delivery" role="button">Order Delivery</a>
                </section>

                <div class="clearfix"></div>
            </li>
        </script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                console.log(js_array1);
                console.log(js_array);
                var source   = document.getElementById("template").innerHTML;
                var template = Handlebars.compile(source);
                for (var i = 0; i < js_array.length; i++)
                {
                    if (js_array[i].verified == "0")
                    {
                        js_array[i].verified = "Not verified";
                    } else {
                        js_array[i].verified = "Verified";
                    }
                    if (js_array[i].available == "0")
                    {
                        js_array[i].available = "Bought";
                    } else {
                        js_array[i].available = "";
                    }
                    if(js_array[i].address){
                    	console.log(js_array[i].address);
                    	js_array[i].address = "a";
                    }
                    var context = js_array[i];
                    var html    = template(context);
                    $("#sell").append(html);
                }

                source   = document.getElementById("template1").innerHTML;
                template = Handlebars.compile(source);
                for (var i = 0; i < js_array1.length; i++)
                {
                    if (js_array1[i].address == "" ) {
                       js_array1[i].address = "To be picked up at the warehouse";
                    } else {
                        js_array1[i].address = "To be delivered at given address";
                    }
                    var context = js_array1[i];
                    var html    = template(context);
                    $("#bought").append(html);
                }

                $(".delivery").on('click', function(event) {
                    event.preventDefault();
                    /* Act on the event */
                    var id = $(this).parent().parent().attr('data-id');
                    var object = {};
                    object['id'] = id;
                    console.log(object);
                    var util = {};
                    util.post = function() {
                        var $form = $('<form>', {
                            action: 'order_delivery.php',
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

                $(".shipping").on('click', function(event) {
                    event.preventDefault();
                    /* Act on the event */
                    var id = $(this).parent().parent().attr('data-id');
                    var object = {};
                    object['id'] = id;
                    var util = {};
                    util.post = function() {
                        var $form = $('<form>', {
                            action: 'order_shipping.php',
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

                $(".claim").on('click', function(event) {
                    event.preventDefault();
                    /* Act on the event */
                    var id = $(this).parent().parent().attr('data-id');
                    var object = {};
                    object['id'] = id;
                    object['claim'] = "claim";
                    var util = {};
                    util.post = function() {
                        var $form = $('<form>', {
                            action: 'welcome.php',
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
                 $(".verify").each(function(index, el) {
                        console.log($(this).text());
                        if ($(this).text() == "Verified")
                        {
                            $(this).toggleClass('verified');
                            $(this).parent().find('a').css('display', 'none');
                            $(this).parent().find('.ordered_at').css('display', 'none');
                        } else {
                            $(this).toggleClass('not-verified');
                        }
                    });
                 $(".available").each(function(index, el) {
                 	if ($(this).text()) {
                 		$(this).parent().find('.claim').css('display', 'block');
                 	}
                 });

                 $(".method").each(function(index, el) {
                     if ($(this).text() == "To be delivered at given address") {
                        $(this).parent().find('a').css('display', 'none');
                     } else {
                        $(this).parent().find('.ordered_at').css('display', 'none');
                     }
                 });

                 $(".shipping").each(function(index, el) {
                 	 if ($(this).parent().find('.data').text() !== "") {
                 	 	$(this).css('display', 'none');
                 	 }
                     if ($(this).css('display') !== "none") {
                        $(this).parent().find('.ordered_at').css('display', 'none');
                     }
                 });
            });

        </script>

    </head>

    <body>

      <div class="header">
        <div class="container">
          <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo" style="width:150px;height:150px;"><span>Oulu</span>Market</a>
          </div>
          <div class="header-right">
            <p><a href="logout.php" class="account" style="background-color:red;">Sign Out of Your Account</a></p>
          </div>
        </div>
      </div>

        <div class="page-header">

            <h4>Hi, <b><?php echo htmlspecialchars($_SESSION['login']); ?></b>. Welcome to Oulu Market.<h4>

        </div>

        <br>
        <?php 
		if(isset($_POST['claim'])){ ?>
			<h2 style="text-align:center;">
				You have successfully claim the income for the item</a>.
			</h2>
			<br>
			<br>
	<?php } ?>
        <div class="container">
            <h4 style="text-align: left">Bought Item</h4>
            <div id="bought" class="item-container">
            </div>
        </div>
        <br>
        <div class="container">
            <h4 style="text-align: left">Your Listed Item</h4>
            <div id="sell" class="item-container">

            </div>
        </div>
        <br>

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
