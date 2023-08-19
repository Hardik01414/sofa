@extends('layout.layout')

@section('title')
    Category
@endsection

@section('content')
    <div class="container mt-5">
        @if (session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Color</th>
                    <th>Edit Category</th>
                    <th>Delete Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                    <tr>
                        <td><img src="public/p_image/{{ $value['image'] }}" width="100px" height="100px"></td>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['price'] }}</td>
                        <td>{{ $value['color'] }}</td>
                        <td><input type="button" name="edit" id="edit" value="Edit" data-eid="{{ $value['id'] }}" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary"></td>
                        <td><input type="button" name="delete" id="delete" value="Delete" data-eid="{{ $value['id'] }}" class="btn btn-danger"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('product.edit') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
      <div class="modal-body">
        <div class="row">
            <div class="col-7">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <input type="hidden" name="id" id="id">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label>Product Price</label>
                    <input type="text" name="price" id="price" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Select Color</label>
            <select class="form-control" id="select" name="color">
                <option value="Red">Red</option>
                <option value="Blue">Blue</option>
                <option value="White">White</option>
                <option value="Black">Black</option>
            </select>
        </div>


        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image" id="file" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function(){
    $(document).on('click','#edit',function(){
        var id = $(this).data('eid');

        $.ajax({
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            url:"{{ route('edit.pro') }}",
            type:"post",
            data:{id:id},
            success:function(data)
            {

                console.log(data);
                $('#id').val(data[0].id);
                $('#price').val(data[0].price);
                $('#name').val(data[0].name);
                $('#select').val(data[0].color);
               // console.log($('#select').val());


            }
        });
    });

    $(document).on('click','#delete',function(){
        var id = $(this).data('eid');
        var tr = $(this).closest('tr');
        $.ajax({
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            url:"{{ route('delete.product') }}",
            type:"post",
            data:{id:id},
            success:function(data)
            {
                if(data == 1)
                {
                    tr.fadeOut(200);
                }
                else
                {
                    alert('Sorry Record Was Not Deleted');
                }
            }
        });
    });
});
</script>
@endsection
