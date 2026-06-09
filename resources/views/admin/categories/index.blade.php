
@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



<!-- Main content -->
<div class="main-content">
  @include('layout.admin.nav')
     <!-- Main content area -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Categories</h1>
            <button class="btn btn-success ml-auto m-5" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
        </div>
        
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                  
                    <th scope="col">ID</th>
                    <th scope="col">Main Category</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;   
                @endphp
            
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td><strong>{{$category->mainCategory->name}}</strong></td>
                            <td><strong>{{$category->name}}</strong></td>
                            <td><img src="{{ asset($category->img) }}" alt="{{ $category->img }}" width="100"></td>
                            <td class="d-flex justify-content-end"> <!-- Align buttons to the end -->
                                <a class="btn btn-warning btn-sm mx-2" href="{{ route('categories.edit', ['category' => $category->id]) }}">Update</a>
                                <form id="delete-form-{{$category->id}}" action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{$category->id}})">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No categories found.</td>
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
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" placeholder="Enter category name">
                    </div>
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <select class="form-control" id="categoryName" name="main_category_id">
                            <option value="">Select main category </option>
                            @foreach($miancategories as $miancategory)
                            <option value="{{$miancategory->id}}">{{$miancategory->name}}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
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