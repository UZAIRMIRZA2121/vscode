@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Nurse Review</h1>
        </section>
        <center>
            @if (session('success'))
                <div id="Message" class="alert alert-success container w-50" style="margin-top: 40px;
font-size: 22px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div id="Message" class="alert alert-danger container w-50" style="margin-top: 40px;
font-size: 22px;">
                    {{ session('error') }}
                </div>
            @endif
        </center>

        <div class="container">
            <section class="nurse-grid">
                <img src="{{ asset($nurse->img) }}" alt="">
                <div class="nurse-flex">
                    <h3>Name : {{ $nurse->name }}</h3>
                    <h2>Rs : {{ $nurse->hourly_rate }}/Hour</h2>
                    <h5>Qualification : {{ $nurse->qualification }}</h5>
                    <h5>Email : {{ $nurse->email }}</h5>
                    <h5>Address : {{ $nurse->address }}</h5>
                    <h5>Age: {{ \Carbon\Carbon::parse($nurse->date_of_birth)->age }} Years</h5>
                    <h5>Experience : {{ $nurse->experience_years }} Year</h5>
                    <h5>Specialization : {{ $nurse->specialization }}</h5>
                    <h5>Nurse Type : {{ $nurse->type }}</h5>

                    <div class="star-rating">
                        <ul class="list-inline">
                            @php
                                $nurseTotalRating = 0; // Initialize total rating
                                $totalRatingsCount = 0; // Initialize total ratings count

                                // Loop through each nurse hire record
                                foreach ($nurse->nurseHires as $hire) {
                                    // Check if the status is "terminated"
                                    if ($hire->status === 'terminate') {
                                        // Add the rating to the total rating
                                        $nurseTotalRating += $hire->rating;

                                        // Increment total ratings count
                                        $totalRatingsCount++;
                                    }
                                }

                                // Calculate average rating
                                $averageRating = $totalRatingsCount > 0 ? $nurseTotalRating / $totalRatingsCount : 0;

                                // Output star ratings based on the average rating
                                $maxRating = 5; // Maximum rating
                                $wholeStars = floor($averageRating); // Whole star count
                                $fractionalStar = $averageRating - $wholeStars; // Fractional part of the rating

                                // Output whole stars
                                for ($i = 0; $i < $wholeStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                // Output fractional star if exists
                                if ($fractionalStar > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                    $wholeStars++; // Increment whole star count
                                }

                                // Output remaining empty stars
                                for ($i = $wholeStars; $i < $maxRating; $i++) {
                                    echo '<i class="far fa-star"></i>';
                                }
                            @endphp
                        </ul>
                    </div>
  @php
    $existingRequest = App\Models\NurseHire::where('user_id', Illuminate\Support\Facades\Auth::id())
                        ->where('nurse_id', $nurse->id)
                        ->where(function($query) {
                            $query->where('status', 'requested')
                                  ->orWhere('status', 'accepted');
                        })
                        ->exists();
@endphp


                  {{-- If a request already exists, show a message --}}
@if ($existingRequest)
    <p>A request for hiring this nurse has already been made.</p>
@else
    @if(Auth::check() )
        <!-- Hire Button Modal -->
        <a href="#" data-toggle="modal" data-target="#hireModal" data-id="{{ $nurse->id }}" class="obj-mbtn">Hire</a>
    @else
        <a href="{{ route('user.dashboard') }}" class="obj-mbtn">Hire</a>
    @endif
@endif


                </div>
            </section>
            <section class="description-section pt-5">
                <h1>Description</h1>
                @if ($nurse->desc)
                    <p>{{ $nurse->desc }}</p>
                @else
                    <p>Description not available</p>
                @endif
            </section>

        </div>
        <section class="review py-5">
            <h1 class="pt-5">Reviews</h1>

            @php
                $reviewExists = false;
            @endphp

            @foreach ($nurse->nurseHires as $hire)
                @if ($hire->status === 'terminate')
                    @php
                        $reviewExists = true;
                    @endphp

                    <div>
                        <p>{{ $hire->comment }}</p>

                        <span>
                            @php
                                $rating = $hire->rating;
                                $maxRating = 5; // Maximum rating
                                $wholeStars = floor($rating); // Whole star count
                                $fractionalStar = $rating - $wholeStars; // Fractional part of the rating

                                // Output whole stars
                                for ($i = 0; $i < $wholeStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                // Output fractional star if exists
                                if ($fractionalStar > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                    $wholeStars++; // Increment whole star count
                                }

                                // Output remaining empty stars
                                for ($i = $wholeStars; $i < $maxRating; $i++) {
                                    echo '<i class="far fa-star  "></i>';
                                }

                            @endphp
                        </span>
                    </div>
                @endif
            @endforeach

            @if (!$reviewExists)
                <div>
                    <p>Not yet reviewed</p>
                </div>
            @endif
        </section>


    </main>
    @if(Auth::check())
    <!-- Modal Structure -->
    <div class="modal fade" id="hireModal" tabindex="-1" aria-labelledby="hireModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hireModalLabel">Please check your details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('nurse.hire.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nurse_id" id="nurse_id" value="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ Auth::user()->city }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ Auth::user()->address }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ Auth::user()->phone }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update & Hire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        $(document).ready(function() {
            $('#hireModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var nurseId = button.data('id');
                var modal = $(this);
                modal.find('#nurse_id').val(nurseId);
            });
        });
    </script>
@endsection
