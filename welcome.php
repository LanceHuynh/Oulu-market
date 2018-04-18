<?php
    // Initialize the session
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['login']) || empty($_SESSION['login'])){
		header("location: login.php");
		exit;
    }

    require_once 'database/connection.php';

    $query = "select * from items where added_by =".$_SESSION['id'].";";
    $result= $link->query($query);
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
    $javascript = json_encode($set);
    echo "<script>var js_array =".$javascript." </script>";

?>


    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Oulu Market</title>

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
                    <a href="order_shipping.php" class="btn btn-danger btn-md" role="button">Order Shippings</a>
                </section>

                <div class="clearfix"></div>
            </li>
        </script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var source   = document.getElementById("template").innerHTML;
                var template = Handlebars.compile(source);
                for (var i = 0; i < js_array.length; i++)
                {
                    var context = js_array[i];
                    var html    = template(context);
                    $("#sell").append(html);
                }

                $(".list-right a").on('click', function(event) {
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
            });
            
        </script>

    </head>

    <body>

        <div class="page-header">

            <h4>Hi, <b><?php echo htmlspecialchars($_SESSION['login']); ?></b>. Welcome to Oulu Market.<h4>

        </div>

        <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>

        <div class="container">
            <h4 style="text-align: left">Bought Item</h4>
            <div class="item-container">
            </div>
        </div>
        <div class="container">
            <h4 style="text-align: left">Your Listed Item</h4>
            <div id="sell" class="item-container">
                
            </div>
        </div>

    </body>

    </html>

