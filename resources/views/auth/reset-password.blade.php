@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Account</h1>
        </section>
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Sign In <br>
                        To Your Account</span>
                </div>
                <center>
                    <x-validation-errors id="status-alert" class="mb-4 alert alert-danger fs-4 w-50" />
                </center>

                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf
                        <div class="row">
                            <input type="email"  id="email" placeholder="Email or Phone" name="email" value="{{ $request->email }}"
                            required autofocus autocomplete="username" readonly>
                        </div>
                    
                        <div class="row">
                            <input type="password" placeholder="Password" name="password" id="password" required autocomplete="current-password">
                        </div>
                        <div class="row">
                            <input type="password" placeholder="Confirm Password" name="password_confirmation" id="confirm_password" required autocomplete="new-password" onkeyup="validatePasswords()">
                        </div> 
                            <p id="password_confirmation_error" style="color: red; font-size:14px"></p>
                        <center>
                            <div class="row button w-50 btn-sm text-center">
                                <input type="submit" value="Reset">
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
      function validatePasswords() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        // Check if passwords match
        if (password === confirmPassword) {
            // Passwords match, clear any custom validation message
            document.getElementById("password_confirmation_error").innerHTML = '';
        } else {
            // Passwords do not match, display custom validation message
            document.getElementById("password_confirmation_error").innerHTML = "Passwords do not match";
        }
    }
    </script>

    <script>
        // Function to hide the alert after 5 seconds
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var statusAlert = document.getElementById('status-alert');
                var verificationAlert = document.getElementById('verification-alert');
                var alertAlert = document.getElementById('alert');

                if (statusAlert) {
                    statusAlert.style.display = 'none';
                }
                if (verificationAlert) {
                    verificationAlert.style.display = 'none';
                }
                if (alertAlert) {
                    alertAlert.style.display = 'none';
                }
            }, 3000);
        });
    </script>
    
@endsection
