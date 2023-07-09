@extends('Layouts.Sidebar')

@section('main')
<div class="transation-container mt-5 pe-3">
    <h4 class="mb-5">Insert Product Ke Invoice</h4>
    <div class="row">
        @if($invoice->status == 'on created')
        <div class="" id="form-supplier">
            <form name="booking" class="w-100" data-animate-in="animateUp" id="form-data">
                @csrf
                <div class="row my-3 ">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="">Product</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-globe"></i>
                                </span>
                                <select class="form-control" name="product_id" id="product">
                                    <option value="">-- select one --</option>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}-good">{{$product->product_name}} - {{$product->product_color}} - {{$product->product_size}} - Good Stock( {{$product->good_stock}}) </option>
                                    <option value="{{$product->id}}-bad"> {{$product->product_name}} {{$product->product_color}} {{$product->product_size}} - Bad Stock({{$product->bad_stock}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="qty">Jumlah product</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="qty" class="form-control qty" id="qty" placeholder="Jumlah Product">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary float-end w-25 my-3"><span class="glyphicon glyphicon-send"></span> Add Item</button>
                </div>
            </form>
        </div>
        @else
        <div class="row mb-5 text-center">
            <div class="col-6">
                <span class="fw-bolder">Nomor Invoice :</span> {{$invoice->inv_code}}
            </div>
            <div class="col-6">
                <span class="fw-bolder">Nomor SJ :</span> {{$invoice->no_sj}}
            </div>
            <hr class="my-2" />
        </div>
        @endif
    </div>
    <div class="table-responsive" style="overflow-x: scroll;">
        <table class="table w-100 table-bordered table-add-invoice ">
            <thead class="table-secondary">
                <tr>
                    <th>Id</th>
                    <th>No Invoice</th>
                    <th>No SJ</th>
                    <th>Supplier</th>
                    <th>Brand</th>
                    <th>Kode Product</th>
                    <th>Nama Product</th>
                    <th>Qty</th>
                    <th>Harga Jual</th>
                    <th>Price</th>
                    <th>Type Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    @if($invoice->status == 'on created')
    <button class="btn btn-primary float-end my-5" style="width: 150px;" id="btn-done">Done</button>
    @endif
</div>


<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete data</h5>
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-modal">
                <div class="modal-body">
                    <h4>Are you sure to delete this data?</h4>
                    <input type="hidden" id="id" class="id">
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-delete">Delete</button>
                </div>

            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="modal-discount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Discount</h5>
                <button type="button" class="close" id="close-discount" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-discount">
                <div class="modal-body">
                    <input type="hidden" id="id" class="id">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="discount">Jumlah Discount %</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="discount" class="form-control discount" id="discount" placeholder="Jumlah Discount %">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-discount">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-discount">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {

        // view table po
        const code = window.location.href
        let table = $('.table-add-invoice').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'GET',
                url: `{{route('order.insertProduct')}}`,
                data: {
                    code: code,
                },
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'inv_code',
                    name: 'inv_code'
                },
                {
                    data: 'no_sj',
                    name: 'no_sj'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
                },
                {
                    data: 'brand_name',
                    name: 'brand_name'
                },
                {
                    data: 'product_code',
                    name: 'product_code'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'product_price',
                    name: 'product_price'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#form-data').submit(function(e) {
            e.preventDefault();
            const product = $('#product').val().split("-");
            product[1] === 'bad' ? $('#modal-discount').modal('show') :
                $.ajax({
                    url: "{{route('order.addProduct')}}",
                    type: 'post',
                    data: {
                        inv_code: code,
                        product_id: product[0],
                        qty: $('#qty').val(),
                        discount: 0,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(_response) {
                        $('.table-add-invoice').DataTable().ajax.reload()
                    },
                    error: function(_response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.error(_response.responseText);
                    }
                });
        });

        $('#form-discount').submit(function(e) {
            e.preventDefault();
            const product = $('#product').val().split("-");
            $.ajax({
                url: "{{route('order.addProduct')}}",
                type: 'post',
                data: {
                    inv_code: code,
                    product_id: product[0],
                    qty: $('#qty').val(),
                    discount: $('#discount').val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(_response) {
                    $('.table-add-invoice').DataTable().ajax.reload()
                    $('#modal-discount').modal('toggle');
                },
                error: function(_response) {
                    $('#modal-discount').modal('toggle');
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error(_response.responseText);
                }
            });
        });

        $('body').on('click', '#btn-done', function() {

            //fetch detail post with ajax
            $.ajax({
                url: "{{route('order.update')}}",
                data: {
                    code: code,
                    _token: '{{csrf_token()}}'
                },
                type: "patch",
                cache: false,
                success: function(response) {
                    window.location.href = '/marketing/order'
                }
            });
        });

        $('body').on('click', '#btn-cancel', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#modal-edit').modal('toggle');
        });

        $('#form-modal').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('invoiceListing.delete')}}",
                type: 'delete',
                data: {
                    id: $('#id').val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(_response) {
                    $('#modal-edit').modal('toggle');
                    $('.table-add-invoice').DataTable().ajax.reload()
                },
            });
        });

        $('body').on('click', '#btn-cancel, #close', function() {
            $('#modal-edit').modal('toggle');
        });

        $('body').on('click', '#cancel-discount, #close-discount', function() {
            $('#modal-discount').modal('toggle');
        });
    })
</script>
@endsection