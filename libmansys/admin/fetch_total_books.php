<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of books
$sql = "SELECT COUNT(*) AS total_books FROM Books"; // Count the total books
$result = $conn->query($sql);

$total_books = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_books = $row['total_books'];
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($total_books);

$conn->close();
?>