<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        return response()->json(['request' => $request->all()]);
    }
}
