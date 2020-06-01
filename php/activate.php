<?php
/*
 *Email activation form
 */

/* Get user token and ID from url */
require_once "DBController.php";
$db_handle = new DBController();
$id = $_GET['UserID'];
$token = $_GET['Token'];
$verify_query = "SELECT * FROM UserToken WHERE UserID='$id' AND Token = '$token'";
$count = $db_handle->numRows($verify_query);

/* If token and ID matches the database */
if ($count > 0) {
    //Updates Token
    $update_status_query = "UPDATE User set status = '1' WHERE UserID='" . $_GET["UserID"] . "'";
    $save_token_query = "UPDATE UserToken set Token = '$token' WHERE UserID='$id'";
    $saveresult = $db_handle->updateQuery($save_token_query);
	$result = $db_handle->updateQuery($update_status_query);
	
    /* if the status has been updated */
    if (!empty($result)) {
        // display success message
        echo "<script> alert('Your Gamer Tree User Account has been activated. Please proceed to login and enjoy use of the tournament management system.');
	    	window.location.href='../index.html'; </script>";
    } else {
        // display error message if status fails to update
        echo "<script> alert('There has been a problem with your registration. Please contact the Lindenwood University Library and Academic resources center to report your issue.');
				window.location.href='../index.html'; </script>";
    }
}
