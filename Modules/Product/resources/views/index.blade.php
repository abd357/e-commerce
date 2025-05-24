@extends('layouts.master')

@section('content')
<div class="flex items-center justify-center w-3/4 mx-auto relative">
    @if (session('success'))
    <div class="absolute top-0 right-0 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>

    @endif
    @cannot('manage_product')


    @endcannot()
    @can('create_product')
    <div class="flex flex-col w-full p-4 gap-6">
        <div class="flex my-4 items-center justify-between h-20 gap-8 text-center">
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl">
                Total Revenue: ${{ $soldProducts->sum('total') }}
            </div>
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl"> 
                Products sold: {{ $soldProducts->sum('quantity') }}
            </div>
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl"> 
                Products Available: {{ $products->sum('quantity') }}
            </div>
        </div>
        
        <div class="relative">
            <h1 class="text-3xl text-center">Manage Products</h1>
            
            <a class="absolute right-0 top-[-1px] bg-blue-400 text-white text-center px-4 py-1 rounded"
            href="{{ route('product.create') }}">Add <span class="text-2xl font-bold">+</span></a>
        </div>
    </div>
    
    @endcan
    @cannot('manage_product')
    <div class="flex flex-col w-full p-4 gap-6">
        <div class="flex my-4 items-center justify-between h-20 gap-8 text-center">
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl">
                Total Spendings: ${{ $boughtProducts->sum('total') }}
            </div>
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl"> 
                Products Ordered: {{ $boughtProducts->sum('quantity') }}
            </div>
            <div class="shadow-lg p-4 w-3/4 h-28 bg-gray-100 text-2xl"> 
                Orders Placed: {{ $ordersPlaced->count() }}
            </div>
        </div>
        
        <div class="relative">
            {{-- <h1 class="text-3xl text-center">Manage Products</h1> --}}
            <h1 class="text-3xl my-6 text-center">Product Listing</h1>
            
            {{-- <a class="absolute right-0 top-[-1px] bg-blue-400 text-white text-center px-4 py-1 rounded"
            href="{{ route('product.create') }}">Add <span class="text-2xl font-bold">+</span></a> --}}
        </div>
    </div>
    
    @endcannot
</div>
<div class="">
    <table class="w-3/4 mx-auto text-md">
        <thead class="text-md text-gray-700 uppercase">
            <tr class="border-b border-gray-200">
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Product Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                @can('manage_product')
                <th scope="col" class="px-6 py-3">
                    SKU
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantity
                </th>
                @endcan
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                @can('manage_product')
                <th scope="col" class="px-6 py-3">
                    <span class="">Action</span>
                </th>
                @endcan
                @cannot('manage_product')
                <th scope="col" class="px-6 py-3">
                    <span class="">Action</span>
                </th>
                @endcannot
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 text-center">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                    {{$product->id}}
                </td>
                <td class="px-6 py-4 justify-items-center">
                    <img class="w-20 h-20 rounded-full object-cover"
                        src="{{ asset('storage/' . $product->product_image) }}" alt="">
                </td>
                <td class="px-6 py-4">
                    {{$product->name}}
                </td>
                @can('manage_product')
                    
                <td class="px-6 py-4">
                    {{$product->sku}}
                </td>
                <td class="px-6 py-4">
                    {{$product->quantity}}
                </td>
                @endcan
                <td class="px-6 py-4">
                    ${{$product->price}}
                </td>
                @can('edit_product')

                <td class="px-6 py-4 text-center space-x-4">
                    <a href="{{route('product.edit', $product->id)}}"
                        class="font-medium text-blue-600 hover:underline">Edit</a>
                    <a class="font-medium text-red-600 hover:underline cursor-pointer"
                        onclick="event.preventDefault();document.getElementById('delete-{{ $product->id }}').submit()">Delete</a>
                    <form id="delete-{{ $product->id }}"
                        action="{{ route('product.destroy',  ['product' => $product->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
                @endcan
                @cannot('manage_product')
                <td class="px-6 py-4">
                    <div class="flex justify-center space-x-2 text-center">
                        <a href="{{route('product.show', $product->id)}}"
                            class="font-medium text-blue-600 hover:underline">View
                        </a>
                        <form action="{{ route('cart.addToCart', ['id' => $product->id]) }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="font-medium text-green-600 hover:underline cursor-pointer">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </td>
                @endcannot
            </tr>

                    

            @endforeach
        </tbody>
    </table>
    @if(count($products) == 0)
    <div class="flex flex-col items-center justify-center h-96 gap-2">
        <p class="text-3xl font-medium">No Record Found</p>
        @can('manage_product')
        <a href="{{ route('product.create') }}" class="text-white bg-blue-500 p-2">Create new product</a>
        @endcan
    </div>
    @endif
</div>


@endsection