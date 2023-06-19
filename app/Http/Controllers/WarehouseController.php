<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchase_listing;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{

    function dashboard()
    {
        return view('warehouse/dashboard');
    }


    //////////////////////////////////////////// INBOUND /////////////////////////////////////////////////////////////////

    /**
     * Method inbound
     *
     * @return void
     */
    public function inbound(Request $request)
    {
        if ($request->ajax()) {
            $data = Purchase::where('status', 'on delivery')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                           <div class="d-flex justify-content-center">
                                <a href="/warehouse/inbound/' . $row->po_code . '"  data-id=' . "$row->po_code" . ' class="edit btn btn-primary btn-sm">Process</a>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Warehouse/inbound/inbound');
    }

    /**
     * Method view
     *
     * @return void
     */
    function view($code)
    {
        $products = Product::all();
        $purchase = Purchase::where('po_code', $code)->first();
        return view('Warehouse/inbound/detail', ['products' => $products, 'purchase' => $purchase]);
    }

    /**
     * Method inboundProcess
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function inboundProcess(Request $request)
    {
        $rawData = $request->all();
        $code = explode('inbound/', $rawData['code']);
        Purchase::where('po_code', $code[1])->update(['status' => "on process"]);
        if ($request->ajax()) {
            $data = Purchase_listing::join('products', 'products.id', '=', 'purchase_listings.product_id')
                ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('purchases', 'purchases.po_code', '=', 'purchase_listings.po_code')
                ->where('purchase_listings.po_code', $code[1])
                ->select('purchase_listings.*', 'brands.brand_name', 'suppliers.supplier_name', 'purchases.no_sj', 'products.product_code', 'products.product_name', 'products.product_size', 'products.product_color', 'products.good_stock', 'products.bad_stock');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = $row->status == false ? '
                           <div class="d-flex justify-content-center">
                                <button data-id=' . "$row->id" . ' class="edit btn btn-primary btn-sm ms-2" id="edit-button">Update</button>
                           </div>
                           ' : '';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $products = Product::all();

        return view('warehouse/inbound/detail', ['products' => $products]);
    }

    /**
     * Method update
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    function updateListing(Request $request)
    {
        $data = $request->all();
        
        $purchase = Purchase_listing::where('id', $data['id'])->first();
        $data['good_stock'] == null && $data['good_stock'] = 0;
        $data['bad_stock'] == null && $data['bad_stock'] = 0;

        $product = Product::where('id', $purchase['product_id'])->first();
        $data['good_stock'] = $product['good_stock'] + $data['good_stock'];
        $data['bad_stock'] = $product['bad_stock'] + $data['bad_stock'];
        try {
            DB::beginTransaction();
            $response = Product::find($purchase['product_id'])->updateOrFail($data);
            if ($response) {
                Purchase_listing::find($data['id'])->updateOrFail(['status' => true]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return response()->json($purchase);
    }

    ///////////////////////////////////////////////////// END INBOUND ///////////////////////////////////////////////////

    ///////////////////////////////////////////////////// INBOUND PROCESS ///////////////////////////////////////////////////
        
    /**
     * Method process
     *
     * @return void
     */
    function process()  {
        return view('Warehouse/inbound/Process');
    }

    /**
     * Method process
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function inboundProcessView(Request $request)
    {
        if ($request->ajax()) {
            $data = Purchase::where('status', 'on process')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                           <div class="d-flex justify-content-center">
                                <a href="/warehouse/inbound/' . $row->po_code . '"  data-id=' . "$row->po_code" . ' class="edit btn btn-primary btn-sm">Process</a>
                           ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Method viewProcess
     *
     * @return void
     */
    function viewProcess()
    {
        $products = Product::all();
        return view('Warehouse/inbound/detail', ['products' => $products]);
    }

        
    /**
     * Method processUpdate
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    function processUpdate(Request $request)
    {
        $data = $request->all();
        $code = explode('inbound/', $data['code']);
        $poCode = $code[1];
        Purchase::where('po_code', $poCode)->update(['status' => 'done']);
        return response()->json();
    }

    ///////////////////////////////////////////////////// END INBOUND PROCESS ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////// INBOUND DONE ///////////////////////////////////////////////////
    
    /**
     * Method doneList
     *
     * @return void
     */
    function doneList()
    {
        $products = Product::all();
        return view('Warehouse/Inbound/done', ['products' => $products]);
    }
    
    /**
     * Method inboundDoneList
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function inboundDoneList(Request $request)
    {
        if ($request->ajax()) {
            $data = Purchase::where('status', 'done')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                           <div class="d-flex justify-content-center">
                                <a href="/warehouse/inbound/' . $row->po_code . '"  data-id=' . "$row->po_code" . ' class="edit btn btn-primary btn-sm">Detail</a>
                           ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    


    ///////////////////////////////////////////////////// END INBOUND DONE ///////////////////////////////////////////////////
    /**
     * Method outbound
     *
     * @return void
     */
    public function outbound()
    {
        return view('Warehouse/outbound');
    }

    /**
     * Method create
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $brands = Brand::all();
        return view('Warehouse/create', ['products' => $products, 'suppliers' => $suppliers, 'brands' => $brands]);
    }

    public function submitProduct(Request $request)
    {
        $product = Product::all();
        $data = $request->json()->all();
        return view('Warehouse/create', ["products" => $product]);
    }
}
