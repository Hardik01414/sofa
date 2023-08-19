@extends('layout.layout')

@section('title')
    Product
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <form action='{{ route('product') }}' method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
            <div class="card-header">
                Add New Product
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="text" name="price" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Select Color</label>
                            <select class="form-control" name="color">
                                <option value="Red">Red</option>
                                <option value="Blue">Blue</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                            </select>
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label>Product Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="col-5">
                        <label>Select Category</label>
                        <select name="cat" class="form-control">
                            <option>Select Category</option>
                            @foreach ($data as $value)
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </div>
            </form>
        </div>
    </div>
@endsection
