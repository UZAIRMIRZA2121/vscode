
@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



<!-- Main content -->
<div class="main-content">
  @include('layout.admin.nav')
     <!-- Main content area -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between mt-3">
            <h1 >Categories</h1>
            </div>
        <nav class="mt-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>
       
    </div>
    <div class="container w-50 border p-3">
        <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="Inputname" class="form-label">Name</label>
                <input type="text" class="form-control" id="Inputname" name="name" value="{{$category->name}}">
            </div>
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <select class="form-control" id="categoryName" name="main_category_id">
                    <option value="">Select main category </option>
                    @foreach($maincategories as $miancategory)
                    <option value="{{$miancategory->id}}"  {{$miancategory->id ==  $category->main_category_id ? 'selected':''}}>{{$miancategory->name}}</option>
                    @endforeach
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="Inputimage" class="form-label">Image</label>
                <input type="file" class="form-control" id="Inputimage" name="img">
            </div>
            <div class="mb-3">
                <label for="Input" class="form-label">Current Image</label>
                <br>
                <img src="{{asset($category->img)}}" alt="{{asset($category->img)}}" width="300px">
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
        </form>
        
    </div>

    
</div>







@endsection