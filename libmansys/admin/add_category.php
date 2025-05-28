<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    $stmt = $conn->prepare("INSERT INTO Categories (CategoryName) VALUES (?)");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    echo "Category added successfully!";
    $stmt->close();
}

$conn->close();
?>