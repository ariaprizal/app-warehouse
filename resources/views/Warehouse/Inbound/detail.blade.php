@extends('Layouts.Sidebar')

@section('main')

<div class="transation-container mt-5 pe-3">
    <h4 class="mb-5">Detail Purchase</h4>
    <div class="row mb-5 text-center">
        <div class="col-6 d-flex justify-content-around">
            <span class="fw-bolder">Nomor PO :</span>
            <span class="">{{$purchase->po_code}}</span>
        </div>
        <div class="col-6 d-flex justify-content-around">
            <span class="fw-bolder">Nomor SJ :</span>
            <span class=""> {{$purchase->no_sj}}</span>
        </div>
        <hr class="my-2" />
    </div>
    <div class="table-responsive">
        <table class="table w-100 table-bordered table-process ">
            <thead class="table-secondary">
                <tr>
                    <th>Id</th>
                    <th style="width: 100px;">No Purchase</th>
                    <th style="width: 100px;">No SJ</th>
                    <th style="width: 120px;">Kode Product</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Good</th>
                    <th>Bad</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @if($purchase->status != 'done')
    <button class="btn btn-primary float-end my-5" style="width: 150px;" id="btn-done">Done</button>
    @endif


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

                        <div class="form-group">
                            <label for="name" class="control-label">Good Stock</label>
                            <input value="" type="text" name="good_stock" class="good_stock form-control" id="good_stock" placeholder="Good Stock">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Bad Stock</label>
                            <input value="" type="text" name="bad_stock" class="bad_stock form-control" id="bad_stock" placeholder="Bad Stock">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="update">UPDATE</button>
                    </div>

                </form>

            </div>
        </div>
    </div>





    <script>
        $(function() {

            // view table po detail
            const code = window.location.href
            let table = $('.table-process').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: 'GET',
                    url: `{{route('inbound.process')}}`,
                    data: {
                        code: code,
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'po_code',
                        name: 'po_code'
                    },
                    {
                        data: 'no_sj',
                        name: 'no_sj'
                    },
                    {
                        data: 'product_code',
                        name: 'product_code'
                    },
                    {
                        data: "product_name",
                        render: function(data, type, row) {
                            return `${row.supplier_name} - ${row.brand_name} - ${row.product_name} - ${row.product_color} - ${row.product_size}`;
                        }
                    },
                    {
                        data: 'qty',
                        name: 'qty'
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

            // add edit id
            $('body').on('click', '#edit-button', function() {
                let id = $(this).data('id');
                $('#id').val(id);
                $('#modal-edit').modal('toggle');
            });

            // close modal
            $('body').on('click', '.close', function() {
                $('#modal-edit').modal('toggle');
            });

            // update stock
            $('#form-modal').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                $.ajax({
                    url: "{{route('inbound.update')}}",
                    type: 'patch',
                    data: $('#form-modal').serialize(),
                    success: function(_response) {
                        $('#modal-edit').modal('toggle');
                        $('.table-process').DataTable().ajax.reload()
                    },
                    error: function(_response) {
                        // Handle error
                    }
                });
            });

            $('body').on('click', '#btn-done', function() {

                //fetch detail post with ajax
                $.ajax({
                    url: "{{route('process.update')}}",
                    data: {
                        code: code,
                        _token: '{{csrf_token()}}'
                    },
                    type: "patch",
                    cache: false,
                    success: function(response) {
                        window.location.href = '/warehouse/done/view'
                    }
                });
            });
        })
    </script>
    @endsection