<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errorMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the statement
    $stmt = $conn->prepare("SELECT Password, Role FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect to dashboard or another page on successful login
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = "Sorry, that username or password is incorrect. Please try again.";
        echo "<script type='text/javascript'>alert('$errorMessage');</script>"; // JavaScript alert
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="../images/favicon.ico" type="">
    <title>Login - USM Library</title>
</head>
<body>
    <div class="banner">
        <img src="../images/logo.jpg" alt="USM Library" id="logo">
    </div>
    <div class="container">
        <div class="loginHeader">
            <h1>Login</h1>
            <h2>USM Library</h2>
        </div>
        <div class="loginBody">
            <form action="" method="POST">
                <div class="loginInputsContainer">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="loginInputsContainer">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="loginButtonContainer">
                    <button type="submit">Login</button>
                </div>
                <p class="registration-prompt">Don't have an account? <a href="register.html"> Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>