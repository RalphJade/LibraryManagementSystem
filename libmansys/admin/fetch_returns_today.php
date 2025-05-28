<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of returns today
$sql = "SELECT COUNT(*) AS total_returns FROM Returns WHERE DATE(ReturnDate) = CURDATE()"; // Count returns for today
$result = $conn->query($sql);

$total_returns = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_returns = $row['total_returns'];
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($total_returns);

$conn->close();
?>