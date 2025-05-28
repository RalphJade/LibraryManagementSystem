
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
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
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="../images/favicon.ico" type="">
    <script src="https://kit.fontawesome.com/7ecda8df51.js" crossorigin="anonymous"></script>
    <title>Homepage - USM Library</title>
</head>
<body>
    <header>
        <div class="header">
            <img src="../images/logo.jpg" alt="USM Library" id="logo">
            <a href="logout.php" id="logoutBtn"><i class="fa fa-power-off"></i>Log-out</a>
            <nav>
                <ul>
                    <li><a href="#homepageContainer" id="homeBtn">Home</a></li>
                    <li><a href="#searchContainer" id="searchBtn">Search</a></li>
                    <li><a href="#historyContainer" id="historyBtn">History</a></li>
                </ul>
            </nav>
        </div>
    </header>   
    <div class="banner">
        <div class="homepageContainer" id="homepageContainer">
            <div class="bannerHeader">
                <h1>USM Library</h1>
            </div>
            <p class="bannerTagline">
                Streamline your library operations with ease and efficiency. Empower users to explore and engage with knowledge like never before!
            </p>
        </div>

        <div class="search-container" id="searchContainer">
            <h2>Book Catalog</h2>
            <input type="text" class="search-input" id="search" placeholder="Search for books..." onkeyup="filterBooks()">
            <div class="book-list" id="bookList">
                <!-- Books will be dynamically inserted here -->
            </div>
        </div>
        <div class="historyContainer" id="historyContainer">
            <h3>History</h3>
        </div>

    </div>
            <script>
                 // Fetch books from the server
                async function fetchBooks() {
                    const response = await fetch('fetch_books.php');
                    const books = await response.json();
                    const bookList = document.getElementById('bookList');
                    bookList.innerHTML = '';

                    books.forEach(book => {
                        const bookDiv = document.createElement('div');
                        bookDiv.classList.add('book');
                        bookDiv.innerHTML = `
                            <img src="${book.image_url || 'book_placeholder.jpg'}" alt="${book.Title}">
                            <div class="book-title">${book.Title}</div>
                            <div>Author: ${book.Author}</div>
                        `;
                        bookList.appendChild(bookDiv);
                    });
                }

                function filterBooks() {
                    const searchInput = document.getElementById('search').value.toLowerCase();
                    const books = document.querySelectorAll('.book');
                    books.forEach(book => {
                        const title = book.querySelector('.book-title').textContent.toLowerCase();
                        if (title.includes(searchInput)) {
                            book.style.display = '';
                        } else {
                            book.style.display = 'none';
                        }
                    });
                }

                // Load books when the page loads
                window.onload = fetchBooks;
            </script>
        </div>
    </div>

<script>
    window.onunload = function() {
        null; // This may help prevent caching on some browsers
    };
</script>
</body>
</html>