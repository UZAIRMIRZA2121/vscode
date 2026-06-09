@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head"></h1>
        </section>
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Forgot Password </span>
                </div>
                <p></p>
                <center>
                    @if (session('status'))
                        <div class="alert alert-info fs-4 w-50">
                            {{ session('status') }}
                        </div>
                    @endif

                </center>
                <center>
                    <x-validation-errors id="status-alert" class="mb-4 alert alert-danger fs-4 w-50" />
                </center>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row w-100">
                            <input type="email" placeholder="Enter Email" name="email" :value="old('email')" required
                                autofocus>
                        </div>
                        <center>
                            <div class="row button w-100 btn-sm text-center">
                                <input type="submit" value="Send Link" class="btn-sm">
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <script>
        // Function to fade out the alert after 3 seconds
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var statusAlert = document.getElementById('status-alert');
                var verificationAlert = document.getElementById('verification-alert');
                var alertAlert = document.getElementById('alert');
    
                if (statusAlert) {
                    fadeOut(statusAlert);
                }
                if (verificationAlert) {
                    fadeOut(verificationAlert);
                }
                if (alertAlert) {
                    fadeOut(alertAlert);
                }
            }, 3000);
        });
    
        function fadeOut(element) {
            var opacity = 1;
            var timer = setInterval(function () {
                if (opacity <= 0.1) {
                    clearInterval(timer);
                    element.style.display = 'none';
                }
                element.style.opacity = opacity;
                opacity -= opacity * 0.1;
            }, 100);
        }
    </script>
@endsection
