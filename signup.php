
<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user input
$username = $_POST['username'];
$password = md5($_POST['password']); // MD5 for demonstration purposes; use more secure methods
$role = $_POST['role'];

// Check if the username is already taken
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "Username already exists. Please choose another one.";
} else {
    // Insert new user into the database
    $insert_query = "INSERT INTO users (username, password,role) VALUES ('$username', '$password','$role')";
    if (mysqli_query($conn, $insert_query)) {
        echo "Signup successful. <a href='signup.html'>Reload</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


