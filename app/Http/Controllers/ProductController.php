<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\CardException;

class ProductController extends Controller
{

    public function index()
    {
        $products = Products::all();
        return view('products.index', compact('products'));
    }

    public function show(Request $request,Products $product)
    {
        Log::error($product);
        Log::error($request);
        if ($request->isMethod('post')) {
            try {
                $request->user()->charge($product->price * 100, $request->input('stripeToken'));

                // Payment successful, you can redirect to a success page
                return redirect()->route('payment.success');
            } catch (CardException $e) {
                // Payment failed, handle the exception
                return back()->withError($e->getMessage());
            }
        }

        return view('products.show', compact('product'));
    }

}
