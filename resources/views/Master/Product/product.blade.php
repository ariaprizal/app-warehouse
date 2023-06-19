@extends('Layouts.Sidebar')

@section('main')

<div class="container">
    <a href="#form-product" data-bs-toggle="collapse" class="btn btn-secondary my-3">Add Product</a>
    <div class="row">
        <div class="collapse" id="form-product">
            <form class="w-100" data-animate-in="animateUp" id="form-data">
                @csrf
                <div class="row my-3">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="country">Supplier</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-globe"></i>
                                </span>
                                <select class="form-control" name="supplier_id" id="suppliers">
                                    <option value="">-- select one --</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="country">Brand</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-globe"></i>
                                </span>
                                <select class="form-control" name="brand_id" id="brands">
                                    <option value="">-- Select State --</option>
                                </select>
                            </div>
                            <span class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="product_name">Nama Product</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Nama Product">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="product_color">Color</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="product_color" class="form-control" id="product_color" placeholder="Color">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="product_size">Size</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="product_size" class="form-control" id="product_size" placeholder="Size">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="product_price">Harga</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="product_price" class="form-control" id="product_price" placeholder="Harga">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="product_capital">Harga Modal</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="product_capital" class="form-control" id="product_capital" placeholder="Harga Modal">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary float-end w-25 my-3"><span class="glyphicon glyphicon-send"></span> Save</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-product">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Code</th>
                <th>Color</th>
                <th>Size</th>
                <th>Good Stock</th>
                <th>Bad Stock</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>






<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-modal">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" class="id" id="id" name="id">
                    <input type="hidden" class="supplier" id="supplier" name="supplier">
                    <input type="hidden" class="brand" id="brand" name="brand">

                    <div class="form-group">
                        <label for="name" class="control-label">Product Name</label>
                        <input value="" type="text" name="product_name" class="product_name form-control" id="product_name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Product Color</label>
                        <input value="" type="text" name="product_color" class="product_color form-control" id="product_color">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Product Size</label>
                        <input value="" type="text" name="product_size" class="product_size form-control" id="product_size">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Product Price</label>
                        <input value="" type="text" name="product_price" class="product_price form-control" id="product_price">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="country">Supplier</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                            <select class="form-control" name="supplier_id" id="suppliers-modal">
                                <option value="">-- select one --</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="helpblock"></span>
                    </div>
                    <div class="form-group">
                        <label for="country">Brand</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                            <select class="form-control" name="brand_id" id="brands-modal">
                                <option value="">-- Select State --</option>
                            </select>
                        </div>
                        <span class="helpblock"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-primary" id="update">UPDATE</button>
                </div>

            </form>

        </div>
    </div>
</div>



<script>
    $(function() {

        // view table product
        let table = $('.table-product').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_code',
                    name: 'product_code'
                },
                {
                    data: 'product_color',
                    name: 'product_color'
                },
                {
                    data: 'product_size',
                    name: 'product_size'
                },
                {
                    data: 'good_stock',
                    name: 'good_stock'
                },
                {
                    data: 'bad_stock',
                    name: 'bad_stock'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // dependent data
        $('#suppliers').on('change', function() {
            var supplierId = this.value;
            $.ajax({
                url: "{{route('brand.getByIdSupplier')}}",
                type: "POST",
                data: {
                    id: supplierId,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#brands').html('<option value="">-- Select State --</option>');
                    $.each(result, function(key, value) {
                        console.log(result);
                        $("#brands").append('<option value="' + value
                            .id + '">' + value.brand_name + '</option>');
                    });
                }
            });
        });

        // dependent data modal
        $('#suppliers-modal').on('change', function() {
            var supplierId = this.value;
            $.ajax({
                url: "{{route('brand.getByIdSupplier')}}",
                type: "POST",
                data: {
                    id: supplierId,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#brands-modal').html('<option value="">-- Select State --</option>');
                    $.each(result, function(key, value) {
                        console.log(result);
                        $("#brands-modal").append('<option value="' + value
                            .id + '">' + value.brand_name + '</option>');
                    });
                }
            });
        });

        // create data
        $('#form-data').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{route('product.create')}}",
                type: 'post',
                data: $('#form-data').serialize(),
                success: function(_response) {
                    table.ajax.reload(null, false);
                },
                error: function(_response) {
                    // Handle error
                }
            });
        });
    });

    $('body').on('click', '#edit-button', function() {
        let id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `product/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to form
                $('#id').val(response.id);
                $('.product_name').val(response.product_name);
                $('.product_color').val(response.product_color);
                $('.product_size').val(response.product_size);
                $('.product_price').val(response.product_price);
                $('.supplier').val(response.supplier_id);
                $('.brand').val(response.brand_id);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    $('#form-modal').submit(function(e) {
        e.preventDefault();
        let id = $('#id').val();
        $.ajax({
            url: "{{route('product.update')}}",
            type: 'post',
            data: $('#form-modal').serialize(),
            success: function(_response) {
                $('#modal-edit').modal('toggle');
                $('.table-product').DataTable().ajax.reload()
            },
            error: function(_response) {
                // Handle error
            }
        });
    });

    $('.close').click(function(e) {
        $('#modal-edit').modal('toggle');
    });
</script>
@endsection