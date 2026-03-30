let API_URL = 'api'; // Dynamic relative path
if (window.location.protocol === 'file:' || window.location.port === '5500') {
    // If you're using Live Server (5500) or file: protocol, try common local PHP ports.
    // Standardizing to port 80/8080 (XAMPP) or 8000 (PHP server).
    API_URL = 'http://127.0.0.1/attendance_system/api'; 
}

// Setup axios defaults if needed, using vanilla fetch here
class ApiService {
    static async post(endpoint, data) {
        try {
            const response = await fetch(`${API_URL}/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const textResponse = await response.text();
            try {
                return JSON.parse(textResponse);
            } catch (e) {
                console.error("Failed to parse JSON. Raw response from server:", textResponse);
                return { success: false, message: 'Server returned an invalid format' };
            }
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, message: `Network fail: Cannot reach ${API_URL}/${endpoint}` };
        }
    }

    static async get(endpoint) {
        try {
            const response = await fetch(`${API_URL}/${endpoint}`);
            const textResponse = await response.text();
            try {
                return JSON.parse(textResponse);
            } catch (e) {
                console.error("Failed to parse JSON. Raw response from server:", textResponse);
                return { success: false, message: 'Server returned an invalid format' };
            }
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, message: `Network fail: Cannot reach ${API_URL}/${endpoint}` };
        }
    }
}

// Auth Manager
class Auth {
    static login(userData) {
        localStorage.setItem('auth_user', JSON.stringify(userData));
    }

    static logout() {
        localStorage.removeItem('auth_user');
        window.location.href = 'index.html';
    }

    static getUser() {
        return JSON.parse(localStorage.getItem('auth_user') || 'null');
    }

    static checkAuth() {
        const user = this.getUser();
        if (!user && !window.location.pathname.endsWith('index.html') && window.location.pathname !== '/') {
            window.location.href = 'index.html';
        } else if (user && (window.location.pathname.endsWith('index.html') || window.location.pathname === '/')) {
            window.location.href = 'dashboard.html';
        }
        return user;
    }
}

// UI Utilities
class UI {
    static showMessage(elementId, message, type) {
        const el = document.getElementById(elementId);
        if (!el) return;
        el.textContent = message;
        el.className = `messages message-${type}`;
        el.style.display = 'block';
        setTimeout(() => {
            el.style.display = 'none';
        }, 3000);
    }

    static toggleLoading(show) {
        const loadingStr = document.getElementById('loading');
        if (loadingStr) {
            loadingStr.style.display = show ? 'block' : 'none';
        }
    }
    
    static populateUserDetails() {
        const user = Auth.getUser();
        if(user) {
            const nameEl = document.getElementById('user-name');
            if(nameEl) nameEl.textContent = user.name;
        }
    }
}

// Page Specific Logic
document.addEventListener('DOMContentLoaded', () => {
    Auth.checkAuth();
    UI.populateUserDetails();

    // Login Form
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = loginForm.username.value;
            const password = loginForm.password.value;
            
            const btn = loginForm.querySelector('button');
            const originalText = btn.textContent;
            btn.textContent = 'Logging in...';
            btn.disabled = true;

            const res = await ApiService.post('login.php', { username, password });
            
            if (res.success) {
                Auth.login(res.user);
                if (res.user.role === 'student') {
                    window.location.href = 'student_dashboard.html';
                } else {
                    window.location.href = 'dashboard.html';
                }
            } else {
                UI.showMessage('login-msg', res.message || 'Login failed', 'error');
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    }

    // Logout Button
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            Auth.logout();
        });
    }

    // Mark Attendance logic and Reports logic will go into the pages
});
