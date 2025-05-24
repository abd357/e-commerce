<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function index()
    {
        return redirect('carts');
    }

    public function checkout()
    {
        $user = Auth::id();
        $cart = session()->get('cart', []);
        $line_items = [];
        foreach ($cart as $key => $value) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $value['product_name'],
                    ],
                    'unit_amount' => $value['price'] * 100,
                ],
                'quantity' => $value['quantity'],
            ];
        }
        $total = collect($cart)->sum('total') * 100;

        \Stripe\Stripe::setApiKey(config('stripe.sk'));
            
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);
        foreach($cart as $key => $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
        $order = Order::create([
            'user_id' => $user,
            'total_price' => $total / 100,
            'status' => 'completed',
            'orderProducts' => [],  
        ]);
        
        foreach ($cart as $key => $value) {
            $order->orderProducts()->create([
                'product_name' => $value['product_name'],
                'unit_price' => $value['price'],
                'quantity' => $value['quantity'],
                'total' => $value['total'],
                'buyer_id' => Auth::id(),
                'product_id' => $value['product_id'],
                'seller_id' => $value['seller_id'],
            ]);
        }
        return redirect()->away($session->url);
    }
    

    public function success()
    {
        session()->forget('cart');
        return redirect('/product');
    }
}
