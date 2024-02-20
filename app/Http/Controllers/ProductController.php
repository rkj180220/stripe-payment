<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\CardException;

class ProductController extends Controller
{

    public function index()
    {
        $products = Products::all();
        return view('products.index', compact('products'));
    }

    public function show(Request $request, Products $product)
    {
        $user = $request->user(); // Retrieve the authenticated user

        if ($request->isMethod('post')) {
            try {
                $user->charge($product->price * 100, $request->input('stripeToken'), [
                    'description' => 'Payment for ' . $product->name,
                ]);

                // Payment successful, you can redirect to a success page
                return redirect()->route('payment.success');
            } catch (CardException $e) {
                // Payment failed, handle the exception
                return back()->withError($e->getMessage());
            }
        }

        return view('products.show', compact('product'));
    }

    public function checkout(Request $request) {
        $product = Products::findOrFail($request->product_id);
        $user = Auth::user();

        return view('products.checkout', [
            'user'=>$user,
            'intent' => $user->createSetupIntent(),
            'product' => $product
        ]);
    }

    public function processPayment(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try
        {
            $user->charge($request->price*100, $paymentMethod);
        }
        catch (Exception $e)
        {
            return view('products.payment-failed', [
                'message' => 'Error making payment. ' . $e->getMessage()
            ]);
        }

        return view('products.payment-success');
    }

}
