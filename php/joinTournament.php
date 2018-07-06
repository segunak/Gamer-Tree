<?php
/*
Author: Zhuocheng Shang, Marlon Djouba
Description: This file if set to dealing with enrolling a player           
*/

session_start();

  //if no error message
if(!isset($message)) {

    //connect to database
  require_once("DBController.php");
  $db_handle = new DBController();

    //get current users' email and user id
  $email = $_SESSION["email"];
  $query = "SELECT UserID FROM User WHERE email='$email'";
  $current_id = $db_handle->getUserID($query);

    //get tournament name and team name the user want to join
  $TMname =  $_POST["TMname"];
  $TeamName= $_POST["TeamName"];

        //count how many teams in the tournament if is teambased
    $result1 = "SELECT COUNT(*) FROM TeamMembers WHERE TeamID = '$TeamName'";
    $row_count = $db_handle->getCount($result1);

        // get the limit size of a specific team
    $result2 = "SELECT TeamLimit FROM Team WHERE TournamentID ='$TMname' AND TeamID = '$TeamName'";
    $team_limit=$db_handle->getTeamLimit($result2);

        //if is  team based
    if(!empty($TeamName)){
        //make sure to check the limit size of a team
    if($row_count<$team_limit) 
    {
          //if not touch the limit size, enroll this person
      $query2 ="INSERT INTO TeamMembers (TeamID,UserID) VALUES
                ('" . $_POST["TeamName"] . "', '$current_id')";
      $insideTable = $db_handle->insertQuery($query2);

      $query1 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
                  ('" . $_POST["TMname"] . "', '$current_id')";
      $insideTable2 = $db_handle->insertQuery($query1);

      echo "<script> alert('You successfuly joined the team');
     window.location.href='../index.php'; </script>";
  }else{

      echo "<script> alert('This team is already full');
            window.location.href='../index.php'; </script>";
}

}else{
  $query3 = "SELECT UserID FROM User WHERE email='$email'";
  $current_id = $db_handle->getUserID($query3);
  $query4 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
            ('" . $_POST["TMname"] . "', '$current_id')";
  $insideTable = $db_handle->insertQuery($query4);
          echo "<script> alert('You successfuly joined this tournament');
           window.location.href='../index.php'; </script>";

}

}else{
  echo "<script> alert('You already in the tournament!');
           window.location.href='../index.html'; </script>";
}
?>
