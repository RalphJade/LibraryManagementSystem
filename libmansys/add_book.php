<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];
    $isbn = $_POST['isbn'];

    $stmt = $conn->prepare("INSERT INTO Books (Title, Author, CategoryID, ISBN) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $author, $category_id, $isbn);
    $stmt->execute();
    echo "Book added successfully!";
    $stmt->close();
}

$conn->close();
?>