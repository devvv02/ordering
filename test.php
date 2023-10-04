<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo("Connection established");

// Get user input
$username = $_POST['username'];
$userpass = md5($_POST['pass']); // MD5 for demonstration purposes; use more secure methods

echo("user input fetched");

// Check if the provided credentials are valid
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$userpass'";
$query2 = "SELECT role FROM users WHERE username = '$username' ";
$result = mysqli_query($conn, $query2);
$row= mysqli_fetch_assoc($result);


echo("hello");
echo($query);
echo($query2);
echo($row["role"]);


?>