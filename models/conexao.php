<?php
$servername = "localhost";
$username = "root";
$password = "";
$bd = "techfix";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $bd);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>