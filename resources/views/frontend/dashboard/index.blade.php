@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <style>
        /* Updated CSS for the sidebar */
        .sidebar {
            height: 594px;
            width: 200px;

            z-index: 1;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
        }

        .sidebar a:hover {
            background-color: #ddd;
        }

        /* Adjusting main content margin to accommodate the sidebar */
        .col-10 {
            margin-left: 200px;
            /* Width of the sidebar */
        }

        .form-control {
            font-size: 2rem !important;
        }

        label {
            display: inline-block;
            font-size: large;
        }
        .fleet-hero{
            height: 88px;
        }
    </style>
    <main class="">
        <section class="fleet-hero">
           
        </section>
        <section class="container py-3 my-5">
            <div class="row ">
                <!-- Sidebar -->
                <div class="col-3">
                  @include('layout.frontend.user-sidebar')
                </div>
                <!-- Main Content -->
                <div class="col-9 border border-1">
                    <div class="">
                        <h1>Profile</h1>
                            <div class="row">
                                <div class="col-5 m-5 ">
                                    <div class="form-group">
                                        <label for="exampleInputName">Name: <b>{{ Auth::user()->name }}</b></label>                       
                                    </div>
                                </div>
                                <div class="col-5 m-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Email address: <b>{{ Auth::user()->email }}</b> </label>
                                       
                                    </div>
                                </div>
                                <div class="col-5 m-5">
                                    <label for="exampleInputEmail">City: {{ Auth::user()->city?? 'NULL' }}<b></b></label>
                                </div>
                                
                                <div class="col-5 m-5">
                                    <div class="form-group">
                                    <label for="exampleInputEmail">Address: {{ Auth::user()->address ?? 'NULL' }} <b></b></label>
                                    </div>
                                </div>
                                <div class="col-5 m-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Phone: {{ Auth::user()->phone ?? 'NULL'}}<b></b></label>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ route('dashboard.edit') }}" class="btn btn-primary btn-lg m-3">Edit</a> 
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
