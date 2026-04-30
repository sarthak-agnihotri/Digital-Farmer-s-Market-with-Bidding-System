@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">

    <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
        Edit Product
    </h2>

    <!-- ❌ Error Messages -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div>
            <label class="block font-semibold mb-1">Product Name</label>
            <input type="text" name="name"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400"
                value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>
        </div>

        <!-- Category -->
        <div>
            <label class="block font-semibold mb-1">Category</label>
            <select name="category"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400">
                <option value="">-- Select Category --</option>
                <option value="Fruits" {{ old('category', $product->category) == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                <option value="Vegetables" {{ old('category', $product->category) == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                <option value="Grains" {{ old('category', $product->category) == 'Grains' ? 'selected' : '' }}>Grains</option>
            </select>
        </div>

        <!-- Price -->
        <div>
            <label class="block font-semibold mb-1">Price (₹)</label>
            <input type="number" step="0.01" name="price"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400"
                value="{{ old('price', $product->price) }}" placeholder="Enter price" required>
        </div>

        <!-- Quantity -->
        <div>
            <label class="block font-semibold mb-1">Quantity</label>
            <input type="number" name="quantity"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400"
                value="{{ old('quantity', $product->quantity) }}" placeholder="Enter quantity" required>
        </div>

        <!-- Image Upload -->
        <div>
            <label class="block font-semibold mb-1">Product Image</label>
            <input type="file" name="image"
                class="w-full border border-gray-300 rounded px-3 py-2">

            <!-- 🔥 Current Image Preview -->
            @if($product->image)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-32 rounded border">
                </div>
            @endif

            <!-- New Image Preview -->
            <img id="preview" class="mt-3 h-32 hidden rounded border">
        </div>

        <!-- Bidding Toggle -->
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_bidding" id="biddingCheck" {{ old('is_bidding', $product->is_bidding) ? 'checked' : '' }}>
            <label for="biddingCheck" class="font-semibold">Enable Bidding</label>
        </div>

        <!-- Bidding Fields -->
        <div id="biddingFields" class="space-y-3 {{ !old('is_bidding', $product->is_bidding) ? 'hidden' : '' }}">

            <div>
                <label class="block font-semibold mb-1">Buy Now Price (₹)</label>
                <input type="number" step="0.01" name="buy_now_price"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ old('buy_now_price', $product->buy_now_price) }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">Bidding End Time</label>
                <input type="datetime-local" name="bidding_end_time"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ old('bidding_end_time', $product->bidding_end_time ? \Carbon\Carbon::parse($product->bidding_end_time)->format('Y-m-d\TH:i') : '') }}">
            </div>

        </div>

        <!-- Submit Button -->
        <div class="text-center mt-4 flex gap-3 justify-center">
            <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition shadow">
                Update Product
            </button>
            <a href="{{ route('dashboard') }}"
                class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition shadow">
                Cancel
            </a>
        </div>

    </form>

</div>

<!-- 🔥 SCRIPT SECTION -->
<script>

    // Toggle bidding fields
    document.getElementById('biddingCheck').addEventListener('change', function () {
        document.getElementById('biddingFields').classList.toggle('hidden', !this.checked);
    });

    // Image preview
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        let file = e.target.files[0];

        if(file){
            let reader = new FileReader();

            reader.onload = function(e){
                let img = document.getElementById('preview');
                img.src = e.target.result;
                img.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        }
    });

</script>

@endsection
