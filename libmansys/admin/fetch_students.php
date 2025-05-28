<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$sql = "SELECT UserID, Username, Email, Role, CreatedAt FROM Users"; // Adjust fields as necessary
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($users);

$conn->close();
?>