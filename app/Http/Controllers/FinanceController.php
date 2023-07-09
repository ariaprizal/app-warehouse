<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{    

    /**
     * Method invoice
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function invoice(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::join('users', 'users.id', '=', 'invoices.created_by')
                            ->join('stores', 'stores.id', '=', 'invoices.store_id')
                            ->select('invoices.*', 'users.name', 'stores.store_name')->orderBy('updated_at', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                           <div class="d-flex">
                                <button type="button" data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm" id="edit-button">Update</button>
                           </div>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Finance/invoice');
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
        $tglLunas = $data['status_pembayaran'] == "Lunas" ? Carbon::now() : "";
        $response = tap(Invoice::find($data['id']))->updateOrFail(["status_pembayaran" => $data['status_pembayaran'], 'tgl_lunas' => $tglLunas]);
        return response()->json($response);
    }
    
    /**
     * Method purchase
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function purchase(Request $request)
    {
        if ($request->ajax()) {
            $data = Purchase::join('users', 'users.id', '=', 'purchases.created_by')
                            ->select('purchases.*', 'users.name')->orderBy('updated_at', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                           <div class="d-flex">
                                <button type="button" data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm" id="edit-button">Update</button>
                           </div>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Finance/purchase');
    }
    
    /**
     * Method updatePurchase
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updatePurchase(Request $request)
    {
        $data = $request->all();
        $tglLunas = $data['status_pembayaran'] == "Lunas" ? Carbon::now() : "";
        $response = tap(Purchase::find($data['id']))->updateOrFail(["status_pembayaran" => $data['status_pembayaran'], 'tgl_lunas' => $tglLunas]);
        return response()->json($response);
    }
}
