<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("DELETE FROM Categories WHERE CategoryID = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    echo "Category deleted successfully!";
    $stmt->close();
}

$conn->close();
?>