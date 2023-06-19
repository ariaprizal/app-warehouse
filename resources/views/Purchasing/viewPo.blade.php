@extends('Layouts.Sidebar')

@section('main')
<div class="transation-container mt-5 pe-3">
    <h4 class="mb-5">Insert Product Ke PO</h4>
    <div class="row">
    @if($purchase->status == 'on created') 
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
                                    <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_color}} {{$product->product_size}}</option>
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
                <span class="fw-bolder">Nomor PO :</span> {{$purchase->po_code}}
            </div>
            <div class="col-6">
                <span class="fw-bolder">Nomor SJ :</span> {{$purchase->no_sj}}
            </div>
            <hr class="my-2"/>
        </div>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table w-100 table-bordered table-add-purchase ">
            <thead class="table-secondary">
                <tr>
                    <th>Id</th>
                    <!-- <th>Tanggal</th> -->
                    <th>No Purchase</th>
                    <th>No SJ</th>
                    <th>Supplier</th>
                    <th>Brand</th>
                    <th>Kode Product</th>
                    <th>Nama Product</th>
                    <th>Qty</th>
                    <th>Harga Modal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    @if($purchase->status == 'on created') 
     <button class="btn btn-primary float-end my-5" style="width: 150px;" id="btn-done">Done</button>
     @endif
</div>


<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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




<script>
    $(function() {

        // view table po
        const code = window.location.href
        let table = $('.table-add-purchase').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'GET',
                url: `{{route('purchase.insertProduct')}}`,
                data: {
                    code: code,
                },
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                // {
                //     data: 'created_at',
                //     name: 'created_at'
                // },
                {
                    data: 'po_code',
                    name: 'po_code'
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
                    data: 'product_capital',
                    name: 'product_capital'
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
            $.ajax({
                url: "{{route('purchase.addProduct')}}",
                type: 'post',
                data: {
                    po_code: code,
                    product_id: $('#product').val(),
                    qty: $('#qty').val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(_response) {
                    $('.table-add-purchase').DataTable().ajax.reload()
                },
                error: function(_response) {
                    // Handle error
                }
            });
        });

        $('body').on('click', '#btn-done', function() {

            //fetch detail post with ajax
            $.ajax({
                url: "{{route('purchase.update')}}",
                data: {
                    code: code,
                    _token: '{{csrf_token()}}'
                },
                type: "patch",
                cache: false,
                success: function(response) {
                    window.location.href = '/purchasing/purchase'
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
                url: "{{route('purchaseListing.delete')}}",
                type: 'delete',
                data: {
                    id: $('#id').val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(_response) {
                    $('#modal-edit').modal('toggle');
                    $('.table-add-purchase').DataTable().ajax.reload()
                },
            });
        });

        $('body').on('click', '#btn-cancel, .close', function() {
            $('#modal-edit').modal('toggle');
        });
    })
</script>
@endsection