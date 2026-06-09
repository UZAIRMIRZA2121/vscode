@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')

    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Product Details</h1>
        </section>
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
        <div class="container">
            <section class="nurse-grid ">
                <img src="{{ asset($product->img) }}" alt="">
                <div class="nurse-flex">
                    <h3>{{ $product->name }}</h3>
                    <h2>RS {{ $product->price }}</h2>
                    <h5>Prescription required: {{ $product->pres ? 'Yes' : 'Not' }}</h5>
                    <p>{{ $product->formula }}</p>
                    <p>{{ $product->desc }}</p>
                    @if (Auth::check())
                        @if ($product->pres == 0)
                            @if ($product->qty == 0)
                        <h3 class="text-danger ">Out of Stock</h3>
                            @else
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id"
                                value="{{ $product->id }}">
                            <button type="submit" class="obj-mbtn " style="display:unset !important;
                            
                            ">Add to Cart<ion-iconname="cart"></ion-icon></button>
                        </form>
                        @endif
                    @else
                    <button type="button" class="obj-btn"
                    data-product-id="{{ $product->id }}" data-toggle="modal"
                    data-target="#prescriptionModal">
                    Submit Prescription <ion-icon name="cart"></ion-icon>
                </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="obj-mbtn ">Add to Cart</a>
                @endif
                   
                </div>

            </section>
            <section class="description-section">
                <h1>Description</h1>
                <p>{{ $product->desc }}</p>
            </section>
        </div>
        <section class="container py-5">
            <div class="row ">
                <div class="row pt-5">
                    <h1 class="py-5">Related <b>Products</b></h1>
                   
                    <div class="row ">
                        @foreach ($related_products as $related_product)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                                <a href="{{ route('product', ['product' => $related_product->id]) }}"
                                    class="thumb-wrapper-link">
                                    <div class="thumb-wrapper">
                                        @if ($product->discount)
                                            <span class="sale-label" style="top:80px;">Sale
                                                {{ $product->discount }}%</span>
                                        @endif
                                        <div class="img-box">
                                            <img src="{{ asset($related_product->img) }}" class="img-fluid"
                                                alt="Apple iPad">
                                        </div>
                                        <div class="thumb-content">
                                            <h4>{{ $related_product->name }}</h4>
                                            @if ($related_product->pres == 1)
                                                <p class="item-price">Prescription <b class="text-danger">Required</b>
                                                </p>
                                            @endif
                                            @if ($related_product->discount)
                                                <p class="item-price"><strike>Rs. {{ $related_product->price }}</strike>
                                                    <b>Rs.
                                                        {{ $related_product->price - $related_product->price * ($related_product->discount / 100) }}</b>
                                                </p>
                                            @else
                                                <p class="item-price"> <b>Rs.{{ $related_product->price }}</b>
                                                </p>
                                            @endif

                                            <a href="{{ route('product', ['product' => $related_product->id]) }}"
                                                class="btn ">Details</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">The current product is out of stock. You may consider selecting a related product instead.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- Related Products List -->
            <div class="row ">
                @foreach ($related_products as $related_product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 " style="width: unset">
                        <a href="{{ route('product', ['product' => $related_product->id]) }}"
                            class="thumb-wrapper-link">
                            <div class="thumb-wrapper" >
                                @if ($product->discount)
                                    <span class="sale-label" style="top:80px;">Sale
                                        {{ $product->discount }}%</span>
                                @endif
                                <div class="img-box">
                                    <img src="{{ asset($related_product->img) }}" class="img-fluid"
                                        alt="Apple iPad">
                                </div>
                                <div class="thumb-content">
                                    <h4>{{ $related_product->name }}</h4>
                                    @if ($related_product->pres == 1)
                                        <p class="item-price">Prescription <b class="text-danger">Required</b>
                                        </p>
                                    @endif
                                    @if ($related_product->discount)
                                        <p class="item-price"><strike>Rs. {{ $related_product->price }}</strike>
                                            <b>Rs.
                                                {{ $related_product->price - $related_product->price * ($related_product->discount / 100) }}</b>
                                        </p>
                                    @else
                                        <p class="item-price"> <b>Rs.{{ $related_product->price }}</b>
                                        </p>
                                    @endif

                                    <a href="{{ route('product', ['product' => $related_product->id]) }}"
                                        class="btn ">Details</a>
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

  <script>
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the product quantity is zero
        if ({{ $product->qty }} === 0) {
            // If the quantity is zero, show the modal
            var modal = document.getElementById('exampleModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'block';
                document.body.classList.add('modal-open');
                var backdrop = document.createElement('div');
                backdrop.classList.add('modal-backdrop', 'fade', 'show');
                document.body.appendChild(backdrop);

                // Restore default Bootstrap modal behavior for close button
                var closeButton = modal.querySelector('.modal-header .close');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        modal.style.display = 'none';
                        modal.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        backdrop.remove();
                    });
                }
            }
        }
    });
</script>

@endsection
