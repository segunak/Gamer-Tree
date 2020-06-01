<?php

if (isset($_POST['get_id'])) {

    require_once "DBController.php";
    $db_handle = new DBController();

    $tmID = $_POST['get_id'];
    $name = $_POST['tm_name'];
    $des = $_POST['desc'];

    $query = "UPDATE Tournament Set Name = \"$name\", Descripton = \"$des\" WHERE TournamentID = '$tmID' ";
    $result = $db_handle->updateQuery($query);

    if ($result) {

        echo "<script> alert('You have successfully updated a tournament.') </script>";

    } else {
        echo "<script> alert('Connection failed. The Tournament was not updated') </script>";
    }
}
