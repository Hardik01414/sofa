@extends('layout.layout')

@section('title')
    Category
@endsection

@section('content')
<div class="container mt-5">
    @if(session()->has('error'))
    <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
    <div class="card">
        <form action='{{ route('add.cat') }}' method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
        <div class="card-header">
            Add New Category
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" class="form-control">
                @error('name')
                    {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                <label>Category Image</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </div>
        </form>
    </div>
</div>
@endsection


