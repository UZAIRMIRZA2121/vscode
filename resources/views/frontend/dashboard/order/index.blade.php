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
               
                        <h1 class="fs-1 text-center">My Orders</h1>
                        <div class="table-responsive ">
                            
                            <table class="table custom-table">
                                <h1 class="fs-3 ">Total Order : {{$orders->count()}}</h1>
                                <thead>
                                    <tr>
                                        <th class="text-left">Sr.no</th>
                                        <th>Tracking Code</th>
                                        <th>Name</th>
                                        <th>Payment Type</th>
                                        <th>Order Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if (isset($orders))
                                        {{-- Display search results --}}
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $order->tracking_code }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->payment_type }}</td>
                                            <td >
                                                @if($order->status == 'pending')
                                                <span class="text-danger">{{ $order->status }}</span>
                                                @elseif($order->status == 'processing')
                                                <span class="text-info">{{ $order->status }}</span>
                                                @else
                                                <span class="text-success">{{ $order->status }}</span>
                                                @endif
                                            
                                            </td>
                                            <td>Rs : {{ $order->amount }}</td>
                                            <td>{{ $order->updated_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        {{-- Show a simple page --}}
                                        <tr>
                                            <td colspan="7">No ypur order found.</td>
                                        </tr>
                                     
                                    @endif
                                </tbody>
                            </table>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($orders->onFirstPage())
                                        <li class="page-item d-none">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $orders->previousPageUrl() }}" class="page-link" rel="prev"> < Previous</a>
                                        </li>
                                    @endif
                            
                                    {{-- Next Page Link --}}
                                    @if ($orders->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $orders->nextPageUrl() }}" class="page-link" rel="next">Next > </a>
                                        </li>
                                    @else
                                        <li class="page-item d-none">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                         
                    </div>
                   
                </div>
               
                
        </section>
    </main>
@endsection
