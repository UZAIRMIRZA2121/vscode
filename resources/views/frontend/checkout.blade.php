@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    @php
        $tracking_code = Str::random(10);

    @endphp
    <main>
        <div class="container" style="margin-top: 200px;">
            <div class="row justify-content-center my-5">
                <div class="col-lg-6  col-sm-6">
                    <form id="orderForm" action="{{ route('order.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tracking_code" value="{{$tracking_code}}">
                        <div class="row">

                            <div class="col-6  ">
                                <div class="form-group">
                                    <label for="exampleInputName">Name:</label>
                                    <input type="text" class="form-control" id="exampleInputName" name="name"
                                        placeholder="Enter your name" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group">
                                    <label for="exampleInputEmail">Email address:</label>
                                    <input type="email" class="form-control" id="exampleInputEmail" name="email"
                                        placeholder="Enter your email" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>                                                                                                                                                                                                                                                  
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="exampleSelectCity">City:</label>
                                    <select class="form-control" id="exampleSelectCity" name="city">
                                        <option value="">Select city</option>
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
                                    <label for="exampleInputEmail">Phone:</label>
                                    <input type="tel" class="form-control" id="exampleInputEmail" name="phone"
                                        placeholder="Enter your Phone" value="{{ Auth::user()->phone }}">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail">Address:</label>
                                    <textarea name="" id="" cols="10" rows="3" type="text" class="form-control" id="exampleInputEmail" name="address"
                                    placeholder="Enter your Address" value="">{{ Auth::user()->address }}</textarea>

                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <h5>Select Payment Method:</h5>
                                    <div class="d-flex">
                                        <label class="mr-3">
                                            <input type="radio" name="payment_method" id="onlinePayment" value="online"
                                                checked>
                                            Online Payment
                                        </label>
                                        <label class="mx-3">
                                            <input type="radio" name="payment_method" id="cashOnDelivery" value="cash">
                                            Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @foreach ($cartItems as $item)
                                <input type="hidden" name="products[{{ $item['product']->id }}][id]"
                                    value="{{ $item['product']->id }}">
                                <input type="hidden" name="products[{{ $item['product']->id }}][quantity]"
                                    value="{{ $item['quantity'] }}">
                            @endforeach
                            <center class="mt-5">
                                <button type="submit" class="btn "
                                    style="    padding: 1.2rem 2.4rem;
                        border-radius: 9px;
                        color: #fff;
                        font-size: 15px;
                        background-color: #66a80f;"id="placeOrderBtn"
                                    type="submit">Place Order</button>
                            </center>



                        </div>

                    </form>
                </div>

                <div class="col-lg-6  col-sm-6">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="row  " style="width: 200% !important">
                                <div class="col-lg-12">
                                    <h3>Receipt</h3>
                                    <hr>
                                    <p class="fs-4"><strong>Date:</strong> {{ date('Y-m-d') }}</p>
                                    <p class="fs-4"><strong>Tracking ID : </strong>{{ $tracking_code }}</p>
                                    <hr>
                                    <table class="table">
                                        <thead>
                                            <tr class="fs-5">
                                                <th>Sr#</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price per Unit</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $grandTotal = 0;
                                            @endphp
                                            @foreach ($cartItems as $item)
                                                @php
                                                    $totalPrice = $item['product']->price * $item['quantity'];
                                                    $grandTotal += $totalPrice;
                                                @endphp
                                                <tr class="fs-4">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item['product']->name }}</td>
                                                    <td>
                                                        <span class="quantity">{{ $item['quantity'] }}</span>
                                                    </td>
                                                    <td>{{ $item['product']->price }}</td>
                                                    <td>{{ $totalPrice }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="fs-4">
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                                <td>{{ $grandTotal }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
