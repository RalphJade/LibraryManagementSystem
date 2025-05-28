<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update with your credentials

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to fetch data
$sql = "SELECT id, name FROM your_table"; // Replace with your actual table name
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

// Fetch results
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>