<?php
/*
Deletes an existing tournament.
 */

//connect to the database
require_once "DBController.php";
$db_handle = new DBController();

//get the current tournament ID
$tmID = $_POST['get_id'];

//delete it
$result = $db_handle->deleteQuery("DELETE  FROM Tournament WHERE TournamentID = '$tmID' ");
$result1 = $db_handle->deleteQuery("DELETE  FROM tbl_uploads WHERE TournamentId = '$tmID' ");

if ($result) {
    //alert with success message
    echo "<script> alert('Tournament deleted successfully.') </script>";

} else {
    echo "<script> alert('Error - Failed to delete the tournament.') </script>";
}
