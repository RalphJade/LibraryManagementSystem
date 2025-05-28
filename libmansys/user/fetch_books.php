<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books
$sql = "SELECT Title, Author, image_url FROM Books"; // Include image_url in the query
$result = $conn->query($sql);

$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($books);

$conn->close();
?>