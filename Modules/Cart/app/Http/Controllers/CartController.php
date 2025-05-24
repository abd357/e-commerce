<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Product\Models\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $cart = session()->get('cart');
        // dd($cart);
        return view('cart::index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        $cart = $request->session()->get('cart', []);
        // dd($cart);
        // collect($cart)->sum('total');
        
        if (isset($cart[$product->id])) {
            
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['total'] = $cart[$product->id]['quantity'] * $cart[$product->id]['price'];
        } else {
            $cart[$product->id] = [
                'product_name' => $product->name,
                'product_id' => $product->id,
                'quantity' => 1,
                'product_image' => $product->product_image,
                'price' => $product->price,
                'total' => $product->price,
                'seller_id' => $product->user_id,
                'buyer_id' => Auth::id(),


            ];
        }

        
        $request->session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cart::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('cart::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('cart::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
