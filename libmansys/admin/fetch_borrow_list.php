<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to fetch borrowings with user and book details
$sql = "SELECT b.BorrowID, u.Username, bk.Title, bk.Author, b.BorrowDate, b.DueDate, b.ReturnDate
        FROM Borrowings b
        JOIN Users u ON b.UserID = u.UserID
        JOIN Books bk ON b.BookID = bk.BookID
        WHERE DATE(b.BorrowDate) = CURDATE()";

$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

// Fetch results
$borrowings = [];
while ($row = $result->fetch_assoc()) {
    $borrowings[] = $row;
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($borrowings);

// Close the connection
$conn->close();
?>