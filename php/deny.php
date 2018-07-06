<?php
/*
Author: Zhuocheng Shang
Description: This file if set to delete a tournament which is on the Pending list
*/

    //connect to database
require_once("DBController.php");
$db_handle = new DBController();

    //get current tournament ID and the deny reason
$currentTMid = $_POST['get_id'];
$reason = $_POST['get_reason'];

    //get tournament's creator ID
$query = "SELECT Creator FROM Tournament WHERE TournamentID = '" . $currentTMid . "'";
$email = $db_handle->getEmail($query);

    //start manage email, and send an email to the creator that the tournamnet is denied
if(!empty($email)) {
    $query1 = "UPDATE Tournament set Approved = '0' WHERE TournamentID='" . $currentTMid . "'";   

        //delete the tournament from database
    $result2 = $db_handle->deleteQuery( "DELETE  FROM Tournament WHERE TournamentID = '$currentTMid' ");
    $result3 = $db_handle->deleteQuery( "DELETE  FROM tbl_uploads WHERE TournamentId = '$currentTMid' ");

    $result = $db_handle->updateQuery($query1);

        /*this link can be sent within the email, and click this link will run the code 
          in this file, which will delete this tournament. Can be used to test during developing.
        */
        //$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."deny.php?TournamentID=" . $currentTMid."&email=".$email;

        //the creator's email address 
    $toEmail = $email;
    $subject = "Tournament status"; //email subject
        //email content
    $content = "Tounrmanet is denied.  The reason is:  " .$reason . "     "." <a href ='" . $actual_link ."'> </a>";
    $mailHeaders = "From: noreply@tourneyregistration.com\r\n";

    if (mail($toEmail, $subject, $content, $mailHeaders)) {
        echo "<script> alert('The tounrmanet is denied. ');
        window.location.href='../index.php'; </script>";
        exit;
    }
    unset($_POST);
}
else {
    $message = "Problem in account activation.";
}

?>
