<?php


$servername = $_ENV["MYSQL_SERVICE_NAME"];
$username = "root";
$password = $_ENV["MYSQL_ROOT_PASSWORD"];
$dbname = "employee";

/*
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "infosys";
*/

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
