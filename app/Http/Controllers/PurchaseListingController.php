<?php

namespace App\Http\Controllers;

use App\Models\Purchase_listing;
use Illuminate\Http\Request;

class PurchaseListingController extends Controller
{    
    /**
     * Method delete
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    function delete(Request $request) {
        $id = $request->get('id');
        Purchase_listing::find($id)->delete($id);
        return response()->json();
    }
}
