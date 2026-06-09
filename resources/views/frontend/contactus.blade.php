@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Contact Us</h1>
        </section>
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Contact us </span>
                </div>
                <center>
                @if (session('success'))
                    <div class="alert alert-success container" style="margin-top: 40px;
                    font-size: 22px;">
                        {{ session('success') }}
                    </div>
                @endif
            </center>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row w-100">
                            <div class="col-6">
                                <input type="text" placeholder="Name" name="name" required autofocus>
                            </div>
                            <div class="col-6">
                                <input type="email" placeholder="Email" name="email" required autofocus>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-6">
                                <input type="text" placeholder="Subject" name="subject" required autofocus>
                            </div>
                            <div class="col-6">
                                <input type="tel" placeholder="Phone" name="number" required autofocus>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-12">
                                <textarea name="msg" id="" cols="30" rows="3" placeholder="Enter your Message" required></textarea>
                            </div>
                        </div>
                        <div class="row button w-50 btn-sm text-center my-5" style="top:40px">
                            <input type="submit" value="Submit">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>


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
