@extends('layouts.master')

@section('content')

<div class="max-w-2xl mx-auto my-10 bg-white p-6 rounded shadow">
    
    <h2 class="pb-4 text-3xl text-center">Edit Product</h2>
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('product.update', $id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @foreach($product as $item)
        
        <div class="mb-4 relative">
            <label id="product_image" class="block text-gray-700 font-medium mb-2">Product Image</label>
            <img class="w-28 h-28 object-cover" src="{{ asset('storage/' . $item['product_image']) }}" alt="">
            <input id="product_image" type="file" name="product_image" 
                class="w-28 h-28 absolute bottom-0 opacity-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Product Name</label>
            <input type="text" name="name" value="{{ $item['name'] }}" required
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4" required
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{$item['description'] }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Price</label>
            <input type="number" name="price" value="{{ $item['price'] }}" step="0.01" min="0" required
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">SKU</label>
            <input type="text" name="sku" value="{{ $item['sku'] }}" step="0.01" min="0" required
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Quantity</label>
            <input type="number" name="quantity" value="{{ $item['quantity'] }}" step="0.01" min="0" required
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        @endforeach
        <button type="submit"
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Save Changes
        </button>
    </form>
    
</div>
    
@endsection
