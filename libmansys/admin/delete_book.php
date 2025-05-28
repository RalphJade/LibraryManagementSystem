<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];

    $stmt = $conn->prepare("DELETE FROM Books WHERE BookID = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    echo "Book deleted successfully!";
    $stmt->close();
}

$conn->close();
?>