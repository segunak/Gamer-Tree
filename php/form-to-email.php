<?php
/*
require_once("DBController.php");
$db_handle = new DBController();

$currentEmail = $_POST['email'];
$currentName = $_POST['name'];
$query = "SELECT Email FROM User WHERE Email = '" . $currentEmail . "'";
$count = $db_handle->numRows($query);
if($count > 0) {
	$toEmail = $currentEmail;
	$subject = $currentName;
	$content = "Tounrmanet is approved. <a href ='" . $actual_link ."'> </a>";
	$mailHeaders = "From: $currentName";
	if (mail($toEmail, $subject, $content, $mailHeaders)) {
			echo "<script> alert('Your tounrmanet is approved. check your email ');
	window.location.href='../index.html'; </script>";
			exit;
	}
	unset($_POST);
}
else {
$message = "Problem in account activation.";
}
*/

/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 3/7/2018
 * Time: 5:26 PM
 */


 require_once("DBController.php");
$db_handle = new DBController();

$currentName = $_POST['name'];
$currentEmail = $_POST['email'];
$message = $_POST['description'];

$query = "SELECT Email FROM User WHERE Email = '" . $currentEmail . "'";

if($count > 0) {
	$toEmail = $currentEmail;
	$subject = $currentName;
	$content = $message;
	$mailHeaders = "From: $currentName";
	if (mail($toEmail, $subject, $content, $mailHeaders)) {
        //Done. Redirect to thank-you page.
        $url='../thankyou.html';
        echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
        exit;
	}
	unset($_POST);
}
else {
$message = "Problem in message delivery please try again.";
}
?>
