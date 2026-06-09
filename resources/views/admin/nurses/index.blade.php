
@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



<!-- Main content -->
<div class="main-content">
  @include('layout.admin.nav')
     <!-- Main content area -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>nurses</h1>
            <a href="{{ route('nurses.create') }}" class="btn btn-success ml-auto m-5">Add nurse</a>

        </div>
        <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Qualification</th>
                    <th scope="col">Gender</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Description</th>
                    <th scope="col">Experience (Years)</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Image</th>
                    <th scope="col">Hourly Rate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;   
                @endphp
                @foreach($nurses as $nurse)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td><strong>{{ $nurse->name }}</strong></td>
                    <td><strong>{{ $nurse->qualification }}</strong></td>
                    <td><strong>{{ $nurse->gender }}</strong></td>
                    <td><strong>{{ $nurse->date_of_birth }}</strong></td>
                    <td><strong>{{ $nurse->phone }}</strong></td>
                    <td><strong>{{ $nurse->email }}</strong></td>
                    <td><strong>{{ Str::limit($nurse->address, 30) }}</strong></td>
                    <td><strong>{{ Str::limit($nurse->desc, 30) }}</strong></td>
                    <td><strong>{{ $nurse->experience_years }}</strong></td>
                    <td><strong>{{ $nurse->specialization }}</strong></td>
                    @if( $nurse->availability == 1)
                    <td><strong class="badge badge-success">yes</strong></td>
                    @else
                    <td><strong class="badge badge-danger">No</strong></td>
                    @endif
                    <td><img src="{{ asset($nurse->img) }}" alt="{{$nurse->img }}" width="100"></td>
                    <td><strong>{{ $nurse->hourly_rate }}</strong></td>
                    <td class="d-flex">
                        <a class="btn btn-info btn-sm mx-2" href="{{ route('nurses.toggleAvailability', $nurse->id) }}">Availability</a>
                        <a class="btn btn-warning btn-sm mx-2" href="{{ route('nurses.edit', $nurse->id) }}">Update</a>
                        <form id="delete-form-{{ $nurse->id }}" action="{{ route('nurses.destroy', $nurse->id) }}" method="POST">
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