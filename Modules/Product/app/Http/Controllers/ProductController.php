<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\Models\Product;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    { 
        if (Auth::user()->hasRole('admin')) {
            $userId = Auth::id();
            $products = Product::where('user_id', $userId)->get(); 
            $soldProducts = OrderProduct::where('seller_id', $userId)->get();
            return view('product::index', compact('products', 'soldProducts'));
        } else {
            $products = Product::all();
            $boughtProducts = OrderProduct::where('buyer_id', Auth::user()->id)->get();
            $ordersPlaced = Order::where('user_id', Auth::user()->id)->get();
            return view('product::index', compact('products', 'boughtProducts', 'ordersPlaced'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasRole('admin')) {
            return view('product::create');
        } else {
            return redirect('product')->with('error', 'You do not have permission to create a product.');
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $fields = $request->validate([
            'name' => 'required | max:255',
            'product_image' => 'file | nullable',
            'description' => 'max:255',
            'sku' => 'max:255',
            'price' => 'max:255',
            'quantity' => 'numeric',
        ]);
        if ($request->product_image) {
            $fields['product_image'] = $request->file('product_image')->store('product', 'public');
        }

        $product = $request->user()->products()->create($fields);
        
        return redirect('product');
    }
    
    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {   
        // dd($product);
        $id = $product->id;
        $product = Product::where('id', $id)->get();
        return view('product::show', compact('id', 'product'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Product $product)
    {
        if(Auth::user()->hasRole('admin') && Auth::user()->id === $product->user_id) {
            $id = $product->id;
            $product = Product::where('id', $id)->get();
            return view('product::edit', compact('id', 'product'));
        } else {
            return redirect('product')->with('error', 'You do not have permission to edit this product.');
        }
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Product $product) 
    {
        if(Auth::user()->hasRole('admin') && Auth::user()->id === $product->user_id) {
            $fields = $request->validate([
                'name' => 'required | max:255',
                'product_image' => 'file | nullable',
                'description' => 'max:255',
                'sku' => 'max:255',
                'price' => 'max:255',
                'quantity' => 'numeric',
            ]);

            if ($request->product_image) {
                $fields['product_image'] = $request->file('product_image')->store('product', 'public');
            }

            $product = Product::where('id', $product->id)->get()->first();
            $product->update($fields);
            return redirect('product');
        } else {
            return redirect('product')->with('error', 'You do not have permission to edit this product.');
        }
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) 
    {
        if(Auth::user()->hasRole('admin') && Auth::user()->id === $product->user_id) {
            $product = Product::findOrFail($product->id);
            $product->delete();
            return redirect('product');
        } else {
            return redirect('product')->with('error', 'You do not have permission to delete this product.');
        }
    }
}
