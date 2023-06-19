<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::select('*')->orderBy('updated_at', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                           <div class="d-flex justify-content-center">
                                <button type="button" data-id='."$row->id".' class="edit btn btn-primary btn-sm" id="edit-button">Update</button>
                           </div>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master/Supplier/supplier');
    }

    /**
     * Method create
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $lastSupplier = Supplier::orderBy('id', 'desc')->first();
        $lastSupplier != null ? $data['supplier_code'] = "SUPPLIER-" . ($lastSupplier->id + 1) : $data['supplier_code'] = "SUPPLIER-1";
        $supplier = Supplier::create($data);
        return response()->json($supplier);
    }

    
    /**
     * Method edit
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        return response()->json($supplier);
    }
    
    /**
     * Method update
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $response = tap(Supplier::find($data['id']))->updateOrFail($data);
        return response()->json($response);
    }
}
