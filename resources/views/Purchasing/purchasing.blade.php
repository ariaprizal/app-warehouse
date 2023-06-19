@extends('Layouts.Sidebar')

@section('main')
<div class="transation-container pe-3">
    <button data-bs-toggle="modal" data-bs-target="#modal-edit" class="btn btn-secondary mt-3 mb-3">Add Purchase Order</button>
    <table class="table mt-2 table-bordered table-purchase">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Tanggal</th>
                <th scope="col">No Purchase Order</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Add PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-modal">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">No Po</label>
                        <input value="" type="text" name="po_code" class="po_code form-control" id="po_code" placeholder="No Po">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nomor Surat Jalan</label>
                        <input value="" type="text" name="no_sj" class="no_sj form-control" id="no_sj" placeholder="No Surat Jalan">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
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
        let table = $('.table-purchase').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('purchase') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                url: "{{route('purchase.add')}}",
                type: 'post',
                data: $('#form-modal').serialize(),
                success: function(_response) {
                    $('#modal-edit').modal('toggle');
                    $('.table-purchase').DataTable().ajax.reload()
                },
                error: function(_response) {
                    // Handle error
                }
            });
        });
    })
</script>
@endsection