<?php
/*
Author: Zhuocheng Shang, Marlon Djouba
Description: This file if set to update tournament status as 'Approved' and send email to the creator 
*/

    //connect to database
require_once("DBController.php");
$db_handle = new DBController();

    //get current tournament ID
$currentTMid = $_POST['get_id'];

    //get the eamil address of the creator
$query = "SELECT Creator FROM Tournament WHERE TournamentID = '" . $currentTMid . "'";
$email = $db_handle->getEmail($query);

    //if there exist a creator
if(!empty($email)) {

        //update the status of tounrament, set approved to '1'
    $query1 = "UPDATE Tournament set Approved = '1' WHERE TournamentID='" . $currentTMid . "'";
    $result = $db_handle->updateQuery($query1);

        //get creator ID
    $Check_UserID = "SELECT UserID FROM User WHERE email = '$email'";
    $getUserID = $db_handle->getUserID($Check_UserID);

        //insert tournament ID into UserTournaments Table associated with creator id
    $query4 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
                ('$currentTMid', '$getUserID')";
    $insideTable = $db_handle->insertQuery($query4);

        //prepare the email information
        
           
        /*this link can be sent within the email, and click this link will run the code 
             in this file, which will approve this tournament. Can be used to test during developing.
        */
        //$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."approved.php?TournamentID=" . $currentTMid."&email=".$email;
        $toEmail = $email; //the email address of tournament creator
        $subject = "Tournament status"; //email subject
        $content = "Tounrmanet is approved. <a href ='" . $actual_link ."'> </a>"; //email content
        $mailHeaders = "From: noreply@tourneyregistration.com\r\n"; 

            //if sucessfuly send the email
        if (mail($toEmail, $subject, $content, $mailHeaders)) {
            echo "<script> alert('The tounrmanet is approved.');
                  window.location.href='../index.php'; </script>";
            exit;
         }
        unset($_POST);
    }

    else
     {
            //error message
        $message = "Problem in account activation.";
    }

?>
