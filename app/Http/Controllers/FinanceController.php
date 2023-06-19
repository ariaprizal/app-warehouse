<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function invoice()
    {
        return view('Finance/invoice');
    }
}
