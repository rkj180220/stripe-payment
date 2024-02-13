<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Products::all();
        return view('products.index', compact('products'));
    }

    public function show(Products $product)
    {
        return view('products.show', compact('product'));
    }

}
