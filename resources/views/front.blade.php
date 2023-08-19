<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="" />
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('resources/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('resources/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

        <script src="{{ asset('resources/jquery/jquery-3.7.0.min.js') }}"></script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
<body>

<div class="container">
    <ul style="list-style: none;">
        <li style="margin-left: 270px;">
    @foreach ($category as $ct)


    <div class="card category" data-cid="{{ $ct['id'] }}" style="width: 150px; height:180px; margin-right:30px; cursor:pointer; float:left;" >
        <img class="" src="public/image/{{ $ct['image'] }}" width="150px" height="150px;">

    <div class="card-body text-center align-middle">
        {{ $ct['name'] }}
    </div>
    </div>


    @endforeach
</li>
    </ul>

    <div class="row" style="clear:both; margin-top:50px;">
        <div class="col-8 mt-4 mb-3">

        </div>

        <div class="col-4 mt-4 mb-3">
            <div class="dropdown float-left">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sort By Name
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button class="dropdown-item sort" data-val="a to z" type="button">A To Z</button>
                  <button class="dropdown-item sort" data-val="z to a" type="button">Z To A</button>
                </div>
            </div>

            <div class="dropdown float-right" >
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sort By Price
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button class="dropdown-item sort" data-val="l to h" type="button">Low To High</button>
                  <button class="dropdown-item sort" data-val="h to l" type="button">High To Low</button>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-3">
            <div class="card bg-primary" style="height: 100%;">
                <div class="card-header">
                    <div class="filter">
                        <span class="badge badge-success s_color" id="color" data-color="" style="cursor:pointer;"></span>
                        <span class="badge badge-success s_price" id="price" data-price_f="" data-price_t=""  style="cursor:pointer;"></span>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="text-white">Search By Filters</h3>
                    <div class="dropdown" style="width: 100%;">
                        <button class="btn text-white bg-transparent dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Color
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <button class="dropdown-item color" data-val="Red" type="button">Red</button>
                          <button class="dropdown-item color" data-val="Blue" type="button">Blue</button>
                          <button class="dropdown-item color" data-val="White" type="button">White</button>
                          <button class="dropdown-item color" data-val="Black" type="button">Black</button>
                        </div>
                    </div>

                    <div class="dropdown" style="width: 100%;">
                        <button class="btn text-white bg-transparent dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Price
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <button class="dropdown-item fl" data-start="5000" data-end="10000" type="button">5000 To 10000</button>
                          <button class="dropdown-item fl" data-start="10000" data-end="20000" type="button">10000 To 20000</button>
                          <button class="dropdown-item fl" data-start="20000" data-end="30000" type="button">20000 To 30000</button>
                          <button class="dropdown-item fl" data-start="30000" data-end="50000" type="button">30000 To 50000</button>
                        </div>
                    </div>


                </div>

            </div>
        </div>

        <div class="col-9">
            <div class="row" id="row">
                @foreach ($product as $pr)
                <div class="col-2 mt-2 ml-4">
                    <div class="card" style="width: 150px;  margin-left:0px;">
                        <image class="card-img-top" src="public/p_image/{{ $pr['image'] }}" id="image" width="150px" height="150px">
                        <div class="card-body">
                            <span id="name"><b>{{ $pr['name'] }}</b></span>
                            <br>
                            <span id="price">{{ $pr['price'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('resources/js/scripts.js') }}"></script>
<script src="{{ asset('resources/js/bootstrap.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){
    $(document).on('click','.category',function(){
        var id = $(this).data('cid');

        $.ajax({
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            url:"{{ route('category.filter') }}",
            type:"POST",
            data:{id:id},
            success:function(data)
            {
                if(data == 0)
                {
                    alert('Sorry No Product Available In This Category');
                }
                else
                {
                $('#row').html('');
                $.each(data[0],function(key,value){
                    $('#row').append('<div class="col-2 mt-2 ml-4"><div class="card" style="width: 150px;"><image class="card-img-top" src="public/p_image/'+ value.image +'" id="image" width="150px" height="150px"><div class="card-body"><span id="name"><b>'+ value.name +'</b></span><br><span id="price">'+ value.price +'</span></div></div></div>');
                });
                }

            }
        });
    });

    $(document).on('click','.sort',function(){
        var val = $(this).data('val');

        $.ajax({
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            url:"{{ route('sort.filter') }}",
            type:"POST",
            data:{val:val},
            success:function(data)
            {
                $('#row').html('');
                $.each(data[0],function(key,value){
                    $('#row').append('<div class="col-2 mt-2 ml-4"><div class="card" style="width: 150px;"><image class="card-img-top" src="public/p_image/'+ value.image +'" id="image" width="150px" height="150px"><div class="card-body"><span id="name"><b>'+ value.name +'</b></span><br><span id="price">'+ value.price +'</span></div></div></div>');
                });
            }
        });
    });

    $(document).on('click','.color',function(){
        var val = $(this).data('val');

        $('.s_color').text(val);
        filter();
    });

    $(document).on('click','.fl',function(){
        var start = $(this).data('start');
        var end = $(this).data('end');

        $('.s_price').data('price_f',start);
        $('.s_price').data('price_t',end);

        $('.s_price').text(start +" To "+end);
        filter();
    });

    $(document).on('click','#color',function(){

        $('#color').text("");

        filter();
    });

    $(document).on('click','#price',function(){

        $('#price').text("");
        var start = $(this).data('price_f','');
        var end = $(this).data('price_t','');
        filter();
    });



    function filter(){
        var color = $('.s_color').text();
        var price = $('.s_price').text();
        var p_start = $('.s_price').data('price_f');
        var p_end = $('.s_price').data('price_t');

        $.ajax({
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            url:"{{ route('filter.set') }}",
            type:"POST",
            data:{color:color,price:price,p_start:p_start,p_end:p_end},
            success:function(data)
            {
                console.log(data);
                $('#row').html('');
                $.each(data[0],function(key,value){
                    $('#row').append('<div class="col-2 mt-2 ml-4"><div class="card" style="width: 150px;"><image class="card-img-top" src="public/p_image/'+ value.image +'" id="image" width="150px" height="150px"><div class="card-body"><span id="name"><b>'+ value.name +'</b></span><br><span id="price">'+ value.price +'</span></div></div></div>');
                });
            }
        });
    }
});
</script>

</body>
</html>
