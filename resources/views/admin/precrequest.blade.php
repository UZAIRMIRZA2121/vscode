@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            @if (session('success'))
            <div id="success-message" class="d-flex justify-content-center">
                <div class="alert alert-success text-center w-50">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="success-message" class="d-flex justify-content-center">
                <div class="alert alert-danger text-center w-50">
                    {{ session('error') }}
                </div>
            </div>
        @endif
            <div class="d-flex justify-content-between">
                <h1>Prescription Requests</h1>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        <th scope="col">Prescription</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($pending_prescriptions as $pending_prescription)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td> {{ $pending_prescription->user->name }}</td>
                            <td> {{ $pending_prescription->product->name }}</td>
                            <td> <img src="{{ asset($pending_prescription->img) }}" alt="{{ $pending_prescription->img }}"
                                    height="100" onclick="showModal('{{ asset($pending_prescription->img) }}')"></td>
                            <td>
                                @if ($pending_prescription->status == 'pending')
                                    <span class="badge badge-pill badge-info">Pending</span>
                                @elseif($pending_prescription->status == 'accepted')
                                    <span class="badge badge-pill badge-success">Accepted</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if ($pending_prescription->status == 'pending')
                                <!-- Accept button -->
                                <form action="{{ route('presc.update') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="prescription_id" value="{{ $pending_prescription->id }}">
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>

                                <!-- Reject button -->
                                <form action="{{ route('presc.update') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="prescription_id" value="{{ $pending_prescription->id }}">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                           
                            @endif
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Prescription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" style="width: -webkit-fill-available;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(imageSrc) {
            $('#modalImage').attr('src', imageSrc);
            $('#imageModal').modal('show');
        }
    </script>
    
  
@endsection
