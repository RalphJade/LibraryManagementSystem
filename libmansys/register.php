<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'member'; // Default role

    // Prepare and execute the statement
    $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password, Role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error; // Display error if the execution fails
    }

    $stmt->close();
}

$conn->close();
?>