@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="text-center">Nurse</h1>
                <button class="btn btn-success ml-auto m-5">Back</button>
            </div>

        </div>

        <div class="container w-75 border p-3">
            <!-- For Create -->

            <!-- Nurse Form -->
            <form action="{{ route('nurses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="qualification">Qualification</label>
                        <input type="text" class="form-control" id="qualification" name="qualification" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                </div>
                <div class="row">
                       <div class="form-group col-lg-6 col-sm-12">
                        <label for="nurseType">Nurse Type</label>
                        <input type="text" class="form-control" id="nurseType" name="type" value="">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="img">Image</label>
                        <input type="file" class="form-control" id="img" name="img" value="">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="price">Price/Hour</label>
                        <input type="number" class="form-control" id="price" name="hourly_rate" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="experience_years">Experience years</label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years"
                            value="">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="specialization">Specialization</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="address">Description</label>
                        <textarea class="form-control" id="address" name="desc"></textarea>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>




        </div>
    </div>



@endsection
