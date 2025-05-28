<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to fetch returned books of today
$sql = "SELECT r.ReturnID, r.ReturnDate, r.Condition, b.BookID, bk.Title, bk.Author
        FROM Returns r
        JOIN Borrowings b ON r.BorrowID = b.BorrowID
        JOIN Books bk ON b.BookID = bk.BookID
        WHERE DATE(r.ReturnDate) = CURDATE()";

$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

// Fetch results
$returns = [];
while ($row = $result->fetch_assoc()) {
    $returns[] = $row;
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($returns);

// Close the connection
$conn->close();
?>