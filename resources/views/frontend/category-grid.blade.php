@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
<style>
    /* Adjust the sidebar style as needed */
    .sidebar1 {
        /* position: fixed; */
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .sidebar1-heading {
        text-align: center;
        /* padding: 10px 15px; */
    }

    .sidebar1 ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar1 ul li {
        font-size: 16px;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
    }

    .sidebar1 ul li a {
        color: #333;
        text-decoration: none;
    }

    .sidebar1 ul li a:hover {
        color: #007bff;
    }

    /* Active class */
    .sidebar1 ul li a.active {
        color: #00b4d8; /* Change to the desired color */
        font-weight: bold; /* Optionally, make the active link bold */
    }
</style>

    <main>
        <section class="fleet-hero hero-section">
            <h1 class="hero-head fleet-head">Category {{ $category_name }}</h1>
            <p class="hero-para">A porfolio of our services <br> at your doorstep.</p>
            {{-- <div class="fleet-btn-div">
                <a href="#" class="fleet-btn ">See Featured Categories</a>
            </div> --}}

        </section>
        <section class="mx-5 py-5">

            <div class="row">
                    <!-- Sidebar -->
                    <nav class="col-sm-12 col-md-3 col-lg-2 d-md-block sidebar1">
                        <div class="sidebar-heading">
                            <h2>All Categories</h2>
                        </div>
                        <ul class="nav flex-column">
                            @foreach ($maincategories as $maincategory)
                                <li class="nav-item">
                                    <a class="nav-link {{ $maincategory->id == $selectedCategoryId ? 'active' : '' }}" href="{{ route('category', ['category' => $maincategory->id]) }}" onclick="slideListItem(this)">
                                        {{ $maincategory->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                   
                <div class="row pt-5 col-sm-12 col-md-9 col-lg-10">
                    <h1 class="py-5">{{ $category_name }}'s <b>Products</b></h1>
                    @if (!$products->isNotEmpty())
                    <center>
                        <div  class="alert alert-danger fs-4 w-50">
                            There are no products in this category
                        </div>
                    </center>
                    @else
                    <div class="row">
                        
                     @forelse ($products as $product)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="{{ route('product', ['product' => $product->id]) }}" class="thumb-wrapper-link">
                                    <div class="thumb-wrapper">
                                        @if ($product->discount)
                                            <span class="sale-label" style="top:80px;">Sale {{ $product->discount }}%</span>
                                        @endif
                                        <div class="img-box">
                                            <img src="{{ asset($product->img) }}" class="img-fluid" alt="Apple iPad">
                                        </div>
                                        <div class="thumb-content">
                                            <h4>{{ $product->name }}</h4>
                                            @if ($product->pres == 1)
                                                <p class="item-price">Prescription <b class="text-danger">Required</b></p>
                                            @endif
                                             @if ($product->formula)
                                                <p class="item-price">
                                                  Formula: <b> {{ $product->formula }}</b>
                                                </p>
                                                @endif
                                            @if ($product->discount)
                                                <p class="item-price">
                                                    <strike>Rs. {{ $product->price }}</strike> <b>Rs. {{ $product->price - $product->price * ($product->discount / 100) }}</b>
                                                </p>
                                            @else
                                                <p class="item-price"><b>Rs.{{ $product->price }}</b></p>
                                            @endif
                                            <a href="{{ route('product', ['product' => $product->id]) }}" class="btn">Details</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>No products found.</p>
                            </div>
                        @endforelse
                        
                    @endif
                    </div>
                 <div class="d-flex justify-content-center">
                    <div class="pagination">
                        @if ($products->onFirstPage())
                            <span class="btn btn-secondary disabled">Previous</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                        @endif
                
                        {{-- Pagination elements --}}
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <span class="page-number mx-2">
                                <a href="{{ $products->url($i) }}" class="btn btn-outline-primary {{ $products->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                            </span>
                        @endfor
                
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="btn btn-primary">Next</a>
                        @else
                            <span class="btn btn-secondary disabled">Next</span>
                        @endif
                    </div>
                </div>



                </div>
            </div>
        </section>

    </main>
@endsection
