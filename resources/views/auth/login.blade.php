@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head"></h1>
        </section>
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Sign In </span>
                </div>
                <center>
                <x-validation-errors id="status-alert" class="mb-4 alert alert-danger fs-4 w-50" />

                </center>
                @if (session('status'))
                    <center>
                        <div id="status-alert" class="alert alert-success fs-4 w-50">
                            {{ session('status') }}
                        </div>
                    </center>
                @endif
                @if (session('verification_message'))
                    <center>
                        <div id="verification-alert" class="alert alert-info fs-4 w-50">{{ session('verification_message') }}
                        </div>
                    </center>
                @endif
                @if (session('alert'))
                    <center>
                        <div id="alert" class="alert alert-danger fs-4 w-50">
                            {{ session('alert') }}
                        </div>
                    </center>
                @endif
                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('login') }}" class="w-25">
                        @csrf
                        <div class="row w-100">
                            <input type="email" placeholder="Email or Phone" name="email" :value="old('email')"
                                required autofocus>
                        </div>
                        <div class="row w-100">
                            <input type="password" placeholder="Password" name="password" required
                                autocomplete="current-password">
                        </div>
                        @if (Route::has('password.request'))
                        <div class="pass"><a  href="{{ route('password.request') }}">Forgot password?</a></div>
                        @endif
                        <center>
                            <div class="row button w-50 btn-sm text-center">
                                <input type="submit" value="Login">
                            </div>
                        </center>

                        <div class="signup-link">Not a member? <a href="{{ route('register') }}">Signup now</a></div>
                    </form>
                </div>
            </div>
        </div>
    </main>


@endsection
