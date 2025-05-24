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
    <script src="https://kit.fontawesome.com/7ecda8df51.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard - Library Management System</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <div class="dashboard_sidebar" id="dashboard_sidebar">
            <div class="dashboard_sidebar_admin">
                <i class="fa-solid fa-shield-halved" id="shield"></i>
                <span>Admin</span>
            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <a href=""><i class="fa fa-dashboard"></i><span class="menuText">Dashboard</span></a>
                    </li>
                    <li>
                        <a href=""><i class="fa fa-dashboard"></i><span class="menuText">Dashboard</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="" id="toggleBtn"><i class="fa fa-navicon"></i></a>
                <h4>Library Management System</h4>
                <a href="" id="logoutBtn"><i class="fa fa-power-off"></i>Log-out</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
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

                        <label for="image_url">ISBN:</label>
                        <input type="text" name="image_url" required><br>

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
                </div>
            </div>
        </div>
    </div>
<script>
    var sideBarisOpen = true;

    toggleBtn.addEventListener( 'click', (event) => {
        event.preventDefault();

        if(sideBarisOpen){
            dashboard_sidebar.style.width = '10%';
            dashboard_content_container.style.width = '90%';
            shield.style.width = '5x';
            
            menuIcons = document.getElementsByClassName('menuText');
            for(var i=0; i < menuIcons.length;i++){
                menuIcons[i].style.display = 'none'; 
            }
            
            document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
            sideBarisOpen = false;
        } else {
            dashboard_sidebar.style.width = '20%';
            dashboard_content_container.style.width = '80%';
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
</body>
</html>