class Toast {
    constructor() {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
    }

    show(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = type === 'success' ? 'checkmark-circle' : 'alert-circle';
        
        toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="${icon}" class="toast-icon"></ion-icon>
                <span>${message}</span>
            </div>
            <button class="toast-close">
                <ion-icon name="close"></ion-icon>
            </button>
        `;

        this.container.appendChild(toast);

        // Add show class after a small delay to trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Add click event to close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            this.hide(toast);
        });

        // Auto hide after duration
        if (duration > 0) {
            setTimeout(() => {
                this.hide(toast);
            }, duration);
        }

        return toast;
    }

    hide(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300); // Match the transition duration
    }

    success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 3000) {
        return this.show(message, 'error', duration);
    }
}

// Create global toast instance
window.toast = new Toast();

// Login and Registration Form Handling
document.addEventListener('DOMContentLoaded', function() {
    // Login form handling
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('functions/login_verification.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Login successful')) {
                    toast.success('Login successful!');
                    setTimeout(() => {
                        window.location.href = 'home.php';
                    }, 1500);
                } else {
                    toast.error(data || 'Login failed. Please try again.');
                }
            })
            .catch(error => {
                toast.error('An error occurred. Please try again.');
            });
        });
    }

    // Registration form handling
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('functions/registration.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Registration successful')) {
                    toast.success('Registration successful! Please login.');
                    setTimeout(() => {
                        document.querySelector('.formbox-register').style.display = 'none';
                        document.querySelector('.formbox').style.display = 'block';
                    }, 1500);
                } else {
                    toast.error(data || 'Registration failed. Please try again.');
                }
            })
            .catch(error => {
                toast.error('An error occurred. Please try again.');
            });
        });
    }

    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    const searchResults = document.querySelector('.search-results');
    let searchTimeout;

    function showSearchResults() {
        searchResults.classList.add('show');
    }

    function hideSearchResults() {
        searchResults.classList.remove('show');
    }

    function performSearch(query) {
        // Example search results - replace with actual API call
        const mockResults = [
            {
                title: 'Heneral Luna',
                year: '2015',
                genre: 'Historical Drama',
                image: 'images/heneral_luna.jpg'
            },
            {
                title: 'Four Sisters and a Wedding',
                year: '2013',
                genre: 'Comedy Drama',
                image: 'images/four_sisters.jpg'
            },
            {
                title: 'On the Job',
                year: '2013',
                genre: 'Crime Thriller',
                image: 'images/on_the_job.jpg'
            }
        ];

        const filteredResults = mockResults.filter(movie => 
            movie.title.toLowerCase().includes(query.toLowerCase()) ||
            movie.genre.toLowerCase().includes(query.toLowerCase())
        );

        if (filteredResults.length > 0) {
            searchResults.innerHTML = filteredResults.map(movie => `
                <div class="search-result-item">
                    <img src="${movie.image}" alt="${movie.title}">
                    <div class="search-result-info">
                        <h4>${movie.title}</h4>
                        <p>${movie.year} • ${movie.genre}</p>
                    </div>
                </div>
            `).join('');
        } else {
            searchResults.innerHTML = '<div class="no-results">No movies found</div>';
        }
    }

    if (searchBtn && searchInput && searchResults) {
        searchBtn.addEventListener('click', () => {
            const query = searchInput.value.trim();
            if (query) {
                performSearch(query);
                showSearchResults();
            }
        });

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(searchTimeout);
            
            if (query) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                    showSearchResults();
                }, 300);
            } else {
                hideSearchResults();
            }
        });

        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchResults.contains(e.target) && 
                !searchInput.contains(e.target) && 
                !searchBtn.contains(e.target)) {
                hideSearchResults();
            }
        });

        // Handle search result item clicks
        searchResults.addEventListener('click', (e) => {
            const resultItem = e.target.closest('.search-result-item');
            if (resultItem) {
                const movieTitle = resultItem.querySelector('h4').textContent;
                // Handle movie selection - you can redirect to movie details page
                console.log('Selected movie:', movieTitle);
                hideSearchResults();
            }
        });
    }
}); 