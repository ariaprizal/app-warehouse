<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
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
            $data = Product::select('*');
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

        $suppliers = Supplier::all();
        $brands = Brand::all();

        return view('Master/Product/product', ['suppliers' => $suppliers, 'brands' => $brands]);
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
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $lastProduct != null ? $data['product_code'] = "PRODUCT-" . ($lastProduct->id + 1) : $data['product_code'] = "PRODUCT-1";
        $product = Product::create($data);
        return response()->json($product);
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
        $product = Product::join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                            ->join('brands', 'brands.id', '=', 'products.brand_id')
                            ->select('products.*', 'suppliers.supplier_name', 'brands.brand_name')
                            ->where('products.id', $id)->first();
        return response()->json($product);
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
        if ($data['supplier_id'] == null && $data['brand_id'] == null) {
            $data['supplier_id'] = $data['supplier'];
            $data['brand_id'] = $data['brand'];
        }
        $response = tap(Product::find($data['id']))->updateOrFail($data);
        return response()->json($response);
    }
}
