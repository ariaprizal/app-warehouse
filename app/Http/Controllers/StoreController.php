<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StoreController extends Controller
{
    function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Store::select('*')->orderBy('updated_at', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                           <div class="d-flex justify-content-center">
                                <button type="button" data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm" id="edit-button">Update</button>
                           </div>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master/Store/storeList');
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
        $lastStore = Store::orderBy('id', 'desc')->first();
        $lastStore != null ? $data['store_code'] = "STORE-" . ($lastStore->id + 1) : $data['store_code'] = "STORE-1";
        $supplier = Store::create($data);
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
        $store = Store::where('id', $id)->first();
        return response()->json($store);
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
        $response = tap(Store::find($data['id']))->updateOrFail($data);
        return response()->json($response);
    }
}
