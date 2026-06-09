@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <div class="ag-format-container">
            <div class="ag-courses_box">
                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Total Categories
                        </div>
                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $categories->count() }}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Total Products
                        </div>
                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $products->count() }}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Total Users
                        </div>
                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $users->where('role','=', 'user')->count() }}
                            </span>
                        </div>
                    </a>
                </div>


                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Total orders
                        </div>
                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $orders->count() }}
                            </span>
                        </div>
                    </a>
                </div>

                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Pending Orders
                        </div>

                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $orders->where('status', 'pending')->count() }}

                            </span>
                        </div>
                    </a>
                </div>

                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Total Nurses
                        </div>

                        <div class="ag-courses-item_date-box">
                            <span class="ag-courses-item_date">
                                {{ $nurses->count() }}
                            </span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
        <center>
            @if (session('success'))
                <div id="success-alert" class="alert alert-success fs-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div id="error-alert" class="alert alert-danger fs-3">
                    {{ session('error') }}
                </div>
            @endif
        </center>

        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Orders</h1>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Tracking ID</th>
                        <th scope="col">User</th>
                        <th scope="col">Payment type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp

                    @if (isset($orders) && count($orders) > 0)
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $order->tracking_code }}</td>
                                <td>{{ optional($order->user)->name }}</td><!-- Moved this line inside the loop -->
                                <td>{{ $order->payment_type }}</td>
                                <td>
                                    @if ($order->status === 'pending')
                                        <span class="badge badge-warning">{{ $order->status }}</span>
                                    @elseif($order->status === 'accepted')
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                    @elseif($order->status === 'Paid')
                                    <span class="badge badge-info">{{ $order->status }}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $order->status }}</span>

                                    @endif


                                </td>
                                <td> Rs : <b>{{ $order->amount }}</b></td>
                                <td>
                                    @if ($order->payment_type == 'cash' && $order->status === 'pending')
                                        <a class="btn btn-success btn-sm mx-2"
                                            href="{{ route('order.request.accept', $order->id) }}">Accept</a>
                                        <a class="btn btn-danger btn-sm mx-2"
                                            href="{{ route('order.request.reject', $order->id) }}">Rejected</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">No orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            </table>
        </div>
    </div>
    <script>
        // Function to hide the success and error messages after 4 seconds
        setTimeout(function() {
            var successAlert = document.getElementById("success-alert");
            if (successAlert) {
                successAlert.style.display = "none";
            }

            var errorAlert = document.getElementById("error-alert");
            if (errorAlert) {
                errorAlert.style.display = "none";
            }
        }, 4000);
    </script>

@endsection
