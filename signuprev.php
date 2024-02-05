<?php
require_once("dbconfig.php");

// Get user input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$rawPassword =md5( $_POST['password']);
$role = $_POST['role'];

// Hash the user password
$hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT);

// Prepare the SELECT query
$select_query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $select_query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "Username already exists. Please choose another one.";
} else {
    // Insert new user into the database using prepared statements
    $insert_query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, 'sss', $username, $hashedPassword, $role);

    if (mysqli_stmt_execute($insert_stmt)) {
        echo "Signup successful. <a href='signup.html'>Reload</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
