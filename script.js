const wrapper = document.querySelector('.wrapper');
const overlay = document.querySelector('.overlay');
const loginBtn = document.querySelector('.login');
const closeBtn = document.querySelector('.close-btn');
const registerLink = document.querySelector('.register-link');
const loginLink = document.querySelector('.login-link');

// Function to show login form
try {
    loginBtn.addEventListener('click', () => {
    wrapper.style.display = 'block';
    overlay.style.display = 'block';
    wrapper.classList.remove('active');
});
}catch (error) {
    console.error('Error adding event listener to login button:', error);
}


// Function to close the form
closeBtn.addEventListener('click', () => {
    wrapper.style.display = 'none';
    overlay.style.display = 'none';
});

// Function to show register form
registerLink.addEventListener('click', (e) => {
    e.preventDefault();
    wrapper.classList.add('active');
});

// Function to show login form
loginLink.addEventListener('click', (e) => {
    e.preventDefault();
    wrapper.classList.remove('active');
});

// Close form when clicking overlay
overlay.addEventListener('click', () => {
    wrapper.style.display = 'none';
    overlay.style.display = 'none';
});

// Prevent clicks inside wrapper from closing the form
wrapper.addEventListener('click', (e) => {
    e.stopPropagation();
});

login1.addEventListener('click', () => {
    window.location.href = 'home.php';
});





