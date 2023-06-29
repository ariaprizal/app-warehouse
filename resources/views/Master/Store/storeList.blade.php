@extends('Layouts.Sidebar')

@section('main')

<div class="container">
    <a href="#form-supplier" data-bs-toggle="collapse" class="btn btn-secondary my-3">Add Store</a>
    <div class="row">
        <div class="collapse" id="form-supplier">
            <form name="booking" class="w-100" data-animate-in="animateUp" id="form-data">
                @csrf
                <div class="row my-3 ">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="store_name">Nama Store</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="store_name" class="form-control" id="store_name" placeholder="Nama store">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="store_address">Alamat Store</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="store_address" class="form-control" id="store_address" placeholder="Alamat store">
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
    <table class="table table-striped table-bordered table-hover table-store">
        <thead>
            <tr>
                <th width="10px" wid>No</th>
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

                    <div class="form-group">
                        <label for="name" class="control-label">Store Name</label>
                        <input value="" type="text" name="store_name" class="store_name form-control" id="store_name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Store Address</label>
                        <input value="" type="text" name="store_address" class="store_address form-control" id="store_address">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
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

        // view table supplier
        let table = $('.table-store').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('store') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'store_name',
                    name: 'store_name'
                },
                {
                    data: 'store_address',
                    name: 'store_address'
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
                url: "{{route('store.create')}}",
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
            url: `store/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to form
                $('#id').val(response.id);
                $('.store_name').val(response.store_name);
                $('.store_address').val(response.store_address);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    $('#form-modal').submit(function(e) {
        e.preventDefault();
        let id = $('#id').val();
        $.ajax({
            url: "{{route('store.update')}}",
            type: 'post',
            data: $('#form-modal').serialize(),
            success: function(_response) {
                $('#modal-edit').modal('toggle');
                $('.table-store').DataTable().ajax.reload()
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