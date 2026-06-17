@extends('layout.admin.master')

@section('title', 'Trash Products')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="my-5">Trash Products</h1>
                <a href="{{ route('products.index') }}" class="btn btn-primary ml-auto my-5">Back to Products</a>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">prescription</th>
                        <th scope="col">Image</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                        <th scope="col">QR Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row"> {{ $i++ }}</th>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td class="w-25">
                                <strong>{{ Str::limit($product->desc, 20) }}</strong>
                            </td>
                            <td><strong>{{ $product->pres == 0 ? 'No' : 'Yes' }}</strong></td>
                            <td><img src="{{ asset($product->img) }}" alt="{{ $product->img }}" width="100"></td>
                            <td><strong>{{ $product->qty }}</strong></td>
                            <td><strong>{{ $product->price }} Rs</strong></td>
                            <td><strong>{{ $product->category->name }}</strong></td>
                            <td>
                                @if ($product->qr_code)
                                    <img src="{{ asset($product->qr_code) }}" width="70" class="mb-2 d-block">
                                @else
                                    <span class="text-muted">No QR</span>
                                @endif
                            </td>
                            <td class="d-flex">
                                <form action="{{ route('products.restore', $product->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Restore</button>
                                </form>
                                <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" class="ml-2" onsubmit="return confirm('Are you sure you want to permanently delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Permanent Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
