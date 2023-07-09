<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchase_listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchasingController extends Controller
{
    /**
     * Method transaction
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function purchase(Request $request)
    {
        if ($request->ajax()) {
            $data = Purchase::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                           <div class="d-flex justify-content-center">
                                <a href="/purchasing/view/' . $row->po_code . '" class="edit btn btn-primary btn-sm">View</a>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Purchasing/purchasing');
    }

    /**
     * Method detail
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function detail($id)
    {
        $purchase = Purchase::find($id)->first();
        return view('Purchasing/detail', ['purchase' => $purchase]);
    }

    /**
     * Method add
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function add(Request $request)
    {
        $purchase = Purchase::create($request->all());
        return response()->json($purchase);
    }

    /**
     * Method insertProduct
     *
     * @param Type $var [explicite description]
     *
     * @return void
     */
    public function showPo(Request $request)
    {
        $code = explode('view/', url()->current());
        $purchase = Purchase::where('po_code', $code[1])->first();
        $products = Product::all();
        return view('Purchasing/viewPo', ['products' => $products, 'purchase' => $purchase]);
    }

    /**
     * Method showListings
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function showListings(Request $request)
    {
        $rawData = $request->all();
        $code = explode('view/', $rawData['code']);
        $purchase = Purchase::where('po_code', $code[1])->first();
        if ($request->ajax()) {
            $data = Purchase_listing::join('products', 'products.id', '=', 'purchase_listings.product_id')
                ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('purchases', 'purchases.po_code', '=', 'purchase_listings.po_code')
                ->where('purchase_listings.po_code', $code[1])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                           <div class="d-flex justify-content-center">
                                <button data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm ms-2" id="btn-cancel">Cancel</button>
                           </div>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $products = Product::all();
        return view('Purchasing/viewPo', ['products' => $products, 'purchase' => $purchase]);
    }

    /**
     * Method addProduct
     *
     * @param Type $var [explicite description]
     *
     * @return void
     */
    public function addProduct(Request $request)
    {
        $data = $request->all();
        $code = explode('view/', $data['po_code']);
        $data['po_code'] = $code[1];
        $purchaseListing = Purchase_listing::create($data);
        return response()->json($purchaseListing);
    }

    /**
     * Method updatePurchase
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    function updatePurchase(Request $request)
    {
        $data = $request->all();
        $code = explode('view/', $data['code']);
        $poCode = $code[1];

        $productList = Purchase_listing::join('products', 'products.id', '=', 'purchase_listings.product_id')->where('po_code', $poCode)->get();

        $total = 0;
        foreach ($productList as $product) 
        {
            $total += $product->qty * $product->product_capital;
        }
        try {
            DB::beginTransaction();
                Purchase::where('po_code', $poCode)->update(['status' => 'on delivery', 'total_price' => $total ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return response()->json();
    }
}
