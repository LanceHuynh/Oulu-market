<?php
	session_start();
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$welcome =  "My Account";

	if(time()>$_SESSION['expire']){
		session_unset();
		session_destroy();
		$welcome = "Login";
		}
	}else{
	$welcome = "Login";
	}

	$_SESSION['start'] = time();
?>

<?php
// Include config file
require_once 'database/connection.php';

//Declare variables
$item_id = $user_id = $order_delivery_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "UPDATE delivery SET delivery_date = curdate() + 10 WHERE (item_id = ? && bought_by = ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_item_id, $param_user_id);

        // Set parameters
        $param_item_id = trim($_POST["item_id"]);
        $param_user_id = trim($_POST["user_id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $verify_message = "You have ordered to deliver this item.";
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