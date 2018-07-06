<?php
/*
*Forgot password form
*version 1.0
*Author Keith Djouba
*
*
* This form would let the users enter they new password
* and update password and token to databse
*/

	session_start();
	// Session variable for Email Address;
	$id = $_SESSION["UserID"];
	$token = $_SESSION["Token"];
	/*if userID and Token are not empty*/
	if((!empty($id)) && (!empty($token))) {
		if(!empty($_POST["register-user"])) {
	/* Form Required Field Validation */
		foreach($_POST as $key=>$value) {
			if(empty($_POST[$key])) {
				$error_message = "All Fields are required";
				break;
			}
		}

	/* Password Matching Validation */
if($_POST['resPassword'] != $_POST['confirm_password']){
$error_message = 'Passwords should be same<br>';
}

/* Encrypt new password */
if(!isset($message)) {
	require_once("DBController.php");
	$db_handle = new DBController();

	$query1 = "SELECT * FROM UserToken WHERE UserID='$id' AND Token = '$token'";
	$count = $db_handle->numRows($query1);
	if($count>0) {

    $token = $db_handle->generateNewString();
    $newPassword = $_POST["resPassword"];
    $newPasswordEncrypted = password_hash($newPassword, PASSWORD_BCRYPT);
    $query2 = "UPDATE User set PasswordHash = '$newPasswordEncrypted' WHERE UserID='$id'";
    $query3 = "UPDATE UserToken set Token = '$token' WHERE UserID='$id'";
	  $result2 = $db_handle->updateQuery($query2);
    $result3 = $db_handle->updateQuery($query3);
		if((!empty($result2)) && (!empty($result3))) {
			echo "<script> alert('your account is activate');
	    window.location.href='../index.html'; </script>";
		} else {
			echo "<script> alert('problem registration');
			window.location.href='../index.html'; </script>";
		}
	}else{
  	echo "<script> alert('link has expired');
  	window.location.href='../scscs.html'; </script>";
	}
?>
<!-- html form -->
<!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <title>Login</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <meta content="" name="keywords">
   <meta content="" name="description">
 		<!-- get all the css file-->
 		<link href="../css/bootstrap-grid.css" rel="stylesheet">
 		<link href="../css/bootstrap-grid.min.css" rel="stylesheet">
 		<link href="../css/bootstrap-reboot.css" rel="stylesheet">
 		<link href="../css/bootstrap-reboot.min.css" rel="stylesheet">
 		<link href="../css/bootstrap.css" rel="stylesheet">
 		<link href="../css/bootstrap.min.css" rel="stylesheet">
 		<link href="../css/style.css" rel="stylesheet">
 		<link href="../css/Footer-with-button-logo.css" rel="stylesheet">

 </head>
 <body>
 		<div class="container">
   	<div class ="row justify-content-center">
		<!-- New passsord form -->
 		<form id="register-form" action="" method="post" role="form" >
 			<h2>ENTER NEW THE NEW PASSWORD</h2>
			<div class="form-group">
 					<input type="password" name="resPassword" id="password" tabindex="2" class="form-control" placeholder="Password">
 			</div>
 			<div class="form-group">
 					<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
 			</div>
 			<div class="form-group">
 					<div class="row">
 						<div class="col-sm-6 col-sm-offset-3">
 							<input type="submit" name="register-user" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
 						</div>
 					</div>
 				</div>
 			</form>
			<!-- End of the new password form -->
 		</div>
 	</div>
	<!--  JavaScript --> <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/index.js"></script>
  <script src="../js/resetpassword.js.js"></script>
 </body>
 </html>
