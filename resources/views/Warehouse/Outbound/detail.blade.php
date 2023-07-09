@extends('Layouts.Sidebar')

@section('main')

<div class="transation-container mt-5 pe-3">
    <h4 class="mb-5">Detail Invoice {{$invoice->inv_code}}</h4>
    <div class="row mb-5 text-center">
        <div class="col-6 d-flex justify-content-around">
            <span class="fw-bolder">Nomor Invoice :</span>
            <span class="">{{$invoice->inv_code}}</span>
        </div>
        <div class="col-6 d-flex justify-content-around">
            <span class="fw-bolder">Nomor SJ :</span>
            <span class=""> {{$invoice->no_sj}}</span>
        </div>
        <hr class="my-2" />
    </div>
    <div class="table-responsive w-full" style="overflow-x: hidden;">
        <table class="table table-bordered table-process ">
            <thead class="table-secondary">
                <tr>
                    <th style="width: 20px;">Id</th>
                    <th style="width: 120px;">Kode Product</th>
                    <th >Product</th>
                    <th style="width: 20px;">Qty</th>
                    <th style="width: 20px;">type</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @if($invoice->status != 'done')
    <button class="btn btn-primary float-end my-5" style="width: 150px; height: 40px;" id="btn-done">Done</button>
    @endif





    <script>
        $(function() {

            // view table po detail
            const code = window.location.href
            let table = $('.table-process').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: 'GET',
                    url: `{{route('outbound.process')}}`,
                    data: {
                        code: code,
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'product_code',
                        name: 'product_code'
                    },
                    {
                        data: "product_name",
                        render: function(data, type, row) {
                            return `${row.supplier_name} - ${row.brand_name} - ${row.product_name} - ${row.product_color} - ${row.product_size}`;
                        }
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    }
                ]
            });

            $('body').on('click', '#btn-done', function() {

                //fetch detail post with ajax
                $.ajax({
                    url: "{{route('outbound.done')}}",
                    data: {
                        code: code,
                        _token: '{{csrf_token()}}'
                    },
                    type: "patch",
                    cache: false,
                    success: function(response) {
                        window.location.href = '/warehouse/outbound-done'
                    }
                });
            });
        })
    </script>
    @endsection