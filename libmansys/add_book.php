<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];
    $isbn = $_POST['isbn'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO Books (Title, Author, CategoryID, ISBN, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $author, $category_id, $isbn, $image_url);
    $stmt->execute();
    echo "Book added successfully!";
    $stmt->close();
}

$conn->close();
?>