<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $welcome =  "My Account";
    $pleaseLogin = "Verify item";
    if(isset($_SESSION['start']) && time()>$_SESSION['start']+900){
        session_unset();
        session_destroy();
        $welcome = "Login";
    }else{
        $_SESSION['start'] = time();
    }
}else{
    $welcome = "Login";
    $pleaseLogin = "<span style=\"font-size:48px\">You must log in first to verify an item!</span>";
}
// Include config file
require_once 'database/connection.php';

if (isset($_POST["id"])) {
    $item_id = $_POST['id'];
    $query = "select * from items where id = '{$item_id}'";
    $result= $link->query($query);
    $set = $result->fetch_assoc();
    mysqli_close($link);
} else {
    header("location: index.php");
    exit;
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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/flexslider.css" media="screen" />
    <script type="text/javascript">var item_id = <?php echo json_encode($item_id); ?>;var img_path = <?php echo json_encode($set['image_path']); ?>;</script>
    <script type="text/javascript">
        function verify(status) {
            $.ajax({
                type: 'GET',
                url: 'verification.php',
                data: { stat: status, id: item_id, path: img_path},
                success: function( data ) {
                    if (status){
                        alert("Item was verified.");
                    }else {
                        alert("Item was removed from database.");
                    }
                    location.href = 'welcome.php';
                },
            });
        }
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
            <a class="account" href="register.php">Register</a>
            <a class="account" href="contact.php">Contact</a>
        </div>
    </div>
</div>
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
                                <?php echo $set['price'].'€'?>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="product-price">
                            <p class="p-price">Description</p>
                            <h4 class="rate">
                                <?php echo $set['description']?>
                            </h4>
                            <div class="clearfix"></div>
                        </div>
                        <img src="<?php echo $set['image_path']?>" style="width:100%; height:40%; margin-bottom:3%;">
                    </div>
                    <div style="text-align: center; margin-top: 30px">
                        <div style="display: inline-block;">
                            <button class="button" style="float: none" onclick="verify(true)">Verify</button>
                            <button class="button" style="float: none; margin-left: 20px" onclick="verify(false)">Discard</button>
                        </div>
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
</body>
</html>
