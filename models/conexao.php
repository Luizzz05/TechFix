<?php
$servername = "40.233.68.103";
$username = "alvaro";
$password = "123";
$bd = "techfix";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $bd);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>