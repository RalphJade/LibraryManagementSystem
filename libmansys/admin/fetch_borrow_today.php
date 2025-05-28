<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of borrowings today
$sql = "SELECT COUNT(*) AS total_borrowings FROM Borrowings WHERE DATE(BorrowDate) = CURDATE()"; // Count borrowings for today
$result = $conn->query($sql);

$total_borrowings = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_borrowings = $row['total_borrowings'];
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($total_borrowings);

$conn->close();
?>