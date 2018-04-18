<?php
//include config file
require_once 'database/connection.php';

$sql = "SELECT image FROM items WHERE id = 1";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($link);

//echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
header("Content-type: image/jpeg");
echo $row['image'];
?>
