<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="icon" href="../images/favicon.ico" type="">
    <script src="https://kit.fontawesome.com/7ecda8df51.js" crossorigin="anonymous"></script>
    <title>Admin - USM Library</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <div class="dashboard_sidebar" id="dashboard_sidebar">
            <div class="dashboard_sidebar_admin">
                <i class="fa-solid fa-shield-halved" id="shield"></i>
                <span id="admintext">Admin</span>
            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <a href="" id="Dashboard"><i class="fa fa-dashboard"></i><span class="menuText">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="#" id="manageBooksBtn"><i class="fa-solid fa-book"></i><span class="menuText">Manage Books</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="" id="toggleBtn"><i class="fa fa-navicon"></i></a>
                <h4>Library Management System</h4>
                <a href="admin_logout.php" id="logoutBtn"><i class="fa fa-power-off"></i>Log-out</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                   <div class="Dashboard">
                        <ul class="Reports">
                            <li class="totalBooks">
                                <div class="count" id="books-count">0</div>
                                <i class="fa-solid fa-book"></i>
                                <span>Total Books</span>
                            </li>
                            <li class="totalStudents">
                                <div class="count" id="students-count">0</div>
                                <i class="fa-solid fa-users"></i>
                                <span>Total Students</span>
                            </li>
                            <li class="returnedBooks">
                                <div class="count" id="returns-count">0</div>
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Returned Books</span>
                            </li>
                            <li class="borrowedToday">
                                <div class="count" id="borrowings-count">0</div>
                                <i class="fa-solid fa-share"></i>
                                <span>Borrowed Today</span>
                            </li>
                        </ul>
                   </div>
                   <div class="reportStats" id="reportStats">
                        <div id="book-list">

                        </div>
                        <div id="user-list" style="display: none;">

                        </div>
                        <div id="return-list" style="display: none;">

                        </div>
                        <div id="borrow-list" style="display: none;">

                        </div>
                   </div>
                   <div class="ManageBooks" id="manageBooksSection" style="display: none;">
                        <ul class="Manage">
                            <li class="add" onclick="showSection('addBook')">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add</span>
                            </li>
                            <li class="delete" onclick="showSection('deleteBook')">
                                <i class="fa-solid fa-trash"></i>
                                <span>Delete</span>
                            </li>
                            <li class="edit" onclick="showSection('editBook')">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit</span>
                            </li>
                            <li class="borrow" onclick="showSection('borrowBook')">
                                <i class="fa-solid fa-share"></i>
                                <span>Borrow</span>
                            </li>
                            <li class="return" onclick="showSection('returnBook')">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Return</span>
                            </li>
                        </ul>

                        <div id="addBookSection" class="form-section" style="display: none;">
                            <h3>Add Book</h3>
                            <form id="addBookForm" action="add_book.php" method="POST" onsubmit="return handleAddBook()">
                                <input type="text" name="title" placeholder="Title" required><br>
                                <input type="text" name="author" placeholder="Author" required><br>
                                <input type="text" name="isbn" placeholder="ISBN" required><br>
                                <input type="text" name="image_url" placeholder="Image URL" required><br>
                                <button type="submit">Add Book</button>
                            </form>
                            <div id="addBookMessage" class="message"></div>
                        </div>

                        <div id="deleteBookSection" class="form-section" style="display: none;">
                            <h3>Delete Book</h3>
                            <form id="deleteBookForm" action="delete_book.php" method="POST" onsubmit="return handleDeleteBook()">
                                <input type="number" name="book_id" placeholder="Book ID" required><br>
                                <button type="submit">Delete Book</button>
                            </form>
                            <div id="deleteBookMessage" class="message"></div>
                        </div>

                        <div id="editBookSection" class="form-section" style="display: none;">
                            <h3>Edit Book</h3>
                            <form id="editBookForm" action="edit_book.php" method="POST" onsubmit="return handleEditBook()">
                                <input type="number" name="edit_book_id" placeholder="Book ID" required><br>
                                <input type="text" name="new_title" placeholder="New Title"><br>
                                <input type="text" name="new_author" placeholder="New Author"><br>
                                <input type="number" name="new_category_id" placeholder="New Category ID"><br>
                                <input type="text" name="new_isbn" placeholder="New ISBN"><br>
                                <button type="submit">Edit Book</button>
                            </form>
                            <div id="editBookMessage" class="message"></div>
                        </div>

                        <div id="borrowBookSection" class="form-section" style="display: none;">
                            <h3>Borrow Book</h3>
                            <form id="manageBorrowingForm" action="manage_borrowing.php" method="POST" onsubmit="return handleManageBorrowing()">
                                <input type="number" name="user_id" placeholder="User ID" required><br>
                                <input type="number" name="book_id_borrow" placeholder="Book ID" required><br>
                                <button type="submit">Borrow Book</button>
                            </form>
                            <div id="manageBorrowingMessage" class="message"></div>
                        </div>

                        <div id="returnBookSection" class="form-section" style="display: none;">
                            <h3>Return Book</h3>
                            <form id="returnBookForm" action="return_book.php" method="POST" onsubmit="return handleReturnBook()">
                                <input type="number" name="borrow_id" placeholder="Borrow ID" required><br>
                                <select name="condition" required>
                                    <option value="new">New</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="poor">Poor</option>
                                </select><br>
                                <button type="submit">Return Book</button>
                            </form>
                            <div id="returnBookMessage" class="message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    var sideBarisOpen = true;

    toggleBtn.addEventListener( 'click', (event) => {
        event.preventDefault();
        
        adminText = document.getElementById('admintext');

        if(sideBarisOpen){
            dashboard_sidebar.style.width = '5%';
            dashboard_content_container.style.width = '95%';
            shield.style.width = '5x';
            adminText.style.display = 'none'; // Hide admin text

            menuIcons = document.getElementsByClassName('menuText');
            for(var i=0; i < menuIcons.length;i++){
                menuIcons[i].style.display = 'none';
            }
            
            document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
            sideBarisOpen = false;
        } else {
            dashboard_sidebar.style.width = '20%';
            dashboard_content_container.style.width = '80%';
            adminText.style.display = 'inline-block'; // Show admin text
            shield.style.width = '20x';
            
            menuIcons = document.getElementsByClassName('menuText');
            for(var i=0; i < menuIcons.length;i++){
                menuIcons[i].style.display = 'inline-block'; 
            }
            
            document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
            sideBarisOpen = true;
        }
    });
</script>
<script src="admin_dashboard.js"></script>
<script>
    window.onunload = function() {
        null; // This may help prevent caching on some browsers
    };
</script>
<script>
    fetch('fetch_total_books.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('books-count').textContent = data;
        })
        .catch(error => console.error('Error fetching data:', error));
    
    // Fetch total number of students
    fetch('fetch_total_students.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('students-count').textContent = data;
        })
        .catch(error => console.error('Error fetching total students:', error));

    // Fetch total returned books today
    fetch('fetch_returns_today.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('returns-count').textContent = data;
        })
        .catch(error => console.error('Error fetching returns today:', error));
    
    // Fetch total borrowings today
    fetch('fetch_borrow_today.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('borrowings-count').textContent = data;
        })
        .catch(error => console.error('Error fetching borrowings today:', error));

</script>
<script>
function handleAddBook() {
    // Show success message
    document.getElementById('addBookMessage').innerText = 'Book added successfully!';
    return true; // Allow form submission
}

function handleDeleteBook() {
    // Show success message
    document.getElementById('deleteBookMessage').innerText = 'Book deleted successfully!';
    return true; // Allow form submission
}

function handleEditBook() {
    // Show success message
    document.getElementById('editBookMessage').innerText = 'Book updated successfully!';
    return true; // Allow form submission
}

function handleManageBorrowing() {
    // Show success message
    document.getElementById('manageBorrowingMessage').innerText = 'Book borrowed successfully!';
    return true; // Allow form submission
}

function handleReturnBook() {
    // Show success message
    document.getElementById('returnBookMessage').innerText = 'Book returned successfully!';
    return true; // Allow form submission
}

// Function to toggle the visibility of the Manage Books section
function toggleManageBooks() {
    const manageBooksSection = document.getElementById('manageBooksSection');
    if (manageBooksSection.style.display === 'none') {
        manageBooksSection.style.display = 'block';
    } else {
        manageBooksSection.style.display = 'none';
    }
}

function showSection(section) {
    // Hide all sections
    const sections = document.querySelectorAll('.form-section');
    sections.forEach((sec) => {
        sec.style.display = 'none';
    });

    // Show the selected section
    document.getElementById(section + 'Section').style.display = 'block';
}

// Example of calling the toggle function
// toggleManageBooks(); // Call this function when needed to show/hide the section
</script>
</body>
</html>