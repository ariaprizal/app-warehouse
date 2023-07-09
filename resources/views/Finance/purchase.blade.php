@extends('Layouts.Sidebar')

@section('main')
<div class="invoice-container pe-3">
    <div class="my-4">
        <h2>Purchasing List Done</h2>
    </div>
    <div class="table-responsive">
        <table class="table mt-2 table-bordered table-purchase">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">No Purchase</th>
                    <th scope="col">Purchasing</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Pelunasan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Status Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-modal">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" class="id" id="id" name="id">
                    <div class="form-group">
                        <label for="country">Status Pembayaran</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                            <select class="form-control" name="status_pembayaran" id="suppliers-modal">
                                <option value="">-- select one --</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                            </select>
                        </div>
                        <span class="helpblock"></span>
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

        // view table supplier
        let table = $('.table-purchase').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('finance.purchase') }}",
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'status_pembayaran',
                    name: 'status_pembayaran'
                },
                {
                    data: 'tgl_lunas',
                    name: 'tgl_lunas'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });



        $('body').on('click', '#edit-button', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#modal-edit').modal('toggle');
        });

        $('#form-modal').submit(function(e) {
            e.preventDefault();
            let id = $('#id').val();
            $.ajax({
                url: "{{route('finance.update-purchase')}}",
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

        $('.close').click(function(e) {
            $('#modal-edit').modal('toggle');
        });

    });
</script>
@endsection