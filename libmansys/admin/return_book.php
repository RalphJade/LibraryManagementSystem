<?php
$conn = new mysqli('localhost', 'root', '', 'libmansys'); // Update credentials as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrow_id = $_POST['borrow_id'];
    $condition = $_POST['condition'];

    // Update the return date in the Borrowings table
    $stmt = $conn->prepare("UPDATE Borrowings SET ReturnDate = NOW() WHERE BorrowID = ?");
    $stmt->bind_param("i", $borrow_id);
    
    if ($stmt->execute()) {
        // Update available copies in the Books table
        $update_stmt = $conn->prepare("UPDATE Books SET AvailableCopies = AvailableCopies + 1 WHERE BookID = (SELECT BookID FROM Borrowings WHERE BorrowID = ?)");
        $update_stmt->bind_param("i", $borrow_id);
        
        if ($update_stmt->execute()) {
            // Insert a record into the Returns table
            $insert_stmt = $conn->prepare("INSERT INTO Returns (BorrowID, `Condition`) VALUES (?, ?)");
            $insert_stmt->bind_param("is", $borrow_id, $condition);
            
            if ($insert_stmt->execute()) {
                echo "Book returned successfully!";
            } else {
                echo "Error updating Returns table.";
            }
            $insert_stmt->close();
        } else {
            echo "Error updating available copies.";
        }
        
        $update_stmt->close();
    } else {
        echo "Error updating return date.";
    }
    
    $stmt->close();
}

$conn->close();
?>