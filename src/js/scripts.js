document.addEventListener('DOMContentLoaded', function () {
    // Handle login form submission
    document.querySelector('#login-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append('action', 'login');

        axios.post('api/users.php ', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Login successful');
                    window.location.href = '/';
                }
            })
            .catch(error => alert('Error: login failed'));
    });

    // Handle register form submission
    document.querySelector('#register-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const password = document.querySelector('#passwordregister').value;
        const confirmPassword = document.querySelector('#passwordregisterconfirm').value;

        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }

        const formData = new FormData(event.target);
        formData.append('action', 'register');

        axios.post('api/users.php', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Registration successful');
                    window.location.href = '/';
                }
            })
            .catch(error => console.error('Error:', error));
    });

    const logout = document.querySelector('.logout') || null;

    if (logout) {
        logout.addEventListener('click', function () {
            axios.post('api/users.php', new URLSearchParams({ action: 'logout' }))
                .then(response => {
                    const data = response.data;
                    if (data.status === 'success') {
                        alert('Logout successful');
                        window.location.href = '/';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});