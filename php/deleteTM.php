<?php
/*
Author: Zhuocheng Shang
Description: This file is set to delete a tournament which is already approved
*/

    //connect to database
require_once("DBController.php");
$db_handle = new DBController();

        //get current tournament ID
    $tmID = $_POST['get_id'];
        //delete tournament from database
    $result = $db_handle->deleteQuery( "DELETE  FROM Tournament WHERE TournamentID = '$tmID' ");
    $result1 = $db_handle->deleteQuery( "DELETE  FROM tbl_uploads WHERE TournamentId = '$tmID' ");

    if($result){
            //alert with success message
        echo "<script> alert('you successfully delete a tournament.') </script>";

   }else
   {
    echo "<script> alert('Fail to delete.') </script>";
    }


?>
