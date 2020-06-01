<?php

//connect to the database
require_once "DBController.php";
$db_handle = new DBController();

//get the current tournament ID
$currentTMid = $_POST['get_id'];

//get the eamil address of the creator
$query = "SELECT Creator FROM Tournament WHERE TournamentID = '" . $currentTMid . "'";
$email = $db_handle->getEmail($query);

if (!empty($email)) {

    //update the status of tournament, set approved to '1'
    $query1 = "UPDATE Tournament set Approved = '1' WHERE TournamentID='" . $currentTMid . "'";
    $result = $db_handle->updateQuery($query1);

    //get creator ID
    $Check_UserID = "SELECT UserID FROM User WHERE email = '$email'";
    $getUserID = $db_handle->getUserID($Check_UserID);

    //insert tournament ID into UserTournaments Table associated with creator id
    $query4 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
                ('$currentTMid', '$getUserID')";
    $insideTable = $db_handle->insertQuery($query4);
    $toEmail = $email; //the email address of tournament creator
    $subject = "Tournament status"; //email subject
    $content = "The Tournament is approved. <a href ='" . $actual_link . "'> </a>"; 
    $mailHeaders = "From: noreply@tourneyregistration.com\r\n";

    //if the email sends successfully 
    if (mail($toEmail, $subject, $content, $mailHeaders)) {
        echo "<script> alert('The tournament has been approved.');
                  window.location.href='../index.php'; </script>";
        exit;
    }
    unset($_POST);
} else {
    //error message
    $message = "Problem in account activation.";
}
