<?php
/*
Author: Zhuocheng Shang
Description: This file if set to update a tournament which is already approved
            
*/

if(isset($_POST['get_id'])) {

        // Create connection
    require_once("DBController.php");
    $db_handle = new DBController();

        //get related tournament id, name , descrption
    $tmID = $_POST['get_id'];
    $name = $_POST['tm_name'];
    $des = $_POST['desc'];
             
        //update tournament 
    $query = "UPDATE Tournament Set Name = \"$name\", Descripton = \"$des\" WHERE TournamentID = '$tmID' ";
    $result = $db_handle->updateQuery($query);

    if ($result) {

        echo "<script> alert('You successfully update a tournament.') </script>";

    } else {
        echo "<script> alert('Connect Fail.') </script>";
    }

}

?>