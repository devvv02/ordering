<?php
require_once("dbconfig.php");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the order number sent via GET request
$orderNumber = $_GET['orderNumber'];

// Prepare a SQL query to check if the order number exists
$stmt = $conn->prepare("SELECT * FROM tempords WHERE order_num = ?");
$stmt->bind_param("i", $orderNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Order number already exists in the database
    http_response_code(409); // Send conflict status (Order already exists)
} else {
    // Order number does not exist in the database, it's valid
    http_response_code(200); // Send success status
}

// Close connections
$stmt->close();
$conn->close();
?>
