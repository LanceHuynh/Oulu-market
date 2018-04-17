<?php
    // Initialize the session
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['login']) || empty($_SESSION['login'])){
		header("location: login.php");
		exit;
    }

    if(time() - $_SESSION['timestamp'] > 600) { //subtract new timestamp from the old one
        echo"<script>alert('15 Minutes over!');</script>";
        unset($_SESSION['login'], $_SESSION['password'], $_SESSION['timestamp']);
        $_SESSION['loggedin'] = false;
        header("location: index.php"); //redirect to index.php
        exit;
    } else {
        $_SESSION['timestamp'] = time(); //set new timestamp
    }
?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Oulu Market</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif; text-align: center; }

        </style>

    </head>

    <body>

        <div class="page-header">

            <h4>Hi, <b><?php echo htmlspecialchars($_SESSION['login']); ?></b>. Welcome to Oulu Market.<h4>

        </div>

        <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>

    </body>

    </html>

