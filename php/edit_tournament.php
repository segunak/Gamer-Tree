<?php
/*
Author: Zhuocheng Shang
Description: This file if set to Insert Records with matches to database.
            *** Need more developng on this file ****
            *** Not really tested and Need consider more situations ***
*/

if(isset($_POST["Update"])) {

        //connect to database
    require_once("DBController.php");
    $db_handle = new DBController();

        //get tournament id
    $tm_id = $_POST["GameID"];

        //check type
        //check team / individual
    $type = "SELECT isTeamBased FROM Tournament WHERE TournamentID = '" . $tm_id . "'";

    if ($type == 0) //individual
    {
       //Need consider the situation with individusl type

    } else if ($type == 1) { //team type

            //check number of team
        $query = "SELECT COUNT(*) FROM Team WHERE TournamentID = '$tm_id' ";
        $team_num = $db_handle->getCount($query);

            //find how many matches needed
        $matches = $team_num - 2;
        for ($i = 1; $i <= $matches; $i++) {

                //get winner name
            $win = $_POST["tm" . $i];

                //if select a winner
            if ($win != "????") {
                     //get teamid
                $teamID = "SELECT TeamID FROM Team TournamentID = '$tm_id' and TeamName ='$win' ";
                $currenTeam = $db_handle->getUserTeamID($teamID);
                    //get number of members in the team
                $result1 = "SELECT COUNT(*) FROM TeamMembers WHERE TeamID = '$currenTeam'";
                $row_count = $db_handle->getCount($result1);


               // echo "<script> alert('starting update record $win with tournament id $tm_id and tm $i');</script>";

                    //update Matches table
                for ($member = 0; $member < $row_count; $member++) {

                        //get each users id
                    $query3 = "SELECT UserID FROM TeamMembers Where TeamID = $currenTeam";
                    $user = $db_handle->getUserID($query3);

                         //see which match and update it
                    $query = "UPDATE Matches SET WinnerID = $user
                            WHERE  TournamentID = '$tm_id' ";
                    $db_handle->insertQuery($query);


                    //Should change the <option> to <optioj selectd="selected">

                }

            }

                //final winner
            $final = $_POST["finals"];
                //update Matches table
        }

        } else {
             echo "<script> alert('Bad Connect');
             </script>";
        }

}
?>