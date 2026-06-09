@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <style>
        .rating-card {
            width: 280px;
            height: fit-content;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background: #0f0c29;
            background: linear-gradient(to right bottom, #443e89, #0f0c29);
            padding: 20px 20px;
            border-radius: 10px;
            gap: 10px;
            font-family: Arial, Helvetica, sans-serif;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.058);
        }

        .text-wrapper {
            width: 100%;
            height: fit-content;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .text-primary {
            color: white;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .text-secondary {
            color: #cccccc;
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .rating-stars-container {
            width: 100%;
            height: 30px;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: center;
        }

        .star-label svg {
            fill: rgb(210, 210, 210);
            width: 20px;
            height: auto;
        }

        .rating-stars-container input {
            appearance: unset;
        }

        .rating-stars-container input:hover~.star-label svg {
            fill: rgb(255, 204, 185);
        }

        .rating-stars-container input:checked~.star-label svg {
            fill: rgb(255, 102, 47);
            animation: slide-in-fwd-center 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }

        @keyframes slide-in-fwd-center {
            0% {
                transform: scale(1.6);
            }

            100% {
                transform: scale(1);
            }
        }

        .socials-container {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid rgb(150, 150, 150);
        }

        .social-button {
            text-decoration: none;
        }

        .social-button svg {
            width: 15px;
            fill: rgb(228, 228, 228);
        }

        .social-button:hover svg {
            fill: rgb(255, 102, 47);
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

                    <h1 class="fs-1 text-center">Hire Nurse</h1>
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
                    <div class="table-responsive ">

                        <table class="table custom-table">
                            <h1 class="fs-3 ">Total Hire Nurse : {{ $nurses->count() }}</h1>
                            <thead>
                                <tr>
                                    <th class="text-left">Sr.no</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Charge/Time</th>
                                    <th>Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @if (isset($nurses))
                                    {{-- Display search results --}}
                                    @foreach ($nurses as $nurse)
                                    @php
                                    $start = Carbon\Carbon::parse($nurse->start_time);
                                    $end = Carbon\Carbon::parse($nurse->end_time);
                                    $duration = $end->diffForHumans($start);
                                @endphp
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $nurse->nurse->name }}</td>
                                            @if ($nurse->status == 'requested')
                                                <td><strong class="text-primary">Requested</strong></td>
                                            @elseif($nurse->status == 'accepted')
                                                <td><strong class="text-info ">Accepted</strong></td>
                                            @elseif($nurse->status == 'completed')
                                                <td><strong class="text-success ">Completed</strong></td>
                                                @elseif($nurse->status == 'removed')
                                                <td><strong class="text-danger ">Removed</strong></td>
                                            @elseif($nurse->status == 'terminate')
                                                <td><strong class="text-success ">Terminate</strong></td>
                                           
                                            @else
                                                <td><strong class="text-danger">Rejected</strong></td>
                                            @endif
                                            <td><strong>{{$nurse->charge.'Rs/'.$duration}}</strong></td>
                                            <td>{{ $nurse->updated_at->diffForHumans() }}</td>
                                            <td>
                                                @if ($nurse->status == 'completed')
                                                <a class="btn btn-primary btn-sm mx-2" data-toggle="modal" data-target="#commentModal" data-nurse-id="{{ $nurse->id }}">
                                                    <i class="fa fa-star"></i> Rate
                                                </a>
                                                
                                            @elseif ($nurse->status == 'requested')
                                            <a class="btn btn-danger btn-sm mx-2" href="{{ route('nurses.request.comment', ['id' => $nurse->id]) }}">
                                                Remove
                                            </a>
                                            @endif
                                            
                                            </td>
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


                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Button trigger modal -->

    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Rate Nurse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Hidden input field to store nurse ID -->
                    <input type="hidden" id="nurseIdInput">
                    <!-- Add form fields for rating and comment -->
                    <form id="commentForm" action="#" method="POST"> <!-- Update the action attribute to "#" initially -->
                        @csrf
                    
                        <div class="rating-stars-container">
                            <input value="5" name="star" id="star-5" type="radio" />
                            <label for="star-5" class="star-label">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"
                                        pathLength="360"></path>
                                </svg>
                            </label>
                            <input value="4" name="star" id="star-4" type="radio" />
                            <label for="star-4" class="star-label">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"
                                        pathLength="360"></path>
                                </svg>
                            </label>
                            <input value="3" name="star" id="star-3" type="radio" />
                            <label for="star-3" class="star-label">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"
                                        pathLength="360"></path>
                                </svg>
                            </label>
                            <input value="2" name="star" id="star-2" type="radio" />
                            <label for="star-2" class="star-label">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"
                                        pathLength="360"></path>
                                </svg>
                            </label>
                            <input value="1" name="star" id="star-1" type="radio" />
                            <label for="star-1" class="star-label">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"
                                        pathLength="360"></path>
                                </svg>
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When the modal is about to be shown
            $('#commentModal').on('show.bs.modal', function(e) {
                // Get the nurse ID from the 'data-nurse-id' attribute of the button that triggered the modal
                var nurseId = $(e.relatedTarget).data('nurse-id');
                // Set the nurse ID in the hidden input field of the modal
                $('#nurseIdInput').val(nurseId);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var btn = document.querySelector('.btn-primary[data-toggle="modal"]');
            
            // Add a click event listener to the button
            btn.addEventListener('click', function() {
                // Get the nurse ID from the data-nurse-id attribute
                var nurseId = btn.getAttribute('data-nurse-id');
                
                // Set the value of the hidden input field in the form to the nurse ID
                document.getElementById('nurseIdInput').value = nurseId;
                
                // Update the form action attribute with the nurse ID
                var form = document.getElementById('commentForm');
                form.action = "{{ route('nurses.request.comment', ['id' => ':nurseId']) }}".replace(':nurseId', nurseId);
            });
        });
    </script>
@endsection
