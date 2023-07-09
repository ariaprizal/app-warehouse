@extends('Layouts.Sidebar')

@section('main')
<div class="inbound-container pe-3">
    <h2 class="my-3">Purchase Ready to process</h2>
    <table class="table mt-2 table-bordered table-inbound">
        <thead class="table-secondary">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">No PO</th>
                <th scope="col">No SJ</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>






<script>
    $(function() {
        // view table po
        let table = $('.table-inbound').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('inbound') }}",
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

    })
</script>
@endsection