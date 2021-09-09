<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boostorder";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
  //die("Connection failed: " . $con -> connect_error());
}
//echo "Connected successfully";
?>