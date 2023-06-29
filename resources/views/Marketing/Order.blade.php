@extends('Layouts.Sidebar')

@section('main')
<div class="transation-container pe-3">
    <button data-bs-toggle="modal" data-bs-target="#modal-edit" class="btn btn-secondary mt-3 mb-3">Add Order</button>
    <table class="table mt-2 table-bordered table-inv">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Tanggal</th>
                <th scope="col">No Invoice</th>
                <th scope="col">No Surat Jalan</th>
                <th scope="col">Status</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-modal">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">No Invoice</label>
                        <input value="" type="text" name="inv_code" class="inv_code form-control" id="inv_code" placeholder="No Invoice">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nomor Surat Jalan</label>
                        <input value="" type="text" name="no_sj" class="no_sj form-control" id="no_sj" placeholder="No Surat Jalan">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                            <label for="country">Store</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-globe"></i>
                                </span>
                                <select class="form-control" name="store_id" id="store">
                                    <option value="">-- select one --</option>
                                    @foreach($store as $s)
                                    <option value="{{$s->id}}">{{$s->store_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="helpblock"></span>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="update">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>







<script>
    $(function() {
        // view table po
        let table = $('.table-inv').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#form-modal').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('order.add')}}",
                type: 'post',
                data: $('#form-modal').serialize(),
                success: function(_response) {
                    $('#modal-edit').modal('toggle');
                    $('.table-inv').DataTable().ajax.reload()
                },
                error: function(_response) {
                    // Handle error
                }
            });
        });

        $('.close').click(function(e) {
            $('#modal-edit').modal('toggle');
        });
    })
</script>
@endsection