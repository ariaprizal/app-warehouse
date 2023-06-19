<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Method getByIdSupplier
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function getByIdSupplier(Request $request)
    {
        $brands = Brand::where('supplier_id', $request->get('id'))->get();
        return response()->json($brands);
    }

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
            $data = Brand::join('suppliers', 'suppliers.id', '=', 'brands.supplier_id')->select('brands.*', 'suppliers.supplier_name')->orderBy('updated_at', 'asc');
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
        $suppliers = Supplier::all();
        return view('Master/Brand/brand', ['suppliers' => $suppliers]);
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
        $lastBrand = Brand::orderBy('id', 'desc')->first();
        $lastBrand != null ? $data['brand_code'] = "BRAND-" . ($lastBrand->id + 1) : $data['brand_code'] = "BRAND-1";
        $supplier = Brand::create($data);
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
        $product = Brand::where('id', $id)->first();
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
        $data['supplier_id'] == null && $data['supplier_id'] = $data['supplier'];
        $response = tap(Brand::find($data['id']))->updateOrFail($data);
        return response()->json($response);
    }
}
