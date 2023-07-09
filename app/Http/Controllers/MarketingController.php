<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceListing;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MarketingController extends Controller
{
    public function order(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::join('stores', 'stores.id', '=', 'invoices.store_id')->select('invoices.*', 'stores.store_name')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                           <div class="d-flex justify-content-center">
                                <a href="/marketing/view/' . $row->inv_code . '" class="edit btn btn-primary btn-sm">View</a>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $store = Store::all();
        return view('Marketing/Order', ['store' => $store]);
    }

    /**
     * Method add
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    function add(Request $request)
    {
        $invoice = Invoice::create($request->all());
        return response()->json($invoice);
    }

    /**
     * Method showInv
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function showInv(Request $request)
    {
        $code = explode('view/', url()->current());
        $invoice = Invoice::where('inv_code', $code[1])->first();
        $products = Product::all();
        return view('Marketing/detail', ['products' => $products, 'invoice' => $invoice]);
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
        $invoice = Invoice::where('inv_code', $code[1])->first();
        if ($request->ajax()) {
            $data = InvoiceListing::join('products', 'products.id', '=', 'invoice_listings.product_id')
                ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('invoices', 'invoices.inv_code', '=', 'invoice_listings.inv_code')
                ->where('invoice_listings.inv_code', $code[1])
                ->select(
                    'invoice_listings.id',
                    'invoice_listings.price',
                    'invoice_listings.qty',
                    'invoice_listings.type',
                    'invoices.inv_code',
                    'invoices.no_sj',
                    'invoices.status',
                    'suppliers.supplier_name',
                    'brands.brand_name',
                    'products.product_name',
                    'products.product_code',
                    'products.product_price',
                )
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $row->status == 'on created' ?
                        $btn = '
                           <div class="d-flex justify-content-center">
                                <button data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm ms-2" id="btn-cancel">Cancel</button>
                           </div>
                           ' : $btn = '';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $products = Product::all();
        return view('Marketing/detail', ['products' => $products, 'invoice' => $invoice]);
    }

    /**
     * Method addProduct
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function addProduct(Request $request)
    {
        $data = $request->all();
        $product = Product::where('id', $data['product_id'])->first();
        if (($data['discount'] == 0 && $product->good_stock < $data['qty']) || $data['discount'] != 0 && $product->bad_stock < $data['qty']) {
            return response()->json("Out Of Stock", 400);
        }

        $discount = $data['discount'] != 0 ? (($product->product_price * $data['discount']) / 100) : 0;
        $data['price'] = ($product->product_price - $discount) * $data['qty'];
        $data['type'] = $data['discount'] != 0 ? 'bad' : 'good';

        $code = explode('view/', $data['inv_code']);
        $data['inv_code'] = $code[1];
        try {
            DB::beginTransaction();
            Product::where('id', $data['product_id'])->update($data['discount'] != 0 ? ['bad_stock' => $product->bad_stock - $data['qty']] : ['good_stock' => $product->good_stock - $data['qty']]);
            $invoiceListing = InvoiceListing::create($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->json($invoiceListing);
    }

    /**
     * Method updateInv
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    function updateInvoice(Request $request)
    {
        $data = $request->all();
        $code = explode('view/', $data['code']);
        $invCode = $code[1];

        $invList = InvoiceListing::where('inv_code', $invCode)->get();
        $total = $invList->sum('price');
        try {
            DB::beginTransaction();
            Invoice::where('inv_code', $invCode)->update(['status' => 'waiting process', 'total_price' => $total]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return response()->json();
    }
}
