<?php
/*
*Forgot password form
*version 1.0
*Author Keith Djouba
*modified by Tunde Akinyemi
*
* This form would send an email to user if they email address matche the
*in the database
*/
/* If no error message*/
if(!isset($message)) {
  require_once("DBController.php");// get the the database connection
  $db_handle = new DBController();// call database connection class
	$current_email = $_POST["emailForm"];
	$select_idquery= "SELECT UserID FROM User WHERE email='$current_email'";
	$current_id = $db_handle->getUserID($select_idquery);
  $query = "SELECT * FROM User WHERE email='$current_email'";
  $count = $db_handle->numRows($query);
  $token = $db_handle->generateNewString();
/* If the number of row is more than 0*/
  if($count>0) {
    /*Update token so user would not be able to clinck on link again*/
    $updateToken= "UPDATE UserToken set Token = '$token' WHERE UserID='$current_id'";
    $result2 = $db_handle->updateQuery($updateToken);
    /*If the current ID send emailForm*/
    if(!empty($current_id)) {
      $actual_link = "http://ec2-18-232-182-234.compute-1.amazonaws.com/php/resetlink.php?UserID=$current_id&Token=$token";
      $toEmail = $current_email;
      $subject = "User Registration Activation Email";
      $content = "Click this link to activate your account. <a href='" . $actual_link . "'> </a>";
      $mailHeaders = "From: noreply@tourneyregistration.com\r\n";// get email adress
      /*Send email with the specified variables*/
      if(mail($toEmail, $subject, $content, $mailHeaders)) {
        echo "<script> alert('A link has been sent to your email adress.');
        window.location.href='../index.html'; </script>";
				exit;
      }
      /*destroys the specified variables*/
      unset($_POST);
    } else {
      $message = "Problem in registration. Try Again!";
    }
  }
   else
   {
     echo "<script> alert('The email address you entered is already associated with a user account');
     window.location.href='../index.html'; </script>";
		  exit;
    }

  }

  if(!empty($message)) {
    if(isset($message)) echo $message;
  }

  if(!empty($error_message)) {
    if(isset($error_message)) echo $error_message;
  }

?>
