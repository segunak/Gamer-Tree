<?php

session_start();

$servername = "***********************";
$databaseName = "***********************";
$databasePassword = "***********************";

$_SESSION["servername"] = $servername;
$_SESSION["databasename"] = $databaseName;
$_SESSION["password"] = $databasePassword;
$_SESSION["logged_in"] = true;

// Building the connection.
$conn = mysqli_connect($servername, $databaseName, $databasePassword, $databaseName);

//Check the connection
if (!$conn) {
    die("Connection to server failed. Contact your Lindenwood University system adminstrator: " . mysqli_connect_error());
    header('Location: ./error.html');

} else {

    // Email and password from the input boxes on login.
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Make sure their email is in our database. If not they need to register.
    $check_email_query = "select Email from User where Email = \"$email\" and Status = 1";
    $result = mysqli_query($conn, $check_email_query);

    if (!$result) {
        die("There was a database connection error: " . mysqli_error($conn));
        header('Location: ../error.html');
    } else {
        if (mysqli_num_rows($result) == 0) {
            echo "<script> alert('Your Lindenwood email address is not currrently in our system, or it has not been activated. If you have registered please check your email for a User Account activation link. Otherwise, please register as a new user.');
              window.location.href='../index.html'; </script>";
        } else if (mysqli_num_rows($result) == 1) {

            //Retrieve user password info
            $get_password_query = "select PasswordHash from User where Email = \"$email\"";
            $result2 = mysqli_query($conn, $get_password_query);

            if (!$result2) {
                die("There was a database error: " . mysqli_error($conn));
                header('Location: ../error.html');
            } else {
                $row = mysqli_fetch_assoc($result2);
                $hashed_password = $row["PasswordHash"];

                //Verify the submitted password
                if (password_verify($password, $hashed_password)) {

                    // Session variable for Email Address;
                    $_SESSION["email"] = $email;

                    //Redirect.
                    header('Location: index.php');
                } else {
                    echo "<script> alert('The password you entered does not match the associated user account. Please try again.');
                 window.location.href='../index.html'; </script>";

                }
            }
        }
    }
}
