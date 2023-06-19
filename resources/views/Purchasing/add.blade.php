@extends('Layouts.Sidebar')

@section('main')
<div class="transation-container pe-3">
    <table class="table mt-2 table-bordered table-add-purchase">
        <thead class="table-secondary">
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">No Purchase</th>
                <th scope="col">Supplier</th>
                <th scope="col">No SJ</th>
                <th scope="col">Brand</th>
                <th scope="col">Kode Product</th>
                <th scope="col">Nama Product</th>
                <th scope="col">Qty</th>
                <th scope="col">Harga Modal</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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