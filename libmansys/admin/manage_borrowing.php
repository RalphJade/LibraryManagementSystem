<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id_borrow'];

    // Check if the book is available
    $check_stmt = $conn->prepare("SELECT AvailableCopies FROM Books WHERE BookID = ?");
    $check_stmt->bind_param("i", $book_id);
    $check_stmt->execute();
    $check_stmt->bind_result($available_copies);
    $check_stmt->fetch();
    
    // Close the statement to free up resources
    $check_stmt->close();
    
    if ($available_copies > 0) {
        // Assuming a borrow period of 14 days
        $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));

        // Insert into Borrowings
        $stmt = $conn->prepare("INSERT INTO Borrowings (UserID, BookID, DueDate) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $book_id, $due_date);
        
        if ($stmt->execute()) {
            // Update available copies
            $update_stmt = $conn->prepare("UPDATE Books SET AvailableCopies = AvailableCopies - 1 WHERE BookID = ?");
            $update_stmt->bind_param("i", $book_id);
            $update_stmt->execute();

            echo "Book borrowed successfully!";
            $update_stmt->close();
        } else {
            echo "Error borrowing the book.";
        }
        $stmt->close();
    } else {
        echo "Book is not available for borrowing.";
    }
}

$conn->close();
?>