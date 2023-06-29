<?php

namespace App\Http\Controllers;

use App\Models\InvoiceListing;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceListingController extends Controller
{
    function delete(Request $request) {
        $id = $request->get('id');
        $invoiceListing = InvoiceListing::where('id', $id)->first();
        $product = Product::where('id', $invoiceListing->product_id)->first();
        try {
            DB::beginTransaction();
                Product::where('id', $invoiceListing->product_id)->update($invoiceListing->type == 'bad' ? ['bad_stock' => $product->bad_stock + $invoiceListing->qty] : ['good_stock' => $product->good_stock + $invoiceListing->qty ]);
                InvoiceListing::find($id)->delete($id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->json();
    }
}
