<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Manage Books</h2>
    <form action="add_book.php" method="POST">
        <h3>Add Book</h3>
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="author">Author:</label>
        <input type="text" name="author" required><br>

        <label for="category_id">Category ID:</label>
        <input type="number" name="category_id" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required><br>

        <button type="submit">Add Book</button>
    </form>

    <h3>Delete Book</h3>
    <form action="delete_book.php" method="POST">
        <label for="book_id">Book ID:</label>
        <input type="number" name="book_id" required><br>
        <button type="submit">Delete Book</button>
    </form>

    <h3>Edit Book</h3>
    <form action="edit_book.php" method="POST">
        <label for="edit_book_id">Book ID:</label>
        <input type="number" name="edit_book_id" required><br>

        <label for="new_title">New Title:</label>
        <input type="text" name="new_title"><br>

        <label for="new_author">New Author:</label>
        <input type="text" name="new_author"><br>

        <label for="new_category_id">New Category ID:</label>
        <input type="number" name="new_category_id"><br>

        <label for="new_isbn">New ISBN:</label>
        <input type="text" name="new_isbn"><br>

        <button type="submit">Edit Book</button>
    </form>

    <h3>Manage Borrowing</h3>
    <form action="manage_borrowing.php" method="POST">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" required><br>

        <label for="book_id_borrow">Book ID:</label>
        <input type="number" name="book_id_borrow" required><br>

        <button type="submit">Borrow Book</button>
    </form>

    <form action="return_book.php" method="POST">
        <h3>Return Book</h3>
        <label for="borrow_id">Borrow ID:</label>
        <input type="number" name="borrow_id" required><br>
        <label for="condition">Condition:</label>
        <select name="condition" required>
            <option value="new">New</option>
            <option value="good">Good</option>
            <option value="fair">Fair</option>
            <option value="poor">Poor</option>
        </select><br>
        <button type="submit">Return Book</button>
    </form>
</body>
</html>