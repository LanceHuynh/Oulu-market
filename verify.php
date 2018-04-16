<?php
// Include config file
require_once 'database/connection.php';

//Declare variables
$item_id = $verify_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "UPDATE items SET verifed = 1 WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST["item_id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $verify_message = "You have verified this item.";
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
    mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>