<?php
  require_once('database/connection.php');
  
  $id = $_GET['id'];
  // do some validation here to ensure id is safe

  $sql = "SELECT image FROM items WHERE id=$id";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  mysqli_close($link);

  // Set the content type of this page to image/jpeg since the image we are pulling out is a jpg image.   
  header("Content-type: image/jpeg");

  // Echo out the image.
  echo $row['image'];
?>