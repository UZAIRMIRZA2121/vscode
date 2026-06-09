@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')

    <main>
        <section class="fleet-hero">
           
        </section>
      
        <section class="container py-3 my-5 ">
            <div class="row ">
                <!-- Sidebar -->
                <div class="col-2">
                    @include('layout.frontend.user-sidebar')
                </div>
                <!-- Main Content -->
                <div class="col-10 border border-1">
                    <div class="container w-100">
                        <h2>Profile</h2>
                        @if(session('success'))
                        <div id="successMessage" class="alert alert-success fs-2 text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div id="errorMessage" class="alert alert-danger fs-2 text-center">
                            {{ session('error') }}
                        </div>
                    @endif
                        <form action="{{ route('dashboard.update') }}" method="POST"  onsubmit="submitForm(event)">
                            
                            @csrf
                            <div class="row">
                                <div class="col-6  ">
                                    <div class="form-group">
                                        <label for="exampleInputName">Name:</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name"
                                            placeholder="Enter your name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Email address:</label>
                                        <input type="email" class="form-control" id="exampleInputEmail" name="email"
                                            placeholder="Enter your email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleSelectCity">City:</label>
                                        <select class="form-control" id="exampleSelectCity" name="city">
                                            <option value="{{ Auth::user()->city }}">{{ Auth::user()->city }}</option>
                                            <option value="karachi">Karachi</option>
                                            <option value="lahore">Lahore</option>
                                            <option value="islamabad">Islamabad</option>
                                            <option value="rawalpindi">Rawalpindi</option>
                                            <option value="faisalabad">Faisalabad</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Address:</label>
                                        <input type="text" class="form-control" id="exampleInputEmail" name="address"
                                            placeholder="Enter your Address" value="{{ Auth::user()->address }}">
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Phone:</label>
                                        <input type="tel" class="form-control" id="exampleInputEmail" name="phone"
                                            placeholder="Enter your Phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputNewPassword">New Password:</label>
                                        <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter your new password" onkeyup="checkPasswordsOnKeyup()">
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword">Confirm Password:</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm your new password" onkeyup="checkPasswordsOnKeyup()">
                                    </div>
                                    <div id="passwordError" class="text-danger fs-3" ></div>
                                </div>
                                
                            </div>
                            <center>
                            <button type="submit" class="obj-btn w-25 mt-3">Update</button>

                            </center>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
  
    
    <script>
        // Function to check if passwords match and are not empty
        function checkPasswords() {
            var newPassword = document.getElementById("newPassword").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
    
            if (newPassword === confirmPassword) {
                // Passwords match, clear error message and return true
                document.getElementById("passwordError").innerText = "";
                return true;
            } else {
                // Passwords don't match, show error message and return false
                document.getElementById("passwordError").innerText = "Passwords do not match!";
                return false;
            }
        }
    
        // Function to handle form submission
        function submitForm(event) {
            // Check passwords before form submission
            if (!checkPasswords()) {
                // Prevent form submission if passwords don't match
                event.preventDefault();
            }
        }
    </script>
    

    
    
    
@endsection
