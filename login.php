<html>
    <head>
</head>
    <body>
        
    <?php
session_start();

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
$userpass = md5($_POST['pass']); // MD5 for demonstration purposes; use more secure methods

// Check if the provided credentials are valid
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$userpass'";
$query2 = "SELECT role FROM users WHERE username = '$username' ";
$result = mysqli_query($conn, $query);
$result2 = mysqli_query($conn, $query2);
$row = mysqli_fetch_assoc($result2);
$role = $row["role"];

if (mysqli_num_rows($result) == 1) {

    if($role == 'manager'){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dash.php"); // Redirect to the dashboard or a secure page
    }
    elseif($role == 'emp'){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dash1.php"); // Redirect to the dashboard or a secure page
    }

} else {
    
    echo "Invalid username or password. <a href='index.html'>Try again</a>";
}

mysqli_close($conn);
?>
</body>
</html>
