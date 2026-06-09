@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="text-center">My Profile</h1>
                {{-- <button class="btn btn-success ml-auto m-5">Back</button> --}}
            </div>

        </div>
        <center>
        @if(session('success'))
        <div class="alert alert-success  w-50">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger  w-50">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        

            <span id="password_error" class="alert alert-danger w-50" style="display: none;"></span>
      
        </center>
       
        <div class="container w-75 border p-3">
            <!-- For Create -->

            <!-- Nurse Form -->
            <form action="{{ route('update.admin') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="city">City</label>
                        <select class="form-control" id="city" name="city">
                            <option value="{{Auth::user()->city?? ''}}">{{Auth::user()->city?? 'Select City'}}</option>
                            <option value="Karachi">Karachi</option>
                            <option value="Lahore">Lahore</option>
                            <option value="Islamabad">Islamabad</option>
                            <option value="Faisalabad">Faisalabad</option>
                            <option value="Rawalpindi">Rawalpindi</option>
                            <option value="Multan">Multan</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="Gujranwala">Gujranwala</option>
                            <option value="Peshawar">Peshawar</option>
                            <option value="Quetta">Quetta</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="">
                        </div>
                 
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" value="">
                         
                        </div>
                    </div>
                    
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>



        </div>
    </div>


    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var city = document.getElementById("city").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var passwordError = document.getElementById("password_error");
    
            if (name === "" || email === "" || city === "" || phone === "") {
                alert("All fields are required");
                return false;
            }
    
            if (password !== "" || confirm_password !== "") {
                if (password.length < 8) {
                    passwordError.innerText = "Password must be at least 8 characters long";
                    passwordError.style.display = "block";
                    return false;
                }
                if (password !== confirm_password) {
                    passwordError.innerText = "Passwords do not match";
                    passwordError.style.display = "block";
                    return false;
                }
            }
    
            passwordError.style.display = "none";
            return true;
        }
    
        // Validate password on keyup event
        document.getElementById("password").addEventListener("keyup", function() {
            var password = document.getElementById("password").value;
            var passwordError = document.getElementById("password_error");
    
            if (password.length < 8 && password !== "") {
                passwordError.innerText = "Password must be at least 8 characters long";
                passwordError.style.display = "block";
            } else {
                passwordError.style.display = "none";
            }
        });
    
        // Confirm password validation on keyup event
        document.getElementById("confirm_password").addEventListener("keyup", function() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var passwordError = document.getElementById("password_error");
    
            if (password !== confirm_password && confirm_password !== "") {
                passwordError.innerText = "Passwords do not match";
                passwordError.style.display = "block";
            } else {
                passwordError.style.display = "none";
            }
        });
    </script>
    
    
@endsection
