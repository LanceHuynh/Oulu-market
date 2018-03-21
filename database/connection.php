<?php
$config = parse_ini_file('/home/otek/06/t6dang00/db.ini');
$servername = 'mysli.oamk.fi';
$username = $config['username'];
$password = $config['password'];
$dbname = $config['db'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>