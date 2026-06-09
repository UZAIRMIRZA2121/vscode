@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')


    <main>
        <section class="hero-section section-hero">
            <div class="hero-flex">
                <h1 class="hero-head">Life is better <br>
                    when we're here</h1>
                <p class="hero-para">We're always here
                    at your service.
                </p>
                
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($categories as $key => $category)
                        <div class="carousel-item @if ($key === 0) active @endif">
                            <a href="{{ route('category', ['category' => $category->main_category_id]) }}">
                                <img src="{{ asset($category->img) }}" class="d-block w-100" alt="..." height="500">
                                <div class="carousel-caption d-none d-md-block text-dark fs-1">
                                    <h1>{{ $category->name }}</h1>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>


        </section>

        <section class="container position-relative pt-5">
            <div class="slider-container pt-5">
                <h1 class="text-dark text-center mb-5" style=""> <b>Category</b></h1>
                <div class="slider-inner">
                    @foreach ($categories as $category)
                        <div class="slider-item ">
                            <div class="card-hover">
                                <div class="card-hover__content">
                                    <h3 class="card-hover__title">
                                        {{ $category->name }}
                                    </h3>
                                    <a href="{{ route('category', ['category' => $category->main_category_id]) }}"
                                        class="card-hover__link">
                                        <span>Check Now</span>
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                                <img src="{{ asset($category->img) }}" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="prev"><ion-icon class="icon" id="prevBtn" name="arrow-back"></ion-icon></button>
                <button class="next"><ion-icon class="icon" name="arrow-forward" id="nextBtn"></ion-icon></button>

            </div>
        </section>
        <style>

        </style>
        <section class="container py-5">

            <div class="row ">
                <div class="row pt-5">
                    @if ($products_discount->whereNotNull('discount'))
                        <h1 class="py-5">Sale  <b>Products</b></h1>

                        <div class="row ">
                            @foreach ($products_discount as $product)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                                    <a href="{{ route('product', ['product' => $product->id]) }}"
                                        class="thumb-wrapper-link">
                                        <div class="thumb-wrapper">
                                            <span class="sale-label mt-3">Sale {{ $product->discount }}%</span>
                                            <div class="img-box">
                                                <img src="{{ asset($product->img) }}" class="img-fluid" alt="Apple iPad">
                                            </div>
                                            <div class="thumb-content">
                                                <h4>{{ $product->name }}</h4>
                                               <p>
                                                    {{ \Illuminate\Support\Str::limit($product->desc, 60, '...') }}
                                                </p>
                                                @if ($product->pres == 1)
                                                    <p class="item-price">Prescription <b class="text-danger">Required</b>
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
                                                   @if ($product->formula)
                                                   <p class="item-price">Formula: <b>{{ $product->formula }}</b>
                                                    </p>
                                                @endif
                                                @if (Auth::check())
                                                    @if ($product->pres == 0)
                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <button type="submit" class="btn">Add to Cart<ion-icon
                                                                    name="cart"></ion-icon></button>
                                                        </form>
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
                                    </a>
                                </div>
                            @endforeach

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
                    @endif
                </div>
            </div>
        </section>
        <section class="objectives">
            <h1 class="obj-mhead">Products</h1>
            <div class="obj-grid">
                @foreach ($products as $product)
                    <div class="obj-item1">
                        <div class="oitem-image">
                            <img src="{{ asset($product->img) }}" alt="img" class="obj-img">
                        </div>
                        <div class="obj-flex">
                            <a href="#" class="obj-head">{{ $product->name }}</a>
                                @if ($product->formula)
                                   <p class="item-price fs-3"> Formula: <b>{{ $product->formula }}</b>
                                    </p>
                                @endif
                            <p class="fs-2">Price :Rs {{ $product->price }}</p>
                            @if ($product->pres == 1)
                                <p class="item-price fs-3">Prescription <b class="text-danger">Required</b>
                                </p>
                            @endif
                            <a href="{{ route('product', ['product' => $product->id]) }}" class="obj-btn">View
                                Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="counter-flex">
            <div class="counter-flex2">
                <ion-icon class="icon" name="car"></ion-icon>
                <h4>Free Shipping</h4>
                <p>Free on order over $300</p>
            </div>
            <div class="counter-flex2">
                <ion-icon class="icon" name="briefcase"></ion-icon>
                <h4>Security Payment</h4>
                <p>Free on order over $300</p>
            </div>
            <div class="counter-flex2">
                <ion-icon class="icon" name="rewind"></ion-icon>
                <h4>30 Day Return</h4>
                <p>Free on order over $300</p>
            </div>
            <div class="counter-flex2">
                <ion-icon class="icon" name="call"></ion-icon>
                <h4>24/7 Support</h4>
                <p>Free on order over $300</p>
            </div>
        </section>

    </main>
{{-- @if(isset($searched_products))
<!-- Your modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog  model-lg" role="document" >
        <div class="modal-content "  style=" width: 200%;right: 150px;">
            <div class="modal-header">
                <h5 class="modal-title">Your Last Searched</h5>
          
            </div>
            <div class="modal-body">
                <div class="row ">
                    @foreach ($searched_products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                            <a href="{{ route('product', ['product' => $product->id]) }}"
                                class="thumb-wrapper-link">
                                <div class="thumb-wrapper">
                                    <span class="sale-label mt-3">Sale {{ $product->discount }}%</span>
                                    <div class="img-box">
                                        <img src="{{ asset($product->img) }}" class="img-fluid" alt="Apple iPad">
                                    </div>
                                    <div class="thumb-content">
                                        <h4>{{ $product->name }}</h4>
                                     
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
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">
                                                    <button type="submit" class="btn">Add to Cart<ion-icon
                                                            name="cart"></ion-icon></button>
                                                </form>
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
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@endif
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // JavaScript to trigger carousel slide every 2 seconds
        $(document).ready(function() {
            $('#carouselExampleControls').carousel({
                interval: 2000 // Slide every 2 seconds
            });
        });
    </script>

<script>
    $(document).ready(function(){
        // Delay showing the modal by 5 seconds
        setTimeout(function() {
            // Get the timestamp of when the modal was last closed
            var lastClosedTime = localStorage.getItem('modalClosedTime');
            if (lastClosedTime) {
                // Calculate the difference in minutes between the current time and the last closed time
                var differenceInMinutes = (new Date() - new Date(lastClosedTime)) / (1000 * 60);
                // If the difference is greater than 5 minutes, show the modal again
                if (differenceInMinutes > 5) {
                    $('#exampleModal').modal('show');
                }
            } else {
                // If the modal has never been closed, show it
                $('#exampleModal').modal('show');
            }
        }, 100); // 5000 milliseconds = 5 seconds
    });

    // Store the timestamp when the modal is closed
    $('#exampleModal').on('hidden.bs.modal', function () {
        localStorage.setItem('modalClosedTime', new Date());
    });
</script> --}}

@endsection
