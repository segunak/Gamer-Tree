<?php

session_start();

if (!isset($message)) {

    //connect to database
    require_once "DBController.php";
    $db_handle = new DBController();

    $email = $_SESSION["email"];
    $query = "SELECT UserID FROM User WHERE email='$email'";
    $current_id = $db_handle->getUserID($query);

    $TMname = $_POST["TMname"];
    $TeamName = $_POST["TeamName"];

    $result1 = "SELECT COUNT(*) FROM TeamMembers WHERE TeamID = '$TeamName'";
    $row_count = $db_handle->getCount($result1);

    $result2 = "SELECT TeamLimit FROM Team WHERE TournamentID ='$TMname' AND TeamID = '$TeamName'";
    $team_limit = $db_handle->getTeamLimit($result2);

    if (!empty($TeamName)) {

        if ($row_count < $team_limit) {
            $query2 = "INSERT INTO TeamMembers (TeamID,UserID) VALUES
                ('" . $_POST["TeamName"] . "', '$current_id')";
            $insideTable = $db_handle->insertQuery($query2);

            $query1 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
                  ('" . $_POST["TMname"] . "', '$current_id')";
            $insideTable2 = $db_handle->insertQuery($query1);

            echo "<script> alert('You successfully joined the team.');
     window.location.href='../index.php'; </script>";
        } else {

            echo "<script> alert('This team is already full');
            window.location.href='../index.php'; </script>";
        }

    } else {
        $query3 = "SELECT UserID FROM User WHERE email='$email'";
        $current_id = $db_handle->getUserID($query3);
        $query4 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
            ('" . $_POST["TMname"] . "', '$current_id')";
        $insideTable = $db_handle->insertQuery($query4);
        echo "<script> alert('You successfully joined this tournament');
           window.location.href='../index.php'; </script>";

    }

} else {
    echo "<script> alert('You're already in the tournament!');
           window.location.href='../index.html'; </script>";
}
