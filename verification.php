<?php
require_once 'database/connection.php';
$sql = "";
if ($_GET['stat'] == 'true'){
    $sql = "UPDATE items SET verified = 1 WHERE id = '{$_GET['id']}';";
}else{
    $sql = "DELETE FROM items WHERE id = '{$_GET['id']}';";
    unlink($_GET['path']);
}
mysqli_query($link, $sql);
mysqli_close($link);