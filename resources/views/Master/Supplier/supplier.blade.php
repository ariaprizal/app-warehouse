@extends('Layouts.Sidebar')

@section('main')

<div class="container">
    <a href="#form-supplier" data-bs-toggle="collapse" class="btn btn-secondary my-3">Add Supplier</a>
    <div class="row">
        <div class="collapse" id="form-supplier">
            <form name="booking" class="w-100" data-animate-in="animateUp" id="form-data">
                @csrf
                <div class="row my-3 ">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="supplier_name">Nama Supplier</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="supplier_name" class="form-control" id="supplier_name" placeholder="Nama Supplier">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="supplier_address">Alamat Supplier</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="supplier_address" class="form-control" id="supplier_address" placeholder="Alamat Supplier">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary float-end w-25 my-3"><span class="glyphicon glyphicon-send"></span> Save</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-supplier">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
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
                        <label for="name" class="control-label">Supplier Name</label>
                        <input value="" type="text" name="supplier_name" class="supplier_name form-control" id="supplier_name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Supplier Address</label>
                        <input value="" type="text" name="supplier_address" class="supplier_address form-control" id="supplier_address">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
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

        // view table supplier
        let table = $('.table-supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('supplier') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
                },
                {
                    data: 'supplier_address',
                    name: 'supplier_address'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // create data
        $('#form-data').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{route('supplier.create')}}",
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
            url: `supplier/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to form
                $('#id').val(response.id);
                $('.supplier_name').val(response.supplier_name);
                $('.supplier_address').val(response.supplier_address);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    $('#form-modal').submit(function(e) {
        e.preventDefault();
        let id = $('#id').val();
        $.ajax({
            url: "{{route('supplier.update')}}",
            type: 'post',
            data: $('#form-modal').serialize(),
            success: function(_response) {
                $('#modal-edit').modal('toggle');
                $('.table-supplier').DataTable().ajax.reload()
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