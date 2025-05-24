class Toast {
    constructor() {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
        this.initializeFormHandlers();
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

    initializeFormHandlers() {
        // Handle login form submission
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(loginForm);
                
                fetch('functions/login_verification.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes('Login successful')) {
                        this.success('Login successful!');
                        setTimeout(() => {
                            window.location.href = 'home.php';
                        }, 1500);
                    } else {
                        this.error(data || 'Login failed. Please try again.');
                    }
                })
                .catch(error => {
                    this.error('An error occurred. Please try again.');
                });
            });
        }

        // Handle registration form submission
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(registerForm);
                
                fetch('functions/registration.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes('Registration successful')) {
                        this.success('Registration successful! Please login.');
                        setTimeout(() => {
                            document.querySelector('.formbox-register').style.display = 'none';
                            document.querySelector('.formbox').style.display = 'block';
                        }, 1500);
                    } else {
                        this.error(data || 'Registration failed. Please try again.');
                    }
                })
                .catch(error => {
                    this.error('An error occurred. Please try again.');
                });
            });
        }
    }
}

// Create global toast instance
window.toast = new Toast(); 