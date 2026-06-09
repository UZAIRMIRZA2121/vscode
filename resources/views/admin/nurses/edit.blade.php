@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Nurse</h1>
                <button class="btn btn-success ml-auto m-5">Back</button>
            </div>

        </div>

        <div class="container w-75 border p-3">
            <!-- For Create -->
          <!-- Nurse Update Form -->
<form action="{{ route('nurses.update', $nurse->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="form-group col-lg-6 col-sm-12">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $nurse->name }}">
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="qualification">Qualification</label>
            <input type="text" class="form-control" id="qualification" name="qualification" value="{{ $nurse->qualification }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-sm-12">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="Male" {{ $nurse->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $nurse->gender === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $nurse->date_of_birth }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-sm-12">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $nurse->phone }}">
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $nurse->email }}">
        </div>
       
    </div>
    <div class="row">
        
          <div class="form-group col-lg-6 col-sm-12">
                        <label for="nurseType">Nurse Type</label>
                        <input type="text" class="form-control" id="nurseType" name="type" value="{{ $nurse->type }}">
                    </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6 col-sm-12">
            <label for="img">Image</label>
            <input type="file" class="form-control" id="img" name="img">
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="hourly_rate">Hourly Rate</label>
            <input type="number" class="form-control" id="hourly_rate" name="hourly_rate" value="{{ $nurse->hourly_rate }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-sm-12">
            <label for="experience_years">Experience Years</label>
            <input type="number" class="form-control" id="experience_years" name="experience_years" value="{{ $nurse->experience_years }}">
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <label for="specialization">Specialization</label>
            <input type="text" class="form-control" id="specialization" name="specialization" value="{{ $nurse->specialization }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12">
            <label for="address">Description</label>
            <textarea class="form-control" id="address" name="desc">{{ $nurse->desc }}</textarea>
        </div>
        <div class="form-group col-lg-12">
            <label for="address">Current Image</label> <br>
            <img src="{{ asset($nurse->img) }}" alt="{{ $nurse->img }}" width="200">

        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>




        </div>
    </div>



@endsection
