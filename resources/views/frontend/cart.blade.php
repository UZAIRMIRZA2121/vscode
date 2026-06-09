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
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th class="text-left">Sr.no</th>
                            <th>Product Category</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($cartItems) && count($cartItems) > 0)
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['product']->category->name }}</td>
                                    <td>{{ $item['product']->name }}</td>
                                    <td>
                                        <form action="{{ route('update.product.quantity') }}" method="post"
                                            class="quantity-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                            <div class="quantity-container">
                                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                                    class="quantity-btn">-</button>
                                                <span class="quantity">{{ $item['quantity'] }}</span>
                                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                    class="quantity-btn">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ $item['product']->price * $item['quantity'] }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                            <button type="submit" class="btn btn-danger remove-btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">There are no products in your cart</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if (isset($cartItems) && count($cartItems) > 0)
                    <a href="{{ route('checkout') }}" class="btn"
                        style="padding: 1.2rem 2.4rem; border-radius: 9px; color: #fff; font-size: 15px; background-color: #66a80f;"
                        id="placeOrderBtn">Checkout</a>
                @endif
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the button element
            const placeOrderBtn = document.getElementById('placeOrderBtn');

            // Add event listener to the button
            placeOrderBtn.addEventListener('click', function() {
                // Get the form element
                const orderForm = document.getElementById('orderForm');

                // Submit the form
                orderForm.submit();
            });
        });
    </script>
@endsection
