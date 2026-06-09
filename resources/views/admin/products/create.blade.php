@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')

    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Products</h1>
                <button class="btn btn-success ml-auto m-5">Add Product</button>
            </div>
        </div>
        <div class="container w-75 border p-3">
            <!-- For Create -->
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Other fields -->
                <div class="form-group">
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="Inputname" name="name" value="">
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="category_id">Category:</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="Inputname" name="qty" value="">
                        </div>
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Price</label>
                            <input type="number" class="form-control" id="Inputname" name="price" value="">
                        </div>
                    </div>
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12 mt-5">
                            <label for="Inputname" class="form-label">Image</label>
                            <input type="file" class="form-control" id="Inputname" name="img" value="">
                        </div>
                        @if ($errors->has('img'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('img') }}</strong>
                            </span>
                        @endif
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <div class="prescription">
                                <label for="Inputname" class="form-label">Prescription</label>
                                <input type="checkbox" class="" id="Inputname" name="pres" value="1">
                            </div>
                        </div>
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Discount %</label>
                            <input type="number" class="form-control" id="Inputname" name="discount" value="">
                        </div>
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Formula</label>
                            <input type="text" class="form-control" id="formulaInput" name="formula">
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="Inputname" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="Inputname" name="desc" value=""></textarea>
                    </div>
                    <label for="related_products">Related Products:</label>
                    <div class="row">
                            <div class="col-lg-4">
                                <div id="checkboxContainer" class="form-check"></div>
                            </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var formulaInput = document.getElementById('formulaInput');

            formulaInput.addEventListener('keyup', function() {
                var query = this.value;

                if (query.length > 2) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('searchFormulas') }}' + '?query=' + encodeURIComponent(query),
                        true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'));

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            var response = JSON.parse(xhr.responseText);
                            displayCheckboxes(response);
                           
                        } else {
                            console.error('AJAX Error:', xhr.status, xhr.statusText);
                        }
                    };

                    xhr.onerror = function() {
                        console.error('Request failed');
                    };

                    xhr.send();
                } else {
                    document.getElementById('checkboxContainer').innerHTML = '';
                }
            });

            function displayCheckboxes(products) {
                var container = document.getElementById('checkboxContainer');
                container.innerHTML = '';

                products.forEach(function(product) {
                    var checkbox = '<div>' +
                        '<input type="checkbox"  name="related_product_id[]" value="' + product.id + '" id="formula_' +
                        product.id + '">' +
                        '<label class="form-check-label"  for="formula_' + product.id + '">'  + product.name +  '</label></div>'
                        ;
                    container.insertAdjacentHTML('beforeend', checkbox);
                });
            }
        });
    </script>


@endsection
