@extends('Layouts.Sidebar')

@section('main')

<div class="container">
    <a href="#form-brand" data-bs-toggle="collapse" class="btn btn-secondary my-3">Add Brands</a>
    <div class="row">
        <div class="collapse" id="form-brand">
            <form name="booking" class="w-100" data-animate-in="animateUp" id="form-data">
                @csrf
                <div class="row my-3 ">
                <div class="col-sm-12 col-md-6">
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
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="brand_name">Nama Brand</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="brand_name" class="form-control" id="brand_name" placeholder="Nama Brand">
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
    <table class="table table-bordered table-brand">
        <thead>
            <tr>
                <th>No</th>
                <th>Code</th>
                <th>Nama Brand</th>
                <th>Nama Supplier</th>
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
                        <label for="name" class="control-label">Brand Name</label>
                        <input value="" type="text" name="brand_name" class="brand_name form-control" id="brand_name">
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
        let table = $('.table-brand').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('brand') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'brand_code',
                    name: 'brand_code'
                },
                {
                    data: 'brand_name',
                    name: 'brand_name'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
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
                url: "{{route('brand.create')}}",
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
            url: `brand/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to form
                $('#id').val(response.id);
                $('#supplier').val(response.supplier_id);
                $('.brand_name').val(response.brand_name);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    $('#form-modal').submit(function(e) {
        e.preventDefault();
        let id = $('#id').val();
        $.ajax({
            url: "{{route('brand.update')}}",
            type: 'post',
            data: $('#form-modal').serialize(),
            success: function(_response) {
                $('#modal-edit').modal('toggle');
                $('.table-brand').DataTable().ajax.reload()
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