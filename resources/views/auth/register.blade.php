@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
<main>
    <section class="fleet-hero hero-section boat-section">
        <h1 class="hero-head fleet-head"></h1>
    </section>
    <div class="container">
        <div class="wrapper">
            <div class="title"><span>Sign up <br></span></div>
            <x-validation-errors class="mb-4" />
            @if (session('alert'))
            <center>
                <div id="alert" class="alert alert-danger fs-4 w-50">
                    {{ session('alert') }}
                </div>
            </center>
            @endif
            <center>
                <p id="password_error" class="alert alert-danger fs-3 my-1 w-50" style="display: none;">Passwords do not match or must be at least 8 characters long.</p>
                <p id="email-error" class="alert alert-danger fs-3 my-1 w-50" style="display: none;">Email already exists</p>
            </center>
            <div class="d-flex justify-content-center">
                <form method="POST" action="{{ route('register.user') }}" class="w-25" onsubmit="return validateForm(event)">
                    @csrf
                    <div class="row">
                        <input type="text" placeholder="Username" name="name" :value="old('name')" required autofocus autocomplete="name">
                    </div>
                    <div class="row">
                        <input type="email" placeholder="Email or Phone" id="email" name="email" :value="old('email')" required autofocus>
                    </div>
                    <div class="row">
                        <input type="password" placeholder="Password" name="password" id="password" required autocomplete="new-password" onkeyup="validatePasswords()">
                    </div>
                    <div class="row">
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" id="confirm_password" required autocomplete="new-password" onkeyup="validatePasswords()">
                    </div>
                    <center>
                        <div class="row button w-50 btn-sm">
                            <input id="submitBtn" type="submit" value="Register">
                        </div>
                    </center>
                    <div class="signup-link">Already have an account? <a href="{{ route('login') }}">Sign In now</a></div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById('email').addEventListener('keyup', function() {
        var email = this.value;
        var emailError = document.getElementById('email-error');
        var submitBtn = document.getElementById('submitBtn');

        // Send AJAX request
        fetch('{{ route('check-email') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                emailError.style.display = 'block';
                submitBtn.disabled = true; // Disable submit button if email exists
            } else {
                emailError.style.display = 'none';
                submitBtn.disabled = false; // Enable submit button if email doesn't exist
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function validatePasswords() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var passwordError = document.getElementById('password_error');
        var submitBtn = document.getElementById('submitBtn');

        if (password !== confirmPassword || password.length < 8 || confirmPassword.length < 8) {
            passwordError.style.display = 'block';
            submitBtn.disabled = true; // Disable submit button if passwords do not match or length is less than 8 characters
            if (password.length < 8 || confirmPassword.length < 8) {
                passwordError.innerText = "Passwords must be at least 8 characters long.";
            } else {
                passwordError.innerText = "Passwords do not match!";
            }
        } else {
            passwordError.style.display = 'none';
            submitBtn.disabled = false; // Enable submit button if passwords match and are at least 8 characters long
        }
    }

    function validateForm(event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var passwordError = document.getElementById('password_error');

        if (password !== confirmPassword || password.length < 8 || confirmPassword.length < 8) {
            passwordError.style.display = 'block';
            event.preventDefault(); // Prevent form submission if passwords do not match or length is less than 8 characters
            if (password.length < 8 || confirmPassword.length < 8) {
                passwordError.innerText = "Passwords must be at least 8 characters long.";
            } else {
                passwordError.innerText = "Passwords do not match!";
            }
        }
    }
</script>
@endsection
