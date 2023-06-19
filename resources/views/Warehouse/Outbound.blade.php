@extends('Layouts.Sidebar')

@section('main')
    <div class="inbound-container pe-3">
        <table class="table mt-2 table-bordered">
            <thead class="table-secondary">
                <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">No SJ</th>
                <th scope="col">No P.O</th>
                <th scope="col">Brand</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td><button class="btn btn-primary float-end">Update</button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection