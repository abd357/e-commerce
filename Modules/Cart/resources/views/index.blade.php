@extends('layouts.master')

@section('content')
    
@if (!$cart)
<div class="w-2xl mx-auto text-center my-8">
    <p class="text-3xl font-medium">Your cart is empty</p>
    <a href="{{ route('product.index') }}" class="cursor-pointer">Get Started</a>
    @else
    
    @foreach ($cart as $item)
    <div class="shadow-xl p-4 w-lg h-40 my-4 mx-auto bg-gray-100">
        <div class="flex items-center justify-between mb-8">
            <div>

                <img class="w-30 h-30 rounded-full" src="{{ asset('storage/' . $item['product_image']) }}" alt="">
            </div>
            <div class="flex items-center justify-between flex-col">
                <p class="text-2xl text-gray-700">
                    <span class="text-2xl font-medium">Product: </span>{{ $item['product_name'] }}
                </p>
                <p class="text-2xl text-gray-700">
                    <span class="text-2xl font-medium">Price: </span>${{ $item['total'] }}
                </p>
                <p class="text-2xl text-gray-700">
                    <span class="text-xl font-medium">Quantity: </span>{{ $item['quantity'] }}
                </p>
            </div>
        </div>
        <div>
                
        </div>    
    </div>
    @endforeach
    
    <div class="flex items-center justify-between w-lg mx-auto my-8">
        <p class="text-2xl font-medium">Total Amount: ${{ collect($cart)->sum('total') }}</p>
        <form action="/checkout" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer">Proceed To Payment</button>
    </div>
</div>
@endif

@endsection