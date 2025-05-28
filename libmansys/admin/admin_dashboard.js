document.addEventListener('DOMContentLoaded', function() {
    const manageBooksBtn = document.getElementById('manageBooksBtn');
    const manageBooksSection = document.getElementById('manageBooksSection');
    const dashboardSection = document.querySelector('.Dashboard');
    const bookList = document.getElementById('book-list');
    const userList = document.getElementById('user-list');
    const returnList = document.getElementById('return-list');
    const borrowList = document.getElementById('borrow-list');
    const menuItems = document.querySelectorAll('ul.dashboard_menu_lists li');

    // Show dashboard by default
    dashboardSection.style.display = 'block';
    menuItems.forEach(item => item.classList.remove('menuActive')); // Clear any active state
    menuItems[0].classList.add('menuActive'); // Set dashboard as active

    manageBooksBtn.addEventListener('click', (event) => {
        event.preventDefault();
        toggleVisibility(manageBooksSection);
        updateMenuActive(manageBooksBtn); // Update active menu state
    });

    const dashboardMenuItem = menuItems[0];
    dashboardMenuItem.addEventListener('click', (event) => {
        event.preventDefault();
        toggleVisibility(dashboardSection);
        updateMenuActive(dashboardMenuItem); // Update active menu state
    });

    // Function to update menu active state
    function updateMenuActive(activeButton) {
        menuItems.forEach(item => item.classList.remove('menuActive')); // Remove active from all
        activeButton.parentElement.classList.add('menuActive'); // Add active to the clicked button
    }

    document.querySelector('.totalBooks').addEventListener('click', (event) => {
        event.preventDefault();
        hideAllLists();
        toggleListVisibility(bookList, fetchBooks);
    });

    document.querySelector('.totalStudents').addEventListener('click', (event) => {
        event.preventDefault();
        hideAllLists();
        toggleListVisibility(userList, fetchUsers);
    });

    document.querySelector('.returnedBooks').addEventListener('click', (event) => {
        event.preventDefault();
        hideAllLists();
        toggleListVisibility(returnList, fetchReturnedBooks);
    });

    document.querySelector('.borrowedToday').addEventListener('click', (event) => {
        event.preventDefault();
        hideAllLists();
        toggleListVisibility(borrowList, fetchBorrowedBooks);
    });

    async function fetchBooks() {
        const response = await fetch('../user/fetch_books.php');
        if (!response.ok) {
            console.error('Failed to fetch books:', response.statusText);
            return;
        }
        const books = await response.json();
        populateBookList(books);
    }

    function populateBookList(books) {
        bookList.innerHTML = '';
        books.forEach(book => {
            const bookDiv = document.createElement('div');
            bookDiv.classList.add('book');
            bookDiv.innerHTML = `
                <img src="${book.image_url}" alt="${book.Title}">
                <div>
                    <h2>${book.Title}</h2>
                    <p>Author: ${book.Author}</p>
                </div>
            `;
            bookList.appendChild(bookDiv);
        });
    }

    async function fetchUsers() {
        const response = await fetch('fetch_students.php');
        const users = await response.json();
        populateUserList(users);
    }

    function populateUserList(users) {
        userList.innerHTML = '';
        users.forEach(user => {
            const userDiv = document.createElement('div');
            userDiv.classList.add('user');
            userDiv.innerHTML =  `
                <p><strong>UserID:</strong> ${user.UserID}</p>
                <p><strong>Username:</strong> ${user.Username}</p>
                <p><strong>Email:</strong> ${user.Email}</p>
                <p><strong>Role:</strong> ${user.Role}</p>
                <p><strong>Created At:</strong> ${new Date(user.CreatedAt).toLocaleDateString()}</p>
            `;
            userList.appendChild(userDiv);
        });
    }

    async function fetchReturnedBooks() {
        const response = await fetch('fetch_return_list.php');
        if (!response.ok) {
            console.error('Failed to fetch returned books:', response.statusText);
            return;
        }
        const returns = await response.json();
        populateReturnList(returns);
    }

    function populateReturnList(returns) {
        returnList.innerHTML = '';
        returns.forEach(returnItem => {
            const returnDiv = document.createElement('div');
            returnDiv.classList.add('return-item');
            returnDiv.innerHTML = `
                <p><strong>Return ID: ${returnItem.ReturnID}</p>
                <p><strong>Book Title: ${returnItem.Title}</p>
                <p><strong>Author: ${returnItem.Author}</p>
                <p><strong>Condition: ${returnItem.Condition}</p>
                <p><strong>Return Date: ${new Date(returnItem.ReturnDate).toLocaleDateString()}</p>
            `;
            returnList.appendChild(returnDiv);
        });
    }

    async function fetchBorrowedBooks() {
        const response = await fetch('fetch_borrow_list.php');
        if (!response.ok) {
            console.error('Failed to fetch borrowed books:', response.statusText);
            return;
        }
        const borrowings = await response.json();
        populateBorrowList(borrowings);
    }

    function populateBorrowList(borrowings) {
        borrowList.innerHTML = '';
        borrowings.forEach(borrow => {
            const borrowDiv = document.createElement('div');
            borrowDiv.classList.add('borrow-item');
            borrowDiv.innerHTML = `
                <p><strong>Borrow ID: ${borrow.BorrowID}</p>
                <p><strong>Username: ${borrow.Username}</p>
                <p><strong>Book Title: ${borrow.Title}</p>
                <p><strong>Author: ${borrow.Author}</p>
                <p><strong>Borrow Date: ${new Date(borrow.BorrowDate).toLocaleDateString()}</p>
                <p><strong>Due Date: ${new Date(borrow.DueDate).toLocaleDateString()}</p>
                <p><strong>Return Date: ${borrow.ReturnDate ? new Date(borrow.ReturnDate).toLocaleDateString() : 'Not Returned'}</p>
            `;
            borrowList.appendChild(borrowDiv);
        });
    }

    function toggleVisibility(section) {
        const sections = [manageBooksSection, dashboardSection, bookList, userList, returnList, borrowList];
        sections.forEach(sec => {
            if (sec) {
                sec.style.display = (sec === section && sec.style.display === 'none') ? 'block' : 'none';
            }
        });
        // Show the clicked section
        section.style.display = 'block';
    }

    function hideAllLists() {
        [bookList, userList, returnList, borrowList].forEach(list => {
            if (list) list.style.display = 'none';
        });
    }

    function toggleListVisibility(list, fetchFunction) {
        if (list.style.display === 'none' || list.style.display === '') {
            list.style.display = 'block';
            fetchFunction(); // Fetch data when showing the list
        } else {
            list.style.display = 'none'; // Hide list
        }
    }
});

// Function to fetch and update data
async function fetchData() {
    try {
        const response = await fetch('fetch_data.php'); // Update to your PHP file path
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        updateUI(data); // Function to update your UI with the fetched data
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
}

// Function to update the UI with fetched data
function updateUI(data) {
    const dataList = document.getElementById('data-list'); // Replace with your actual element
    dataList.innerHTML = ''; // Clear previous content
    data.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.textContent = `Item: ${item.name}`; // Adjust as needed
        dataList.appendChild(itemDiv);
    });
}

// Fetch data every 5 seconds
setInterval(fetchData, 5000);

// Initial fetch
fetchData();