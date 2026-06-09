@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section">
            @if (isset($searchdata) && $searchdata == 1)
           <h1 class="hero-head fleet-head">Searched Products</h1>
            @else
            <h1 class="hero-head fleet-head">All Products</h1>
            @endif
           
            <p class="hero-para">A porfolio of our services <br> at your doorstep.</p>
            <div class="fleet-btn-div">
                <a href="{{route('home')}}" class="fleet-btn ">See Featured Products</a>
            </div>

        </section>
        <section class="container py-5">
            <div class="row ">
                @if (session('success'))
                    <div id="Message" class="alert alert-success container" style="margin-top: 40px;
    font-size: 22px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div id="Message" class="alert alert-danger container" style="margin-top: 40px;
    font-size: 22px;">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row pt-5">
                    @if (isset($searchdata) && $searchdata == 1)
                    <h1 class="py-5">Searched <b>Products</b></h1>
                    @else
                    <h1 class="py-5">Featured <b>Products</b></h1>
                    @endif
                    
                    <div class="row ">
                        @if ($products !=null)
                      
                            @foreach ($products as $product)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                                    <a href="{{ route('product', ['product' => $product->id]) }}"
                                        class="thumb-wrapper-link">
                                        <div class="thumb-wrapper">
                                            @if ($product->discount)
                                                <span class="sale-label" style="top:80px;">Sale
                                                    {{ $product->discount }}%</span>
                                            @endif
                                            <div class="img-box">
                                                <img src="{{ asset($product->img) }}" class="img-fluid" alt="Apple iPad">
                                            </div>
                                        </a>
                                            <div class="thumb-content">
                                                <h4>{{ $product->name }}</h4>
                                                @if ($product->pres == 1)
                                                    <p class="item-price">Prescription <b class="text-danger">Required</b>
                                                    </p>
                                                @endif
                                                  @if ($product->formula)
                                                    <p class="item-price">Formula: <b class="text-danger">{{ $product->price }}</b>
                                                    </p>
                                                @endif
                                                @if ($product->discount)
                                                    <p class="item-price"><strike>Rs. {{ $product->price }}</strike> <b>Rs.
                                                            {{ $product->price - $product->price * ($product->discount / 100) }}</b>
                                                    </p>
                                                @else
                                                    <p class="item-price"> <b>Rs.{{ $product->price }}</b>
                                                    </p>
                                                @endif
    
                                                @if (Auth::check())
                                                    @if ($product->pres == 0)
                                                    <a href="{{ route('product', ['product' => $product->id]) }}" class="btn">Details</a>
                                                    @else
                                                        <a type="button" class="btn"
                                                            data-product-id="{{ $product->id }}" data-toggle="modal"
                                                            data-target="#prescriptionModal">
                                                            Submit Prescription
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="btn ">Add to Cart</a>
                                                @endif


                                            </div>
                                        </div>
                                   
                                </div>
                            @endforeach
                        @else
                        <center>
                            <div  class="alert alert-danger fs-4 w-50">
                                There are no Searched products
                            </div>
                        </center>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="obj-mbtn " style="height: 25px !important">&laquo; Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $products->previousPageUrl() }}" class="obj-mbtn" rel="prev"
                                        style="height: 25px !important">&laquo;
                                        Previous</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a href="{{ $products->nextPageUrl() }}" class="obj-mbtn" rel="next"
                                        style="height: 25px !important">Next
                                        &raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="obj-mbtn" style="height: 25px !important">Next &raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection
