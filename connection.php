<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "root";
$password = "JulianMV072505>";
$dbname = "projectdb";
$port = 3306; // need to specify the port now since it is not default

// Create connection
// We added '$port' at the end of this line so it knows where to look
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully"; 
?>