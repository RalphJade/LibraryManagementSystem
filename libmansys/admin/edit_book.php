<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['edit_book_id'];
    $new_title = $_POST['new_title'];
    $new_author = $_POST['new_author'];
    $new_category_id = $_POST['new_category_id'];
    $new_isbn = $_POST['new_isbn'];

    $sql = "UPDATE Books SET Title = ?, Author = ?, CategoryID = ?, ISBN = ? WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $new_title, $new_author, $new_category_id, $new_isbn, $book_id);
    $stmt->execute();
    echo "Book updated successfully!";
    $stmt->close();
}

$conn->close();
?>