@extends('Layouts.Sidebar')

@section('main')
<div class="inbound-container pe-3">
    <h2 class="my-3">Invoices Done / On delivery</h2>
    <div class="table-responsive">
        <table class="table mt-2 table-bordered table-outbound">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Invoice</th>
                    <th scope="col">No SJ</th>
                    <th scope="col">Store</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>






<script>
    $(function() {
        // view table po
        let table = $('.table-outbound').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('doneList.outbound') }}",
            columns: [
                {
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
                    data: 'store_name',
                    name: 'store_name'
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