<?php

require_once "DBController.php";
$db_handle = new DBController();

$currentTMid = $_POST['get_id'];
$reason = $_POST['get_reason'];

$query = "SELECT Creator FROM Tournament WHERE TournamentID = '" . $currentTMid . "'";
$email = $db_handle->getEmail($query);

if (!empty($email)) {
    $query1 = "UPDATE Tournament set Approved = '0' WHERE TournamentID='" . $currentTMid . "'";

    //delete the tournament from database
    $result2 = $db_handle->deleteQuery("DELETE  FROM Tournament WHERE TournamentID = '$currentTMid' ");
    $result3 = $db_handle->deleteQuery("DELETE  FROM tbl_uploads WHERE TournamentId = '$currentTMid' ");
    $result = $db_handle->updateQuery($query1);

    //the creator's email address
    $toEmail = $email;
    $subject = "Tournament status"; 
    $mailHeaders = "From: noreply@tourneyregistration.com\r\n";

    if (mail($toEmail, $subject, $content, $mailHeaders)) {
        echo "<script> alert('The tounrmanet is denied. ');
        window.location.href='../index.php'; </script>";
        exit;
    }
    unset($_POST);
} else {
    $message = "Problem in account activation.";
}
