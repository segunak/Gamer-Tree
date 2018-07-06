<?php
/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 4/4/2018
 * Time: 5:59 PM
 */
session_start();

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

    <html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="../images/Logo.svg">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="../css/custom.css" rel="stylesheet">

        <link href="../css/glyphicons.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
              rel="stylesheet">
        <link href="../css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

        <title>Gamer Tree</title>

        <nav class="navbar navbar-expand-lg navbar-dark" style="color: black;">
            <a class="navbar-brand" id="lu-title-text" href="index.php">Lindenwood</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#modalEnrollForm">Join
                        Tournament</a>
                    <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#createTournament">Create
                        Tournament</a>
                    <a class="nav-item nav-link" href="#" data-toggle="modal"
                       data-target="#modalContactForm">Support</a>
                </div>
            </div>
        </nav>

        <ul class="nav sticky-top nav-tabs nav-fill navbar-dark" id="myTab" role="tablist"
            style="background-color: #b6a16b">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true" style="color: black;">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda"
                   aria-selected="false" style="color: black;">Agenda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="records-tab" data-toggle="tab" href="#records" role="tab"
                   aria-controls="records" aria-selected="false" style="color: black;">Records</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="false" style="color: black;">Profile</a>
            </li>
            <?php
            require_once("DBController.php");
            $db_handle = new DBController();
            $check_Admin = "select Email from User where Email = \"$email\" and Admin = 1";
            $count = $db_handle->numRows($check_Admin);
            if ($count > 0) {
                echo
                    "<li class=\"nav-item\">" .
                    "<a class=\"nav-link\" id=\"profile-tab\" data-toggle=\"tab\" href=\"#Pending\" role=\"tab\" aria-controls=\"profile\" aria-selected=\"false\" style=\"color: black; background-color: red;\">Pendings</a>" .
                    "</li>";

            }
            ?>
        </ul>
    </head>

<body>
<div class="tab-content text-center" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3>HOME</h3>
        <?php
        require_once("DBController.php");
        $db_handle = new DBController();
        $check_Admin1 = "select Email from User where Email = \"$email\" and Admin = 1";
        $count1 = $db_handle->numRows($check_Admin1);
        if ($count1 > 0) {
            $sql = "SELECT TournamentID, Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 1";
            $result = $conn->query($sql);

            $id_number = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $string = $row["StartDate"];
                    $timestamp = strtotime($string);
                    $tm_id = $row["TournamentID"];
                    echo
                        "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                        "<div class=\"card-body\">" .
                        "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                        "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .
                        "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                        "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#deleteModal" . $row["TournamentID"] . "\">DELETE</button>" .
                        "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#updateModal" . $row["TournamentID"] . "\">UPDATE</button>" .
                        "</div>" .
                        "</div>" .

                        // Todo modal description.
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
                        "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                        "<p><strong>YOU ARE ABOUT TO DELETE AN ENTIRE TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you delete this tournament." .
                        "</div>" .
                        "</div>" .
                        "<div class=\"modal-footer justify-content-center\">" .
                        "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                        "<button type=\"submit\" value = \"submit$tm_id\"  onclick=\"deleteTM(this . value);\"  class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                        "</div>" .
                        "</div>" .
                        "</div>" .
                        "</div>" .

                        // Todo modal description.
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

                    $id_number += 1;
                }
            } else {
                echo "0 results";
            }
        }//end admin home
        else {
            //not admin
            $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
            $current_ID = $db_handle->getUserID($getUserID);
            $check_join = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
            $result1 = $db_handle->getCount($check_join);
            if ($result1 > 0) {

                $sql = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID'";
                $result = $conn->query($sql);

                $id_number = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                        $string = $row["StartDate"];
                        $timestamp = strtotime($string);

                        echo
                            "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                            "<div class=\"card-body\">" .
                            "<h5 class=\"card-title\">" . $row["Name"] . "</h5>" .
                            "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamp) . "</h6>" .
                            "<p class=\"card-text\">" . $row["Descripton"] . "</p>" .
                            /*"<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#deleteModal".$row["TournamentID"]."\">DELETE</button>".
                            "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#updateModal".$row["TournamentID"]."\">UPDATE</button>".*/
                            "</div>" .
                            "</div>" .

                            // Todo modal description.
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
                            "<button type=\"submit\" value = \"submit$tm_id\"  onclick=\"delet_tm(this.value);\" class=\"btn btn-primary\"  style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                            "</div>" .
                            "</div>" .
                            "</div>" .
                            "</div>" .

                            // Todo modal description.
                            "<div class=\"modal fade\" id=\"updateModal" . $row["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"updateTournament\" aria-hidden=\"true\">" .
                            "<div class=\"modal-dialog\" role=\"document\">" .
                            "<div class=\"modal-content\">" .
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

                        $id_number += 1;
                    }
                } else {
                    echo "0 results";
                }
            } else {
                echo "0 results";
            }
        }
        ?>
    </div>
    <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
    <h3>UPCOMING MATCHES</h3>
    <div class="container">
    <p class="lead">Below are your upcoming matches!</p>

    <hr/>

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

//check admin
require_once("DBController.php");
$db_handle = new DBController();
$check_Admin = "select Email from User where Email = \"$email\" and Admin = 1";
$count = $db_handle->numRows($check_Admin);
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
else {
    $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
    $current_ID = $db_handle->getUserID($getUserID);
    $check_join = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
    $result1 = $db_handle->getCount($check_join);

    if ($result1 > 0) {
        //$sql = "SELECT Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 1";
        $sql = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID' ORDER BY StartDate";
        $result = $conn->query($sql);

        //ordered by start date
        //$result = $conn->query($sql);

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
    }

            $getUserID = " SELECT UserID FROM User WHERE email = '$email'";
            $current_ID = $db_handle->getUserID($getUserID);
            $check_join_Agenda = "SELECT COUNT(*) FROM UserTournaments WHERE UserID = '$current_ID'";
            $result_Agenda = $db_handle->getCount($check_join_Agenda);

            if ($result_Agenda > 0) {
                //$sql = "SELECT Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 1";
                $sql_Agenda = "SELECT UserTournaments.TournamentID ,Name, Descripton, StartDate, EndDate FROM Tournament INNER JOIN UserTournaments ON UserTournaments.TournamentID = Tournament.TournamentID  WHERE UserTournaments.UserID = '$current_ID' ORDER BY StartDate";
                $result_Agenda = $conn->query($sql_Agenda);

                if ($result_Agenda->num_rows > 0) {
                    while ($row_Agenda = $result_Agenda->fetch_assoc()) {
                        $string_Agenda = $row["StartDate"];
                        $timestamp_Agenda = strtotime($string_Agenda);
                        echo
                            "<tr>" .
                            "<td class=\"agenda-date\" class=\"active\" rowspan=\"1\">" .
                            "<div class=\"dayofmonth\">" . date("d", $timestamp_Agenda) . "</div>" .
                            "<div class=\"dayofweek\">" . date("D", $timestamp_Agenda) . "</div>" .
                            "<div class=\"shortdate text-muted\">" . date("F", $timestamp_Agenda) . "," . date("Y", $timestamp_Agenda) . "</div>" .
                            "</td>" .
                            "<td class=\"agenda-time\">" . date("h:i A", $timestamp_Agenda) . "</td>" .
                            "<td class=\"agenda-events\">" .
                            "<div class=\"agenda-event\"> " .
                            $row_Agenda["Name"] . " " . $row_Agenda["Descripton"] .
                            "</div>" .
                            "</td>" .
                            "</tr>";

                    }
                } else {
                    echo "no agenda";
                }
            } //end not admin agenda
        ?>
        </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>

        <div class="tab-pane fade" id="records" role="tabpanel" aria-labelledby="records-tab">
            <h3>RECORDS</h3>
            <p>Below are your records for tournaments participated in.</p>
            <?php
            $tNum = 1;
            $sql = "SELECT TournamentID, Name, Descripton FROM Tournament WHERE Approved = 1";//AND EndDate < current_date()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ID = $row["TournamentID"];
                    $name = $row["Name"];
                    $descrip = $row["Descripton"];


                    $sql2 = "SELECT TeamName FROM Team"; //WHERE TournamentID = $ID";
                    $result2 = $conn->query($sql2);

                    $teamNum = $result2->num_rows;
                    $teamArray = array();
                    while ($row = mysqli_fetch_array($result2)) {
                        // Append to the array
                        $teamArray[] = $row['TeamName'];
                    }

                    $team_array = json_encode($teamArray);

                    echo
                        "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                        "<div class=\"card-body\">" .
                        "<h5 class=\"card-title\">" . $name . "</h5>" .
                        "<p class=\"card-text\">" . $descrip . "</p>" .

                        '<script type="text/javascript">',
                        "getBracket($teamNum,$team_array);" .
                        "</script>" .
                        '<div class="brackets" id="brackets">',

                        "</div>" .
                        "</div>" .
                        "</div>";

                    $tNum += 1;

                }
            } else {
                echo "No records found";
            } ?>

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
                                                <input type="text"
                                                       placeholder=<?php echo $userArray["first"]; ?> class="form-control
                                                       form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Last Name</label>
                                            <div class="col-md-12">
                                                <input type="text"
                                                       placeholder=<?php echo $userArray["last"]; ?> class="form-control
                                                       form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Password</label>
                                            <div class="col-md-12">
                                                <input type="password" value="password"
                                                       class="form-control form-control-line">
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
        <div class="tab-pane fade" id="Pending" role="tabpanel" aria-labelledby="profile-tab">
            <h3>Pending Tournament</h3>
            <?php
            $sql2 = "SELECT TournamentID, Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 0";
            $results = $conn->query($sql2);

            $id_numbers = 1;
            if ($result2->num_rows > 0) {
                while ($rows = $results->fetch_assoc()) {
                    $strings = $rows["StartDate"];
                    $timestamps = strtotime($strings);
                    echo
                        "<div class=\"card top-buffer mx-auto\" style=\"width: 55vmax;\">" .
                        "<div class=\"card-body\">" .
                        "<h5 class=\"card-title\">" . $rows["Name"] . "</h5>" .
                        "<h6 class=\"card-subtitle mb-2 text-muted\">" . date("l jS \of F Y", $timestamps) . "</h6>" .
                        "<p class=\"card-text\">" . $rows["Descripton"] . "</p>" .
                        "<button type=\"button\" class=\"btn btn-primary\" style=\"background-color: green; border-color: transparent; margin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#deleteModals" . $row["TournamentID"] . "\">APPROVE</button>" .
                        "<button type=\"button\" class=\"btn btn-primary\" style=\"background-color: red; border-color: transparent; amargin-left: 10px; margin-right: 10px;\" data-toggle=\"modal\" data-target=\"#updateModal" . $row["TournamentID"] . "\">DENY</button>" .
                        "</div>" .
                        "</div>" .

                        // Todo modal description.
                        "<div class=\"modal fade\" id=\"deleteModals" . $rows["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deleteModals\" aria-hidden=\"true\">" .
                        "<div class=\"modal-dialog\" role=\"document\">" .
                        "<div class=\"modal-content\">" .
                        "<div class=\"modal-header\">" .
                        "<h5 class=\"modal-title\" id=\"deleteModals\">Delete " . $rows["Name"] . "</h5>" .
                        "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" .
                        "<span aria-hidden=\"true\">&times;</span>" .
                        "</button>" .
                        "</div>" .
                        "<div class=\"modal-body\">" .
                        "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">" .
                        "<p><strong>YOU ARE ABOUT TO DELETE AN ENTIRE TOURNAMENT!</strong></p> Please be certain this is the course of action you wish to take before you delete this tournament." .
                        "</div>" .
                        "</div>" .
                        "<div class=\"modal-footer justify-content-center\">" .
                        "<button type=\"button\" class=\"btn btn-secondary\" style=\"margin-left: 10px; margin-right: 10px;\" data-dismiss=\"modal\">Close</button>" .
                        "<button type=\"button\" class=\"btn btn-primary\" style=\"margin-left: 10px; margin-right: 10px;\">Save changes</button>" .
                        "</div>" .
                        "</div>" .
                        "</div>" .
                        "</div>" .

                        // Todo modal description.
                        "<div class=\"modal fade\" id=\"updateModal" . $rows["TournamentID"] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"updateTournament\" aria-hidden=\"true\">" .
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
                        "<input type=\"text\" class=\"form-control\" id=\"tmname$id_numbers\" name=\"tmname\" placeholder=\"" . $rows["Name"] . "\" required>" .
                        "</div>" .
                        "</div>" .
                        "<br>" .
                        "<div class=\"md-form form-sm row\">" .
                        "<label for=\"description\" class=\"col-sm-4 control-label right-align\">Description</label>" .
                        "<div class=\"col-sm-8\">" .
                        "<textarea class=\"form-control\" id=\"desc$id_numbers\" name=\"description\" rows=\"12\" placeholder=\"" . $rows["Descripton"] . "\" required></textarea>" .
                        "</div>" .
                        "<span class =\"offset-md-8\" id=\"spnCharLeft\"></span>" .
                        "<br />" .
                        "</div>" .


                        "<div class=\"text-center mt-1-half\">" .
                        "<br />" .
                        "<button type=\"submit\" class=\"btn btn-secondary\" id=\"submit$id_numbers\" name=\"done\" style=\"margin-left: 10px; margin-right: 10px;\">Create</button>" .
                        "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" style=\"margin-left: 10px; margin-right: 10px;\">Cancel</button>" .
                        "</div>" .
                        "</form>" .
                        "</div>" .
                        "</div>" .
                        "</div>" .
                        "</div>";

                    $id_numbers += 1;
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>

        </div>

        <!--Join Tournament Modal-->
        <!--Begin Modal-->
        <div class="modal fade" id="modalEnrollForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center" style="background-color:#b6a16b;">
                        <h4 class="modal-title w-100 font-bold">Enroll</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body mx-3">


                        <form action="joinTournament.php" method="POST">

                            <div class="form-group">
                                <label for="TMname"> Select A Tournament</label>
                                <select name="TMname" id="TMname" onchange="fetch_team(this.value);">
                                    <?php
                                    $result = $conn->query("select TournamentID,Name from Tournament where Approved = '1' ");
                                    while ($row = $result->fetch_assoc()) {
                                        $teamID = $row["TournamentID"];
                                        $name = $row['Name'];
                                        echo '<option value="' . $teamID . '">' . $name . '</option>';
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
        <div class="modal fade" id="createTournament" tabindex="-1" role="dialog" aria-labelledby="createTournament"
             aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class="title col-sm-9" id="createTournament">Create Tournament</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body mb-0 mx-3">
                        <form action="createTM.php" method="POST">
                            <div class="md-form form-sm row">
                                <label for="tmname" class="col-sm-4 control-label right-align">Tournament
                                    Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="tmname" name="tmname"
                                           placeholder="Enter Tounrnament Name" required>
                                </div>
                            </div>
                            <br>
                            <div class="md-form form-sm row">
                                <label for="StartDate" class="col-sm-4 control-label right-align">Start Date</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="StartDate" data-target-input="nearest">
                                            <input type="text" name="StartDate"
                                                   class="form-control datetimepicker-input"
                                                   data-target="#StartDate"/>
                                            <div class="input-group-append" data-target="#StartDate"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md-form form-sm row">
                                <label for="EndDate" class="col-sm-4 control-label right-align">End Date</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="EndDate" data-target-input="nearest">
                                            <input type="text" name="EndDate"
                                                   class="form-control datetimepicker-input"
                                                   data-target="#EndDate"/>
                                            <div class="input-group-append" data-target="#EndDate"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md-form form-sm row">
                                <label for="gType" class="col-sm-4 control-label">Game Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="gType" name="gType">
                                        <option value="Individual">Individual</option>
                                        <option value="Team">Team</option>
                                        <br/>
                                    </select>

                                    <div class="teamType">
                                        <div id="selectteam" style="display:none">
                                            <div class="md-form form-sm row">
                                                <label for="teamSize" class="col-sm-6 control-label right-align">Team
                                                    Size</label>
                                                <div class="col-sm-6">
                                                    <input type="number" min="2" step="1" class="form-control"
                                                           id="teamSize" name="teamSize">
                                                </div>
                                                <br/>
                                            </div>
                                        </div>

                                        <div id="numteam" style="display:none">
                                            <div class="md-form form-sm row">
                                                <label for="teamNumber" class="col-sm-6 control-label right-align">Team
                                                    Number</label>
                                                <div class="col-sm-6">
                                                    <input type="number" min="2" step="1" class="form-control"
                                                           id="teamNumber" name="teamNumber">
                                                </div>
                                                <br/>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                            </div>

                            <div class="md-form form-sm row">
                                <label for="description"
                                       class="col-sm-4 control-label right-align">Description</label>
                                <div class="col-sm-8">
                                        <textarea class="form-control" id="description" name="description" rows="12"
                                                  required></textarea>
                                </div>
                                <span class="offset-md-8" id="spnCharLeft"></span>
                                <br/>
                            </div>


                            <div class="text-center mt-1-half">
                                <br/>
                                <button type="submit" class="btn btn-secondary" id="submit" name="done">Create
                                </button>
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
        <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog"
             aria-labelledby="contactSupportModal" aria-hidden="true">
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
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name " placeholder="Enter Your Name">
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

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
        <script src="../js/createtournament.js"></script>
        <script src="../js/moment.min.js"></script>
        <script src="../js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="../js/bracketgenerator.js"></script>

        </body>

        <footer class="footer text-center">
            <div class="container">
                <span class="text-muted">&copy; Rock Lee Development @ Lindenwood Library Services: Media Library</span>
            </div>
        </footer>

        </html>

        <?php $conn->close(); ?>