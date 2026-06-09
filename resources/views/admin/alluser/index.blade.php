
@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



<!-- Main content -->
<div class="main-content">
  @include('layout.admin.nav')
     <!-- Main content area -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>All Customer</h1>
           
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Phone</th>
                    <th scope="col">City</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i=1;   
               @endphp
                @foreach($allusers as $user)
                <tr>
                    <th scope="row"> {{$i++}}</th>
                    <td><strong>{{$user->name}}</strong></td>
                    <td><strong>{{$user->email}}</strong></td>
                    <td><strong>{{$user->phone}}</strong></td>
                    <td><strong>{{$user->city}}</strong></td>
                    <td><strong>{{$user->address}}</strong></td>
                    <td class="d-flex justify-content-center">
                        <form id="delete-form-{{$user->id}}" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
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
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category<button onclick="testToastr()">Test Toastr</button></h5>
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