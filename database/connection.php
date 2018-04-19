<?php
$config = parse_ini_file('/home/otek/06/t6dang00/db.ini');
$servername = 'mysli.oamk.fi';
$username = $config['username'];
$password = $config['password'];
$dbname = $config['db'];
	
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Attempt to connect to MySQL database */
$link = mysqli_connect($servername, $username, $password, $dbname);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>