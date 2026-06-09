@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
<style>
    /* CSS for Search Container */
.search-container {
    margin-bottom: 20px; /* Adjust margin as needed */
}

/* CSS for Search Input */
.search-input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s ease-in-out;
}

.search-input:focus {
    outline: none;
    border-color: #4CAF50; /* Highlight color on focus */
}

</style>
    <main>
        <main>
            <section class="fleet-hero hero-section">
                <h1 class="hero-head fleet-head">Our  Services</h1>
                <p class="hero-para">A porfolio of our services <br> at your doorstep.</p>
                {{-- <div class="fleet-btn-div">
                    <a href="#" class="fleet-btn ">See Featured Categories</a>
                </div> --}}

            </section>
           
            <section class="container py-5">
                <div class="row ">
                    <div class="row pt-5">
                            <h1 class="py-5"> <b>Search Nurses</b></h1>
                        <div class="search-container">
                            <input type="text" id="searchInput" class="search-input" placeholder="Search by name or type">
                        </div>
                        <h1 class="py-5"> <b>Nurses</b></h1>
                        <div class="row" id="nurse-listing">
                            
    @if ($nurses)
        @foreach ($nurses as $nurse)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('nurse', ['nurse' => $nurse->id]) }}" class="thumb-wrapper-link">
                    <div class="thumb-wrapper">
                        {{-- Image Box --}}
                        <div class="img-box">
                            <img src="{{ asset($nurse->img) }}" class="img-fluid" alt="Nurse Image">
                        </div>

                        {{-- Thumb Content --}}
                        <div class="thumb-content">
                            <h4>{{ $nurse->name }}</h4>

                            {{-- Star Rating --}}
                            <div class="star-rating">
                                <ul class="list-inline">
                                    @php
                                        // Calculate and output star ratings
                                        // ... (your existing PHP code for star ratings)
                                    @endphp
                                </ul>
                            </div>

                            {{-- Nurse Type --}}
                            @if ($nurse->type)
                                <p class="item-price"><b>Type: {{ $nurse->type }}</b></p>
                            @endif

                            {{-- Hourly Rate --}}
                            <p class="item-price"><b>Rs: {{ $nurse->hourly_rate }}/Hour</b></p>

                            {{-- Details Button --}}
                            <a href="{{ route('nurse', ['nurse' => $nurse->id]) }}" class="btn btn-sm">Details</a>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <h1>There are no nurses in this category</h1>
    @endif
</div>
                    </div>
                </div>
            </section>

        </main>
        
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toLowerCase();

            $('.thumb-wrapper').each(function() {
                var currentText = $(this).find('h4').text().toLowerCase();
                var currentType = $(this).find('.item-price b').text().toLowerCase();

                if (currentText.includes(searchText) || currentType.includes(searchText)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        });
    });
</script>
