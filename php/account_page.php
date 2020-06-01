<?php

/*
Available Session Variables.

Remember to call session_start();

$_SESSION["servername"]
$_SESSION["databasename"]
$_SESSION["password"]
$_SESSION["email"]

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
        $userArray = array("email" => $row["Email"], "first" => $row["FirstName"], "last" => $row["LastName"]);
    }
} else {
    echo "0 results";
}

foreach ($userArray as $key => $value) {
    echo "Key: $key; Value: $value\n";
}

//Below is the retrieval of all current/upcoming tournaments user is apart of.
$sql = "SELECT Name, Descripton, StartDate, EndDate FROM Tournament WHERE Approved = 1";
$result = $conn->query($sql);
$tournamentsArray = array();

if ($result->num_rows > 0) {
    $num = 0;
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $tournamentsArray = array($num => array("name" => $row["Name"], "descripton" => $row["Descripton"], "startDate" => $row["StartDate"], "startDate" => $row["EndDate"]));
        echo "<br>" . $tournamentsArray[$num]["name"];
        echo " " . $tournamentsArray[$num]["descripton"] . "<br>";
        $num = $num + 1;
    }
} else {
    echo "0 results";
}
echo gettype($num) . ": " . $num;

echo $tournamentsArray[2]["name"];
echo $tournamentsArray[2]["description"];
$conn->close();
?>