@extends('layouts.auth')

@section('auth-title', 'Register')

@section('content')
    <form id="registerForm">
        <div class="error-container" id="errorContainer"></div>
        <div class="form-group mb-3">
            <label for="registerName">Name</label>
            <input type="text" name="name" id="registerName" class="form-control" placeholder="Enter name" required>
        </div>
        <div class="form-group mb-3">
            <label for="registerEmail">Email</label>
            <input type="email" name="email" id="registerEmail" class="form-control" placeholder="Enter email" required>
        </div>
        <div class="form-group mb-3">
            <label for="registerPassword">Password</label>
            <input type="password" name="password" id="registerPassword" class="form-control" placeholder="Enter password"
                required>
        </div>
        <div class="form-group mb-3">
            <label for="registerConfirmPassword">Confirm Password</label>
            <input type="password" name="confirm_password" id="registerConfirmPassword" class="form-control"
                placeholder="Confirm password" required>
        </div>
        <span>Already have an account? <a href="{{ url('/login') }}">Login now</a></span>
        <button type="submit" class="btn btn-primary d-block mx-auto mt-4">Register</button>
    </form>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const registerForm = document.getElementById('registerForm');

            registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Get the formData
                const formData = new FormData(registerForm);

                // Loading while submitting form data
                const inputs = registerForm.querySelectorAll('input');
                inputs.forEach(input => {
                    input.disabled = true;
                });
                // Load and disabled the button
                const submitBtn = registerForm.querySelector('button[type=submit]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `;

                try {
                    const response = await fetch('/api/register', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        localStorage.setItem('access_token', JSON.stringify(data.token));
                        window.location.href = '/';
                    } else {
                        const errorContainer = document.getElementById('errorContainer');
                        errorContainer.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" id="errorMessage">
                                ${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.log(error);
                };

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
