@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Main Categories</h1>
                <button class="btn btn-success ml-auto m-5" data-toggle="modal" data-target="#addCategoryModal">Add Main
                    Category</button>
            </div>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        {{-- <th scope="col">Image</th> --}}
                        <th scope="col" class="d-flex justify-content-center "><span class="me-3">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp

                    @if (isset($maincategories) && count($maincategories) > 0)
                        @foreach ($maincategories as $category)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td class="d-flex justify-content-center">
                                    <a class="btn btn-warning btn-sm mx-2" href="#" data-toggle="modal"
                                        data-target="#editModal{{ $category->id }}">Update</a>
                                    <form id="delete-form-{{ $category->id }}"
                                        action="{{ route('maincategories.destroy', ['category' => $category->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $category->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Category
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Your form fields -->
                                            <form
                                                action="{{ route('maincategories.update', ['category' => $category->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="categoryName">Category Name</label>
                                                    <input type="text" class="form-control" id="categoryName"
                                                        name="categoryName" value="{{ $category->name }}">
                                                </div>
                                                <!-- Other form fields -->
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">No main categories found.</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Main Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('maincategories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Main Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name"
                                placeholder="Enter Main category name">
                        </div>
                        {{-- <div class="form-group">
                        <label for="categoryImage">Category Image</label>
                        <br>
                        <input type="file" id="categoryImage" name="img" placeholder="Choose category image">
                    </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- Remove duplicate type attribute from the submit button -->
                        <button type="submit" class="btn btn-primary">Add Main Category</button>
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
