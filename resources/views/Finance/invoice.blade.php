@extends('Layouts.Sidebar')

@section('main')
    <div class="invoice-container pe-3">
        <table class="table mt-2 table-bordered">
            <thead class="table-secondary">
                <tr>
                <th scope="col">No P.O</th>
                <th scope="col">Marketing</th>
                <th scope="col">Toko</th>
                <th scope="col">Qty</th>
                <th scope="col">Harga Total</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Pelunasan</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <th>1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td><button class="btn btn-primary float-end">update</button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection