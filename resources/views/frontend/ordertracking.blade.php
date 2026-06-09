@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <style>
        .quantity-form {
            display: inline-block;
        }

        .quantity-container {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            background-color: #4CAF50;
            /* Green background */
            border: none;
            color: white;
            padding: 0px 4px;
            /* Padding */
            text-align: center;
            /* Centered text */
            text-decoration: none;
            /* No decoration */
            display: inline-block;
            /* Make it inline */
            font-size: 16px;
            /* Large font size */
            margin: 4px 2px;
            /* Margin */
            cursor: pointer;
            /* Pointer cursor */
            border-radius: 4px;
            /* Rounded corners */
        }

        .quantity-btn:hover {
            background-color: #45a049;
            /* Darker green */
        }

        .quantity {
            margin: 0 8px;
            /* Margin between buttons */
        }
    </style>
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Cart</h1>
        </section>
        <div class="container">
            <div class="container">
                <div class="wrapper">
                    <div class="title"><span>Track your order</span>
                    </div>
                    <x-validation-errors class="mb-4" />
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($errorMessage))
                    <div class="d-flex justify-content-center">

               
                    <div class="mb-4  alert alert-danger  fs-3 w-50">
                        <p>{{ $errorMessage }}</p>
                    </div>
                </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        <form method="POST" action="{{ route('order.request') }}" class="w-25">
                            @csrf
                            <div class="row w-100">
                                <input type="text" placeholder="Tracking Order" name="tracking_order">
                            </div>
                            <div class="row button w-50">
                                <input type="submit" value="Track">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive ">
                <table class="table custom-table">
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
                        @if (isset($searchorders))
                            {{-- Display search results --}}

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $searchorders->tracking_code }}</td>
                                <td>{{ $searchorders->user->name }}</td>
                                <td>{{ $searchorders->payment_type }}</td>
                                <td>{{ $searchorders->status }}</td>
                                <td>Rs : {{ $searchorders->amount }}</td>
                                <td>{{ $searchorders->updated_at->diffForHumans() }}</td>

                            </tr>
                        @else
                            {{-- Show a simple page --}}
                            <tr>
                                <td colspan="7">No Track order found.</td>
                            </tr>
                         
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
