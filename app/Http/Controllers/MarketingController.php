<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function order()
    {
        return view('Marketing/Order');
    }
}
