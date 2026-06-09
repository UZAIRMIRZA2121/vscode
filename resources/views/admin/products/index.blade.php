@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="my-5">Products</h1>
                <div>
                    <a href="{{ route('products.trash') }}" class="btn btn-warning my-5 mr-2">Trash</a>
                    <a href="{{ route('products.create') }}" class="btn btn-success my-5">Add Product</a>
                </div>
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

                            <td class="d-flex ">
                                @if ($product->qr_code)
                                    <a class="btn btn-success btn-sm  " href="{{ asset($product->qr_code) }}" download
                                        title="downlode QR code ">QR </a>
                                @endif


                                <a class="btn btn-warning btn-sm mx-2"
                                    href="{{ route('products.edit', $product->id) }}">Update</a>
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category<button onclick="testToastr()">Test
                            Toastr</button></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name"
                                placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="categoryImage">Category Image</label>
                            <br>
                            <input type="file" id="categoryImage" name="img" placeholder="Choose category image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- Remove duplicate type attribute from the submit button -->
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    <script>
        function confirmDelete(categoryId) {
            if (confirm("Are you sure you want to delete this category?")) {
                document.getElementById('delete-form-' + categoryId).submit();
            }
        }
    </script>




@endsection
