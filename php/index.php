<?php

session_start();

if ($_SESSION["logged_in"] == false) {
    header("Location: ../index.html");
}

$servername = $_SESSION["servername"];
$username = $_SESSION["databasename"];
$password = $_SESSION["password"];
$dbname = $_SESSION["databasename"];
$email = $_SESSION["email"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Below is the retrieval of user info.
$sql = "SELECT FirstName, LastName, Email FROM User WHERE Email = \"$email\"";
$result = $conn->query($sql);
$userArray = array();

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //
        $userArray = array("email" => $row["Email"], "first" => $row["FirstName"], "last" => $row["LastName"]);
    }
} else {
    echo "0 results";
}
/*
 * If you need to check who is logged in the code below will print at the top of the page
 * the current users email and full name. Simply remove from the comment block to use.
 *
 * foreach ($userArray as $key => $value) { echo "Key: $key; Value: $value\n"; }
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/Logo.svg">

    <!-- CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel = "stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href = "../css/glyphicons.css" rel = "stylesheet">
    <link href = "../css/tempusdominus-bootstrap-4.min.css" rel = "stylesheet">
    <link href = "../css/bracketgenerator.css" rel = "stylesheet">
    <link href = "../css/_card.scss" rel = "stylesheet">


    <!--  JavaScript --> <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
         integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script> -->
    <script src="http://underscorejs.org/underscore-min.js"></script>
    <script src="../js/createtournament.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src = "../js/tempusdominus-bootstrap-4.min.js"></script>

    <title>Gamer Tree</title>

    <nav class="navbar navbar-expand-lg navbar-dark" style="color: black;">
        <a class="navbar-brand" id="lu-title-text" href="index.php">Lindenwood</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#modalEnrollForm">Join Tournament</a>
                <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#createTournament">Create Tournament</a>
                <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#modalContactForm">Support</a>
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <ul class="nav sticky-top nav-tabs nav-fill navbar-dark" id="myTab" role="tablist" style="background-color: #b6a16b">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="color: black;">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false" style="color: black;">Agenda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="records-tab" data-toggle="tab" href="#records" role="tab" aria-controls="records" aria-selected="false" style="color: black;">Records</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="color: black;">Profile</a>
        </li>
        <?php
                //connect database
            require_once "DBController.php";
            $db_handle_pending = new DBController();
                //check if the person is an Administrator or not
            $check_Admin_pending = "select Email from User where Email = \"$email\" and Admin = 1";
            $count_pending = $db_handle_pending->numRows($check_Admin_pending);
            if ($count_pending > 0) {
                //if it is an Admin, will show another 'Pending' button on the nav-bar
            echo
                "<li class=\"nav-item\">" .
                "<a class=\"nav-link\" id=\"profile-tab\" data-toggle=\"tab\" href=\"#Pending\" role=\"tab\" aria-controls=\"profile\" aria-selected=\"false\" style=\"color: black; background-color: red;\">Pending</a>" .
                "</li>";

            }
        ?>
    </ul>
</head>

<body>
<div class="tab-content text-center" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3>HOME</h3>

            <!-- Check Admin or not -->
        <?php
        $check_Admin1 = "select Email from User where Email = \"$email\" and Admin = 1";
        $count1 = $db_handle_pending->numRows($check_Admin1);
        if ($count1 > 0) { //if is an Admin
                //get all tournament information
            $sql = "SELECT TournamentID, Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 1";
            $result = $conn->query($sql);

            $id_number = 1;

                /*** ********* Amin Home Page ******** */
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                $string = $row["StartDate"];
                $timestamp = strtotime($string);
                $tm_id = $row["TournamentID"];

                $query = "SELECT file FROM tbl_uploads WHERE TournamentId='$tm_id'";
                $current_image = $db_handle_pending->getImage($query);
                echo
                "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                "<div class=\"card-body\">" .
                "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .

                "<img src= \"../uploads/$current_image\" class=\"img-thumbnail\" height=\"60%\" width=\"50%\" style= \"border:none\">" .

                "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#deleteModal" . $row["TournamentID"] . "\">DELETE</button>" .
                "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#updateModal" . $row["TournamentID"] . "\">UPDATE</button>" .
                "</div>" .
                "</div>" .

                // Todo modal Delete tournament.
                "<div class=\"modal fade\" id=\"deleteModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deleteModal\" aria-hidden=\"true\">" .
                "<div class=\"modal-dialog\" role=\"document\">" .
                "<div class=\"modal-content\">" .
                "<div class=\"modal-header\">" .
                "<h5 class=\"modal-title\" id=\"deleteModal\">Delete " . $row["Name"] . "</h5>" .
                "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                "<span aria-hidden=\"true\">&times;</span>" .
                "</button>" .
                "</div>" .
                "<div class=\"modal-body\">" .
                "<form  method = \"POST\">" .
                "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                "<p><strong>YOU ARE ABOUT TO DELETE AN ENTIRE TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you delete this tournament." .
                "</div>" .
                "</div>" .
                "<div class=\"modal-footer justify-content-center\">" .
                "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                "<button type=\"submit\" value = \"$tm_id\"  onclick=\"deleteTM(this.value);\"  class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                "</div>" .
                "</form>" .
                "</div>" .
                "</div>" .
                "</div>" .


                // Todo modal Update tournament
                "<div class=\"modal fade\" id=\"updateModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"updateTournament\" aria-hidden=\"true\">" .
                "<div class=\"modal-dialog\" role=\"document\">" .

                "<div class=\"modal-content\">" .

                "<div class=\"modal-header light-blue darken-3 white-text\">" .
                "<h4 class=\"title col-sm-9\" id=\"updateTournament\">Update Tournament</h4>" .
                "<button type=\"button\" class=\"close waves-effect waves-light\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                "<span aria-hidden=\"true\">&times;</span>" .
                "</button>" .
                "</div>" .

                "<div class=\"modal-body mb-0 mx-3\">" .
                "<form  method = \"POST\">" .
                "<div class=\"md-form form-sm row\">" .
                "<label for=\"tmname\" class=\"col-sm-4 control-label right-align\">Tournament Name</label>" .
                "<div class=\"col-sm-8\">" .
                "<input type=\"text\" class=\"form-control\" id=\"tmname$tm_id\" value=\"" . $row["Name"] . "\" placeholder=\"" . $row["Name"] . "\" required>" .
                "</div>" .
                "</div>" .
                "<br>" .
                "<div class=\"md-form form-sm row\">" .
                "<label for=\"description\" class=\"col-sm-4 control-label right-align\">Description</label>" .
                "<div class=\"col-sm-8\">" .
                "<textarea class=\"form-control\" id=\"desc$tm_id\"  rows=\"12\" value =\"" . $row["Descripton"] . "\" placeholder=\"" . $row["Descripton"] . "\">" . $row["Descripton"] . "</textarea>" .
                "</div>" .
                "<span class =\"offset-md-8\" id=\"spnCharLeft\"></span>" .
                "<br />" .
                "</div>" .

                "<div class=\"text-center mt-1-half\">" .
                "<br />" .
                "<button type=\"submit\" class=\"btn btn-secondary\" id=\"submit$id_number\" value = \"$tm_id\" onclick=\"updateTM(this.value);\" style=\"margin-left: 10px; margin-right: 10px;\">Create</button>" .
                "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" style=\"margin-left: 10px; margin-right: 10px;\">Cancel</button>" .
                "</div>" .
                "</form>" .
                "</div>" .
                "</div>" .
                "</div>" .
                "</div>";

                $id_number += 1;
            }
        } else {
                echo "0 results";
        }
} //end admin home

else {
            //not admin home page
        $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
        $current_ID = $db_handle_pending->getUserID($getUserID);
        $check_join = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
        $result1 = $db_handle_pending->getCount($check_join);
        if ($result1 > 0) {
            $sql = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID'";
            $result = $conn->query($sql);

            $id_number = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    $string = $row["StartDate"];
                    $timestamp = strtotime($string);
                    $tournamID = $row["TournamentID"];

                    $query_files = "SELECT file FROM tbl_uploads WHERE TournamentId='$tournamID'";
                    $current_image = $db_handle_pending->getImage($query_files);
                    echo
                    "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                    "<div class=\"card-body\">" .
                    "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                    "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .
                    "<img src= \"../uploads/$current_image\" class=\"img-thumbnail\" height=\"60%\" width=\"50%\" style= \"border:none\">" .
                    "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                    "</div>" .
                    "</div>" .

                    /****Could be delete** */
                    // Todo modal delet tournament.
                    "<div class=\"modal fade\" id=\"deleteModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deleteModal\" aria-hidden=\"true\">" .
                    "<div class=\"modal-dialog\" role=\"document\">" .
                    "<div class=\"modal-content\">" .
                    "<div class=\"modal-body\">" .
                    "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                    "<p><strong>YOU ARE ABOUT TO DELETE AN ENTIRE TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you delete this tournament." .
                    "</div>" .
                    "</div>" .
                    "<div class=\"modal-footer justify-content-center\">" .
                    "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                    "<button type=\"button\" class=\"btn btn-primary\"  style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                    "</div>" .
                    "</div>" .
                    "</div>" .
                    "</div>" .

                    // Todo modal update tournameng.
                    "<div class=\"modal fade\" id=\"updateModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"updateTournament\" aria-hidden=\"true\">" .
                    "<div class=\"modal-dialog\" role=\"document\">" .

                    "<div class=\"modal-content\">" .

                    "<div class=\"modal-header light-blue darken-3 white-text\">" .
                    "<h4 class=\"title col-sm-9\" id=\"updateTournament\">Update Tournament</h4>" .
                    "<button type=\"button\" class=\"close waves-effect waves-light\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                    "<span aria-hidden=\"true\">&times;</span>" .
                    "</button>" .

                    "</div>" .
                    "<div class=\"modal-body mb-0 mx-3\">" .
                    "<form action = \"createTM.php\" method = \"POST\">" .
                    "<div class=\"md-form form-sm row\">" .
                    "<label for=\"tmname\" class=\"col-sm-4 control-label right-align\">Tournament Name</label>" .
                    "<div class=\"col-sm-8\">" .
                    "<input type=\"text\" class=\"form-control\" id=\"tmname$id_number\" name=\"tmname\" placeholder=\"" . $row["Name"] . "\" required>" .
                    "</div>" .
                    "</div>" .
                    "<br>" .
                    "<div class=\"md-form form-sm row\">" .
                    "<label for=\"description\" class=\"col-sm-4 control-label right-align\">Description</label>" .
                    "<div class=\"col-sm-8\">" .
                    "<textarea class=\"form-control\" id=\"desc$id_number\" name=\"description\" rows=\"12\" placeholder=\"" . $row["Descripton"] . "\" required></textarea>" .
                    "</div>" .
                    "<span class =\"offset-md-8\" id=\"spnCharLeft\"></span>" .
                    "<br />" .
                    "</div>" .

                    "<div class=\"text-center mt-1-half\">" .
                    "<br />" .
                    "<button type=\"submit\" class=\"btn btn-secondary\" id=\"submit$id_number\" name=\"done\" style=\"margin-left: 10px; margin-right: 10px;\">Create</button>" .
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" style=\"margin-left: 10px; margin-right: 10px;\">Cancel</button>" .
                    "</div>" .
                    "</form>" .
                    
                    "</div>" .
                    "</div>" .
                    "</div>" .
                    "</div>";
                    /****Could be delete** */

                    $id_number += 1;
                }
            } else {
                 echo "0 results";
            }
        } else {
                echo "0 results";
        }
} //End Home Page For Non Admin
?>
    <!-- Agenda-->
    </div>
    <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
        <h3>UPCOMING MATCHES</h3>
        <div class="container">
            <p class="lead">Below are your upcoming matches!</p>
            <hr />
            <div class="agenda">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Event</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $check_Admin_agenda = "select Email from User where Email = \"$email\" and Admin = 1";
                        $count = $db_handle_pending->numRows($check_Admin_agenda);
                        if ($count > 0) {
                            $sql = "SELECT TournamentID, Name, Descripton, StartDate, EndDate FROM Tournament ORDER BY StartDate";
                            $result = $conn->query($sql);
                                //show all tounament approved & not approved
                                //ordered by start date
                            if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                            $string = $row["StartDate"];
                                            $timestamp = strtotime($string);
                                            echo
                                            "<tr>" .
                                             "<td class=\"agenda-date\" class=\"active\" rowspan=\"1\">" .
                                            "<div class=\"dayofmonth\">" . date("d", $timestamp) . "</div>" .
                                            "<div class=\"dayofweek\">" . date("D", $timestamp) . "</div>" .
                                            "<div class=\"shortdate text-muted\">" . date("F", $timestamp) . "," . date("Y", $timestamp) . "</div>" .
                                            "</td>" .
                                            "<td class=\"agenda-time\">" . date("h:i A", $timestamp) . "</td>" .
                                            "<td class=\"agenda-events\">" .
                                            "<div class=\"agenda-event\"> " .
                                            $row["Name"] . " " . $row["Descripton"] .
                                            "</div>" .
                                            "</td>" .
                                            "</tr>";
                                }
                            } else {
                                     echo "0 results";
                            }

                         } //end admin agenda

                         else { // not admin
                                //just show enrolled tounrnament in aganda
                                $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
                                $current_ID = $db_handle_pending->getUserID($getUserID);
                                $check_join2 = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
                                $result_agenda2 = $db_handle_pending->getCount($check_join2);

                            if ($result_agenda2 > 0) {
                                $sql = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID' ORDER BY StartDate";
                                $result = $conn->query($sql);

                                //ordered by start date
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                    $string = $row["StartDate"];
                                    $timestamp = strtotime($string);
                                    echo
                                    "<tr>" .
                                    "<td class=\"agenda-date\" class=\"active\" rowspan=\"1\">" .
                                    "<div class=\"dayofmonth\">" . date("d", $timestamp) . "</div>" .
                                    "<div class=\"dayofweek\">" . date("D", $timestamp) . "</div>" .
                                    "<div class=\"shortdate text-muted\">" . date("F", $timestamp) . "," . date("Y", $timestamp) . "</div>" .
                                    "</td>" .
                                    "<td class=\"agenda-time\">" . date("h:i A", $timestamp) . "</td>" .
                                     "<td class=\"agenda-events\">" .
                                    "<div class=\"agenda-event\"> " .
                                    $row["Name"] . " " . $row["Descripton"] .
                                    "</div>" .
                                    "</td>" .
                                    "</tr>";
                                }
                            } else {
                                 echo "0 results";
                            }
                            }
                    } // End Non Adim Agenda
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- End Agenda -->

<!-- Record Page -->
    <div class="tab-pane fade" id="records" role="tabpanel" aria-labelledby="records-tab">
        <h3>RECORDS</h3>
        <p>Below are your records for tournaments participated in.</p>
        <?php

    $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
    $current_ID = $db_handle_pending->getUserID($getUserID);
    $check_join2 = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
    $result1 = $db_handle_pending->getCount($check_join2);
if ($result1 > 0) {

    $sql = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID'";
    $result = $conn->query($sql);

    $id_number = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $string = $row["StartDate"];
            $timestamp = strtotime($string);
            $tournament_Name = $row["Name"];
            $touramentID = $row["TournamentID"];
            $result3 = "SELECT COUNT(TeamID) FROM Team WHERE TournamentID = '$touramentID'";
            $result4 = "SELECT TeamID FROM TeamMembers WHERE UserID = '$current_ID'";
            $user_teamID = $db_handle_pending->getUserTeamID($result4);
            $result5 = "SELECT TeamName FROM Team WHERE TeamID = '$user_teamID'";
            $user_TeamName = $db_handle_pending->getUserTeamName($result5);
            $row_count = $db_handle_pending->getCount($result3);
            $token = $db_handle_pending->generateNewString();
            $check_Admin_Records = "select Creator from Tournament where Creator = \"$email\" and TournamentID = $touramentID ";
            $count_Records = $db_handle_pending->numRows($check_Admin_Records);
            $nameS = ""; //start to generate the select - option menu on each bracket 
            for ($m = 1; $m < $row_count; $m++) {
                $nameS = $nameS . "<option>Team" . $m . "</option>"; //set up as a string
            }
            if ($count_Records > 0) {

                echo

                "<script>" .
                "$(document).on('ready', function() {" .
                "var teams, i;" .
                "teams = [\"\"];" .
                "for (i = 0; i < $row_count; i++) {" .
                "teams[i] = [\"Team\"+(i+1)];" .
                "var knownBrackets = [2,4,8,16,32]," . // brackets with "perfect" proportions (full fields, no byes)

                "  exampleTeams  = (teams)," .

                "  bracketCount = 0;" .
                /*
                 * Build our bracket "model"
                 */
                "}" .

                "function getBracket(base) {" .

                "  var closest 	= _.find(knownBrackets, function(k) { return k>=base; })," .
                "  byes 		= closest-base;" .

                "  if(byes>0)	base = closest;" .

                "var brackets 	= []," .
                    "round 		= 1," .
                    "baseT 		= base/2," .
                    "baseC 		= base/2," .
                    "teamMark	= 0," .
                    "nextInc		= base/2;" .

                "for(i=1;i<=(base-1);i++) {" .
                    " var k =i;" .
                    "var	baseR = i/baseT," .
                    "isBye = false;" .

                    "if(byes>0 && (i%2!=0 || byes>=(baseT-i))) {" .
                        "isBye = true;" .
                         "byes--;" .
                     "}" .

                    "var last = _.map(_.filter(brackets, function(b) { return b.nextGame == i; })," .
                     "function(b) { return {game:b.bracketNo,teams:b.teamnames}; });" .

                    "brackets.push({" .
                        "lastGames:	round==1 ? null : [last[0].game,last[1].game]," .
                        "nextGame:	nextInc+i>base-1?null:nextInc+i," .
                        "teamnames:	round==1 ? [exampleTeams[teamMark],exampleTeams[teamMark+1]] : [last[0].teams[_.random(1)],last[1].teams[_.random(1)]]," .
                        "bracketNo:	i," .
                        "nameNum: k," .
                         "roundNo:	round," .
                         "bye:		isBye });" .

                    "teamMark+=2;" .
                        "if(i%2!=0)	nextInc--;" .
                            "while(baseR>=1) {" .
                            "round++;" .
                            "baseC/= 2;" .
                            "baseT = baseT + baseC;" .
                            "baseR = i/baseT;" .
                        "}" .

                "}" .

                "renderBrackets(brackets);" .
                "}" . // End GetBracket Function

                /*
                 * Inject our brackets
                 */
                "function renderBrackets(struct) {" .
                "var num1,num2;" .
                "var groupCount	= _.uniq(_.map(struct, function(s) { return s.roundNo; })).length;" .
                "var lastm = (groupCount +1)/2;" .
                "var group	= $('<div class=\"group'+(groupCount+1)+'\" id=\"b'+bracketCount+'\"></div>')," .
                "grouped = _.groupBy(struct, function(s) { return s.roundNo; });" .

                "for(g=1;g<=groupCount;g++) {" .

                "var round = $('<div class=\"r'+g+'\"></div>');" .
                "_.each(grouped[g], function(gg) {" .
                "if(gg.bye){" .
                "round.append('<div></div>');}" .
                "else if(g==1 || g<=groupCount/2){" . //append the matches - first round
                "round.append('<div><div class=\"bracketbox\"><span class=\"info\">'+gg.bracketNo+'</span><span class=\"teama\">'+gg.teamnames[0]+'</span><span class=\"teamb\">'+gg.teamnames[1]+'</span></div></div>');" .
                "}" .
                "else {" .
                    //get unique name for each matches
                "num1 = gg.nameNum-lastm-2;" .
                "num2 = gg.nameNum - lastm +1-2;" .
                "lastm--;" .
                         //append other rounds based on  hoe many teams
                "round.append('<div><div class=\"bracketbox\"><span class=\"info\">'+gg.bracketNo+'</span><span class=\"teama\">'+'<select name = \"tm' + num1 +'\" value=\"????\">' +'<option>- select - </option>' + '$nameS'+'</select>'+'</span><span class=\"teamb\">'+'<select name= \"tm' +num2+ '\"   value=\"????\" >'+'<option>- select - </option>'+'$nameS'+'</select>'+'</span></div></div>');" .
                "}" .

                "});" .

                    "group.append(round);" .
                    "}" .
                    "group.append('<div class=\"r'+(groupCount+1)+'\"><div class=\"final\"><div class=\"bracketbox\"><span class=\"teamc\">'+'<select name=\"final\" value=\"????\">'+'<option>- select - </option>'+'$nameS' +'</select></span></div></div></div>');" .
                    "$('#$token').append(group);" . //append to DOM

                    "bracketCount++;" .
                    "$('html,body').animate({" .
                    "scrollTop: $(\"#b\"+(bracketCount-1)).offset().top })" .
                    "}" .

                    "var opts = ($row_count);" .

                    "if(!_.isNaN(opts) && opts <= _.last(knownBrackets))" .
                    "getBracket(opts);" .
                    "else
                  alert('The bracket size you specified is not currently supported.');" .

                    "});" . //End Document.on.Ready Function

                    "</script>"; // End JS

                  // Show Brackets with Team Name and Select menue
                echo
                "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                "<div class=\"card-body\">" .
                "<form  action= \"edit_tournament.php\" method=\"POST\">" .
                "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .
                "<div class=\"brackets\" id=\"$token\">" .//place to insert each bracket
                "</div>" .
                "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                "<input  name=\"GameID\" type=\"hidden\" value = \"$touramentID\">".
                "<input type=\"submit\" class=\"btn btn-secondary\" value = \"Update\" name=\"GameRecord\' style=\"margin-left: 10px; margin-right: 10px;\" />".
                "</form>".

                    "</div>" .
                    "</div>";
                    //end tournament creator record page
            } else {
                echo
                    //other members' record page
                    //without select - option menu
                "<script>" .
                "$(document).on('ready', function() {" .
                "var teams, i;" .
                "teams = [\"\"];" .
                "for (i = 0; i < $row_count; i++) {" .
                "teams[i] = [\"Team\"+(i+1)];" .
                "var knownBrackets = [2,4,8,16,32]," . // brackets with "perfect" proportions (full fields, no byes)

                "  exampleTeams  = (teams)," .

                "  bracketCount = 0;" .
                /*
                 * Build our bracket "model"
                 */
                "}" .
                "function getBracket(base) {" .

                "  var closest 		= _.find(knownBrackets, function(k) { return k>=base; })," .
                "  byes 			= closest-base;" .

                "  if(byes>0)	base = closest;" .

                "var brackets 	= []," .
                "round 		= 1," .
                "baseT 		= base/2," .
                "baseC 		= base/2," .
                "teamMark	= 0," .
                "nextInc		= base/2;" .

                "for(i=1;i<=(base-1);i++) {" .
                " var k =i;" .
                "var	baseR = i/baseT," .
                "isBye = false;" .

                "if(byes>0 && (i%2!=0 || byes>=(baseT-i))) {" .
                "isBye = true;" .
                "byes--;" .
                "}" .

                "var last = _.map(_.filter(brackets, function(b) { return b.nextGame == i; })," .
                "function(b) { return {game:b.bracketNo,teams:b.teamnames}; });" .

                "brackets.push({" .
                "lastGames:	round==1 ? null : [last[0].game,last[1].game]," .
                "nextGame:	nextInc+i>base-1?null:nextInc+i," .
                "teamnames:	round==1 ? [exampleTeams[teamMark],exampleTeams[teamMark+1]] : [last[0].teams[_.random(1)],last[1].teams[_.random(1)]]," .
                "bracketNo:	i," .
                "nameNum: k," .
                "roundNo:	round," .
                "bye:		isBye });" .
                "teamMark+=2;" .
                "if(i%2!=0)	nextInc--;" .
                "while(baseR>=1) {" .
                "round++;" .
                "baseC/= 2;" .
                "baseT = baseT + baseC;" .
                "baseR = i/baseT;" .
                "}" .
                "}" .

                "renderBrackets(brackets);" .
                "}" .

                /*
                 * Inject our brackets
                 */
                "function renderBrackets(struct) {" .
                    "var num1,num2;".

                "var groupCount	= _.uniq(_.map(struct, function(s) { return s.roundNo; })).length;" .
                 "var lastm = (groupCount +1)/2;".
                "var group	= $('<div class=\"group'+(groupCount+1)+'\" id=\"b'+bracketCount+'\"></div>')," .
                "grouped = _.groupBy(struct, function(s) { return s.roundNo; });" .

                "for(g=1;g<=groupCount;g++) {" .

                "var round = $('<div class=\"r'+g+'\"></div>');" .
                "_.each(grouped[g], function(gg) {" .
                "if(gg.bye){" .
                "round.append('<div></div>');}" .
                "else if(g==1 || g<=groupCount/2){" .
                "round.append('<div><div class=\"bracketbox\"><span class=\"info\">'+gg.bracketNo+'</span><span class=\"teama\">'+gg.teamnames[0]+'</span><span class=\"teamb\">'+gg.teamnames[1]+'</span></div></div>');" .
                "}" .
                "else {" . 
                "num1 = (gg.nameNum-lastm-2);" .
                "num2 = (gg.nameNum-lastm+1-2);" .
                "lastm--;" .
                "round.append('<div><div class=\"bracketbox\"><span class=\"info\">'+gg.bracketNo+'</span><span class=\"teama\">'+' '+'</span><span class=\"teamb\">'+' '+'</span></div></div>');" .
                //"num1++;".
                "}" .

                "});" .

                    "group.append(round);" .
                    "}" .
                    "group.append('<div class=\"r'+(groupCount+1)+'\"><div class=\"final\"><div class=\"bracketbox\"><span class=\"teamc\">'+''+'</span></div></div></div>');" .
                    "$('#$token').append(group);" . //append to DOM

                    "bracketCount++;" .
                    "$('html,body').animate({" .
                    "scrollTop: $(\"#b\"+(bracketCount-1)).offset().top })" .
                    "}" .

                    "var opts = ($row_count);" .

                    "if(!_.isNaN(opts) && opts <= _.last(knownBrackets))" .
                    "getBracket(opts);" .
                    "else
                  alert('The bracket size you specified is not currently supported.');" .

                    "});" . //end document on rady function
                    "</script>";
                echo
                "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                "<div class=\"card-body\">" .
                "<form  action= \"edit_tournament.php\" method=\"POST\">" .
                "<div class=\"row justify-content-center\">" .
                "<div class=\"col align-self-center\">" .
                "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                "</div>" .
                "<div class=\"col align-self-end\">" .
                "Your Team: " . $user_TeamName .

                "</div>" .

                "</div>" .
                "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .
                    "<div class=\"brackets\" id=\"$token\">" .
                    "</div>" .
                    "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                    "</div>" .
                    "</div>";

            }

        }
    } else {
        echo "0 results";
    }
} else {
    echo "0 results";
}
?>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h3>Profile</h3>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title m-t-10"><?php echo $userArray["first"] . " " . $userArray["last"]; ?></h4>
                                <h6 class="card-subtitle"><?php echo $userArray["email"]; ?></h6>
                                <div class="row text-center justify-content-md-center">
                                </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal form-material">
                                    <div class="form-group">
                                        <label class="col-md-12">First Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder=<?php echo $userArray["first"]; ?> class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder=<?php echo $userArray["last"]; ?> class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" value="password" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

        </div>
    </div>

    <!-- pending tournament section -->

     <!-- Only shoe Pending on Admin Page -->

    <div class="tab-pane fade " id="Pending" role="tabpanel" aria-labelledby="profile-tab">
        <h3>Pending Tournament</h3>
        <?php
            /*get values from tables*/
            $sql2 = "SELECT TournamentID, Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 0";
            $results2 = $conn->query($sql2);

            $id_numbers = 1;
            /*if the values from the table*/
            if ($results2->num_rows > 0) {
              /*repeat the same operation for every values*/
              while ($row = $results2->fetch_assoc()) {
                $strings = $row["StartDate"];
                $timestamps = strtotime($strings);
                $current_tms = $row["TournamentID"];
                $query_file2 = "SELECT file FROM tbl_uploads WHERE TournamentId='$current_tms'";
                $current_image_Pending = $db_handle_pending->getImage($query_file2);
                /*Show every tournament that haven't been approved*/
                 echo
                  "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                  "<div class=\"card-body\">" .
                  "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                  "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamps) . "</h6>" .
                  "<img src= \"../uploads/$current_image_Pending\" class=\"img-thumbnail\" style= \"border:none;\">" .
                  "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                  "<button type=\"button\" class=\"btn btn-primary\" style=\"background-color: green; border-color: transparent; margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#approveModal" . $row["TournamentID"] . "\">APPROVE</button>" .
                  "<button type=\"button\" class=\"btn btn-primary\" style=\"background-color: red; border-color: transparent; amargin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#denyModal" . $row["TournamentID"] . "\">DENY</button>" .
                  "</div>" .
                  "</div>" .

                  // Modal to Approve a tournament.
                  "<div class=\"modal fade\" id=\"approveModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"approveModal\" aria-hidden=\"true\">" .
                  "<div class=\"modal-dialog\" role=\"document\">" .
                  "<div class=\"modal-content\">" .
                  "<div class=\"modal-header\">" .
                  "<h5 class=\"modal-title\" id=\"approveModal\">Approve " . $row["Name"] . "</h5>" .
                  "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                  "<span aria-hidden=\"true\">&times;</span>" .
                  "</button>" .
                  "</div>" .

                  "<div class=\"modal-body\">" .
                  "<form method=\"POST\">" .
                  "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                  "<p><strong>YOU ARE ABOUT TO APPROVE A TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you approve this tournament." .
                  "</div>" .
                  "</div>" .

                  "<div class=\"modal-footer justify-content-center\">" .
                  "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                  "<button type=\"submit\" value = \"$current_tms\" onclick=\"trans_Approve(this.value);\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                  "</div>" .
                  "</form>" .
                  "</div>" .
                  "</div>" .
                  "</div>" .
                  // Modal to Deny a tournament.
                  "<div class=\"modal fade\" id=\"denyModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"denyModal\" aria-hidden=\"true\">" .
                  "<div class=\"modal-dialog\" role=\"document\">" .
                  "<div class=\"modal-content\">" .
                  "<div class=\"modal-header\">" .
                  "<h5 class=\"modal-title\" id=\"denyModal\">Deny " . $row["Name"] . "</h5>" .
                  "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                  "<span aria-hidden=\"true\">&times;</span>" .
                  "</button>" .
                  "</div>" .
                  "<div class=\"modal-body\">" .
                  "<form method=\"POST\">" .
                  "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                  "<p><strong>YOU ARE ABOUT TO DENY A TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you deny this tournament." .
                  "</div>" .
                  "<div class=\"md-form form-sm row\">" .
                  "<label for=\"denyReason\" class=\"col-sm-4 control-label right-align\">Deny Reason</label>" .
                  "<div class=\"col-sm-8\">" .
                  "<textarea class=\"form-control\" id=\"denyreason" . $current_tms . "\" name=\"denyReason\" rows=\"12\" placeholder=\"Enter Reason Why Deny\" required></textarea>" .
                  "</div>" .
                  "<span class =\"offset-md-8\" id=\"spnCharLeft\"></span>" .
                  "<br />" .
                  "</div>" .
                  "</div>" .
                  "<div class=\"modal-footer justify-content-center\">" .
                  "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                  "<button type=\"submit\" value = \"$current_tms\" onclick=\"trans_Deny(this . value);\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                  "</div>".
                  "</form>".
                  "</div>".
                   "</div>".
                    "</div>";
                }
            } else {
                         echo "0 results";
                    }
        ?>
    </div>
</div>
<!-- end of pending tournament -->

<!--Join Tournament Modal-->
<!--Begin Modal-->
<div class="modal fade" id="modalEnrollForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="background-color:#b6a16b;">
                <h4 class="modal-title w-100 font-bold">Enroll</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-3">

            <form action="joinTournament.php" method = "POST">
                    <div class="form-group">
                        <label for = "TMname"> Select A Tournament</label>
                        <select name = "TMname" id = "TMname" class="form-control" onchange="fetch_team(this.value);">
                            <!-- Fetch Approved Tournaments -->
                            <?php
                                    echo '<option value="0" > - select -</option>';
                                    $dt = new DateTime();
                                    $current = $dt->format('Y-m-d H:i:s');
                                    $result = $conn->query("select TournamentID,Name,StartDate from Tournament where Approved = '1' ");
                                    while ($row = $result->fetch_assoc()) {
                                        $teamID = $row["TournamentID"];
                                        $name = $row['Name'];
                                        $sDate = $row['StartDate'];
                                    if (strtotime($current) < strtotime($sDate)) {
                                        echo '<option value="' . $teamID . '">' . $name . '</option>';
                                     }
                                    }
                            ?>
                        </select>

                        <div id="new_select">
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-primary btn-lg btn-dark" type="submit">Join</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<!--End Modal-->

<!-- create tournament modal -->
<!--Begin Modal-->
<div class="modal fade" id="createTournament" tabindex="-1" role="dialog" aria-labelledby="createTournament" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header light-blue darken-3 white-text">
                <h4 class="title col-sm-9" id="createTournament">Create Tournament</h4>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body mb-0 mx-3">
                <form action = "createTM.php" method = "POST" enctype="multipart/form-data">
                <div class="md-form form-sm row">
                        <!-- Tournament Name -->
                    <label for="tmname" class="col-sm-4 control-label right-align">Tournament Name</label>
                    </br>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="tmname" name="tmname" placeholder="Enter Tounrnament Name" required>
                    </div>
                </div>
                        <!-- Tournament Picture -->
                <div class="md-form form-sm row">
                    <label for="tmname" class="col-sm-4 control-label right-align">Upload Tournament Picture</label>
                    <div class="col-sm-8">
                      <input type="file" name="file" / required>

                        <?php

                        if (isset($_GET['success'])) {
                        ?>
                          <label>File Uploaded Successfully...  </label>
                          <?php
                        } else if (isset($_GET['fail'])) {
                        ?>
                          <label>Problem While File Uploading !</label>
                          <?php
                        } else {
                        ?>
                          <label>Try to upload any files(PDF, DOC, EXE, VIDEO, MP3, ZIP,etc...)</label>
                          <?php
                        }
                        ?>
                    </div>
                </div>

                <br>
                         <!-- Start Date -->
                <div class="md-form form-sm row">
                    <label for="StartDate" class="col-sm-4 control-label right-align">Start Date</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group date" id="StartDate"  data-target-input="nearest">
                                <input type="text" name = "StartDate" class="form-control datetimepicker-input" data-target="#StartDate" />
                                <div class="input-group-append" data-target="#StartDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                <!-- End Date -->
                <div class="md-form form-sm row">
                    <label for="EndDate" class="col-sm-4 control-label right-align">End Date</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group date" id="EndDate"data-target-input="nearest">
                                <input type="text" name = "EndDate"  class="form-control datetimepicker-input" data-target="#EndDate" />
                                <div class="input-group-append" data-target="#EndDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                            <!-- Game Type -->
                <div class="md-form form-sm row">
                    <label for="gType" class="col-sm-4 control-label">Game Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="gType" name="gType" >
                            <option value = "Individual">Individual</option>
                            <option value = "Team">Team</option>
                            <br />
                        </select>
                                <!--Team Type, only show when choose Team Type -->
                         <div class ="teamType">
                            <div id="selectteam" style="display:none">
                                <div class="md-form form-sm row">
                                    <label for="teamSize" class="col-sm-6 control-label right-align">Maximum Team Size (Members)</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="2" step="1" class="form-control" id="teamSize" name="teamSize" value="2">
                                    </div>
                                    <br />
                                </div>
                            </div>

                            <div id="numteam" style="display:none">
                                <div class="md-form form-sm row">
                                    <label for="teamNumber" class="col-sm-6 control-label right-align">Number of Teams</label>
                                    <div class="col-sm-6">
                                        <select name = "teamNumber" id = "teamNumber" class="form-control">
                                          <option>2</option>
                                          <option>4</option>
                                          <option>8</option>
                                          <option>16</option>
                                          <option>32</option>
                                        </select>
                                    </div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <br />
                    </div>
                </div>

                                <!-- Description -->
                <div class="md-form form-sm row">
                    <label for="description" class="col-sm-4 control-label right-align">Description</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="description" name="description" rows="12" required></textarea>
                    </div>
                    <span class ="offset-md-8" id="spnCharLeft"></span>
                    <br />
                </div>

                            <!-- Buttons-->

                <div class="text-center mt-1-half">
                    <br />
                    <button type="submit" class="btn btn-secondary" id="submit" name="done" >Create</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!--Contact Support Modal-->
<!--Begin Modal-->
<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="contactSupportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="background-color:#b6a16b;">
                <h4 class="modal-title w-100 font-bold">Contact Support</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-3">
                <form method="post" name="myemailform" action="form-to-email.php">
                    <div class="form-group">
                        <label for="name">Name</label> <br/> </br>
                        <input type="text" class="form-control" name="name "placeholder="Enter Your Name">
                        <label for="description">Issue Description</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter Your Issue">
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <input class="btn btn-primary btn-lg btn-dark" type="submit">
                        <button class="btn btn-primary btn-lg btn-dark" type="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->

    <!--  JavaScript --> <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
         integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <!-- <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script> -->
    <script src="http://underscorejs.org/underscore-min.js"></script>
    <script src="../js/createtournament.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src = "../js/tempusdominus-bootstrap-4.min.js"></script>

</body>

<footer id="footer" class="footer navbar-fixed-bottom">
    <div> &copy; Rock Lee Development @ Lindenwood Library Services: Media Library </div>
</footer>

</html>

<?php $conn->close();?>
