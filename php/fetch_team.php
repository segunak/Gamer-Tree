<?php
/*
Author: Zhuocheng Shang
Description: This file if set to fetch team with a select menue           
*/

    //start a session
session_start();

    //if the user select a tournament is team based
if(isset($_POST['get_option']))
{
        //get current user data
    $servername = $_SESSION["servername"];
    $username = $_SESSION["databasename"];
    $password = $_SESSION["password"];
    $dbname = $_SESSION["databasename"];

        // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        //get the ID of selected tournament
    $tmID = $_POST['get_option'];
    $result = $conn->query( "SELECT * FROM Tournament WHERE TournamentID = '$tmID' AND Approved = '1' AND isTeamBased = '1'");
    $row = $result->fetch_assoc();
    if($row){

        $find = $conn->query("select TeamID,TeamName from Team where TournamentID = '$tmID'");

        echo "Select A Team"; 

            //insert <select> to DOM
        echo '<select name = "TeamName" class="form-control">';
        while ($row = $find->fetch_assoc()) {
                    //insert each team name as an option 
                echo '<option value= " ' . $row['TeamID']. ' ">' . $row['TeamName'] . '</option>';
         }
            //close select tag
        echo "</select>";
        exit;


    }


}
?>
