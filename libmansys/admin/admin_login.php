<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hardcoded credentials
$validUsername = "admin";
$validPassword = "adminpass";

$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $validUsername && $password === $validPassword) {
        // Set session variable
        $_SESSION['admin'] = $username;
        // Redirect to admin dashboard on successful login
        header("Location: admin_dashboard.php");
        exit(); // Ensure no further code is executed
    } else {
        $errorMessage = "Sorry, that username or password is incorrect. Please try again.";
        echo "<script type='text/javascript'>alert('$errorMessage');</script>"; // JavaScript alert
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_login.css">
    <link rel="icon" href="../images/favicon.ico" type="">
    <title>Admin Login - USM Library</title>
</head>
<body>
    <div class="banner">
        <img src="../images/logo.jpg" alt="USM Library" id="logo">
    </div>
    <div class="container">
        <div class="loginHeader">
            <h2>Admin Login</h2>
        </div>
        <div class="loginBody">
            <form action="" method="POST">
                <div class="loginInputsContainer">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="loginInputsContainer">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div class="loginButtonContainer">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>