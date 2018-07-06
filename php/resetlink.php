<?php
/*
*Forgot password form
*version 1.0
*Author Keith Djouba
*
*
* This form would send get user email and Token from link
* redirect user to another form
*/

/* Starts session*/
  session_start();
  /*Mysql credidential*/
  $servername = "gamertree.coeozr7b8ydf.us-east-1.rds.amazonaws.com";
  $databaseName = "rocklee";
  $databasePassword = "rockleelions77";
  $conn = mysqli_connect($servername, $databaseName, $databasePassword, $databaseName);
  // Sesion variables for database information.
  $_SESSION["servername"] = $servername;
  $_SESSION["databasename"] = $databaseName ;
  $_SESSION["password"] = $password;
  /*Call dbController class to get UserID and Token */
  require_once("DBController.php");
  $db_handle = new DBController();
  $id = $_GET['UserID'];
  $token = $_GET['Token'];
  $query1 = "SELECT * FROM UserToken WHERE UserID='$id' AND Token = '$token'";
  $count = $db_handle->numRows($query1);
  /*If ID and Token macth one the row*/
  if($count>0) {
    /*update user token */
    $query3 = "UPDATE UserToken set Token = '$token' WHERE UserID='$id'";
    $result3 = $db_handle->updateQuery($query3);
    // Session variable for Email Address;
    $_SESSION["UserID"] = $id;
    $_SESSION["Token"] = $token;
    /*redirect user to another form*/
    header('Location: respassword.php');
  }else {

  }

 ?>
