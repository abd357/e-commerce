@extends('layouts.master')

@section('content')
    
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="pb-4 text-3xl text-center">Add New Product</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- <div class="grid place-items-center">
            <div class="rounded-full w-28 h-28 border border-slate-400 relative overflow-hidden">
                <label class="absolute grid inset-0 content-end cursor-pointer" for="avatar"><span
                        class="bg-white/70 text-center pb-2">Avatar</span></label>
                <input class="" type="file" id="avatar" @input="change" hidden>
                <img class="w-28 h-28 object-cover" :src="formData.preview" alt="">
            </div>
            <p class="text-red-500" v-if="formData.errors">{{ formData.errors.avatar }}</p>
        </div> --}}

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Product Image</label>
            <input type="file" name="product_image"
                   class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>


        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Price</label>
            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">SKU</label>
            <input type="text" name="sku" value="{{ old('sku') }}" step="0.01" min="0"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity') }}" step="0.01" min="0"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Save Product
        </button>
    </form>

</div>

@endsection
