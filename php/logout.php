<?php
/*This ensures the destruction of all current session variables
on logout and prevents the unauthroized retrieval of previous user information */

session_start();
$_SESSION["logged_in"] = false;
session_destroy();
header("Location: ../index.html");
