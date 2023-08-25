@extends('layouts.auth')

@section('auth-title', 'Login')

@section('content')
    <form class="mt-3" id="loginForm" method="POST">
        @csrf
        <div class="error-container" id="errorContainer"></div>
        <div class="form-group mb-3">
            <label for="loginEmail">Email</label>
            <input type="email" class="form-control" id="loginEmail" placeholder="Enter email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="loginPassword">Password</label>
            <input type="password" class="form-control" id="loginPassword" placeholder="Enter Password" name="password"
                required>
        </div>
        <span>
            Don't have an account yet? <a href="{{ url('/register') }}">Register</a>
        </span>
        <button type="submit" class="btn btn-primary d-block mx-auto mt-4">Login</button>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');

            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Get the formData
                const formData = new FormData(loginForm);

                // Loading while submitting form data
                const inputs = loginForm.querySelectorAll('input');
                inputs.forEach(input => {
                    input.disabled = true;
                });
                // Load and disabled the button
                const submitBtn = loginForm.querySelector('button[type=submit]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `;

                try {
                    const response = await fetch('/api/login', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        localStorage.setItem('access_token', JSON.stringify(data.token));
                        window.location.href = loginForm.action;
                    } else {
                        const errorContainer = document.getElementById('errorContainer');
                        errorContainer.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" id="errorMessage">
                            ${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    }
                } catch (error) {
                    console.error(error);
                }

                // Remove disabled
                inputs.forEach(input => {
                    input.disabled = false;
                });
                submitBtn.innerHTML = 'Login';
                submitBtn.disabled = false;
            });
        });
    </script>
@endsection
