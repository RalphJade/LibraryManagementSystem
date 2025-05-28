<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of students
$sql = "SELECT COUNT(*) AS total_students FROM Users"; // Ensure correct table name
$result = $conn->query($sql);

$total_students = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_students = $row['total_students'];
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($total_students);

$conn->close();
?>