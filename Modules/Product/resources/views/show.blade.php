@extends('layouts.master')

@section('content')

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow relative">
    @if (session('success'))
    <div class="absolute z-99 top-[-38px] right-0 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>
    
    @endif
    {{-- @dd($product->toArray()) --}}
    @foreach ($product as $item )
        
    <h2 class="pb-4 text-3xl text-center">{{ $item['name'] }} Info</h2>
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="flex gap-1">
        <div class="w-1/2 h-96 p-4">
            <h3 class="font-semibold mb-2">Product Image</h3>
            <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item['name'] }}" class="w-48 h-48 object-cover">
        </div>
        <div class="w-1/2 h-96 bg-gray-100 border border-gray-300 rounded p-4">
            <h3 class="font-semibold mb-2">Product Details</h3>
            <p><strong>Description:</strong> {{ $item['description'] }}</p>
            <p><strong>Price:</strong> ${{ number_format($item['price'], 2) }}</p>
            <p><strong>SKU:</strong> {{ $item['sku'] }}</p>
            <p><strong>Quantity:</strong> {{ $item['quantity'] }}</p>
            <div class="bg-gray-100 border border-gray-300 rounded p-4 mt-4">
                <h3 class="font-semibold mb-2">Actions</h3>
                <form action="{{ route('cart.addToCart', ['id' => $item['id']]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Add to Cart
                    </button>
                </form>
                {{-- <form action="{{ route('product.addToCart', $item['id']) }}" method="POST"> --}}
                    {{-- @csrf --}}
                    {{-- <button 
                    onclick="addToCart.call(this)"
                    data-id= {{ $item['id'] }}
                    data-name= {{ $item['name'] }}
                    data-price= {{ $item['price'] }}
                    class= "bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Add to Cart
                    </button>
                    <button  --}}
                    {{-- onclick="addToCart.call(this)" --}}
                    {{-- data-id= {{ $item['id'] }} --}}
                    {{-- data-name= {{ $item['name'] }} --}}
                    {{-- data-price= {{ $item['price'] }} --}}
                    {{-- class= "add-to-cart bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"> --}}
                        {{-- Add to Cart --}}
                    {{-- </button> --}}
                {{-- </form> --}}
            </div>
        </div>

    </div>
    {{-- <form action="{{ route('product.update', $id) }}" method="POST">
        @method('PUT')
        @csrf
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
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Save Changes
        </button>
    </form> --}}
    @endforeach

</div>

<script>
    function addToCart() {
        const productId = this.dataset.id;
        const productName = this.dataset.name;
        const productPrice = parseFloat(this.dataset.price);
        let quantity = 0;
        
        const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
        
        const existingItem = cart.find(item => item.id == productId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }
        
        sessionStorage.setItem('cart', JSON.stringify(cart));

        cart.forEach(product => {
            product.price = parseFloat(product.price);
            product.quantity = parseFloat(product.quantity);
            product.total = product.price * product.quantity;
            product.total = product.total.toFixed(2);
            // console.log(product.total);
        });
        // console.log(existingItem.quantity + productName + ' added to cart!'); 
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const productPrice = parseFloat(this.dataset.price);
                
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                
                const existingItem = cart.find(item => item.id == productId);
                if (existingItem) {
                    // console.log(existingItem);
                    existingItem.quantity += 1;
                    existingItem.total = existingItem.price * existingItem.quantity;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1,
                        total: productPrice * 1
                    });
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));
                // console.log(cart);
                let totalBill = cart.reduce((sum, item) => sum + item.total, 0);
                console.log('Total Bill:', totalBill);
                // for (let i = 0; i < cart.length; i++) {
                //     const totalPrice = cart[i].total + cart[j].total;
                //     console.log(totalPrice);

                    
                // }
                cart.forEach(product => {
                    
                    // console.log(product, product.total);
                    localStorage.setItem('cart', JSON.stringify(cart));
                })
            });
        });
    });
    

    // Add your JavaScript code here if needed
</script>

@endsection