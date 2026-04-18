@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white shadow rounded p-5 mb-6">
        <h3 class="text-lg font-semibold mb-4">Filter Products</h3>

        <form method="GET" action="{{ route('products.index') }}" 
      class="grid grid-cols-1 md:grid-cols-4 gap-4">

    <!-- 🔍 SEARCH -->
    <div>
        <label class="block mb-1">Search Product</label>
        <input type="text" name="search" 
               value="{{ request('search') }}"
               placeholder="Search by name..."
               class="w-full border rounded p-2">
    </div>

    <!-- CATEGORY -->
    <div>
        <label class="block mb-1">Category</label>
        <select name="category" class="w-full border rounded p-2">
            <option value="">All</option>
            <option value="Fruits" {{ request('category') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
            <option value="Vegetables" {{ request('category') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
            <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
        </select>
    </div>

    <!-- PRICE -->
    <div>
        <label class="block mb-1">Max Price</label>
        <input type="number" name="price" 
               value="{{ request('price') }}" 
               class="w-full border rounded p-2">
    </div>

    <!-- BUTTON -->
    <div class="flex items-end gap-2">
        <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
            Search
        </button>

        <!-- 🔄 RESET BUTTON -->
        <a href="{{ route('products.index') }}"
           class="w-full text-center bg-gray-400 text-white p-2 rounded hover:bg-gray-500">
           Reset
        </a>
    </div>

</form>
    </div>

    <!-- Products Grid -->
    <h2 class="text-xl font-bold mb-4">All Products</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($products as $product)

        <div class="bg-white shadow rounded p-4 flex flex-col justify-between">

    <div>
        <h3 class="text-lg font-bold">{{ $product->name }}</h3>
        <p class="text-gray-500">{{ $product->category }}</p>

        <p class="mt-2"><strong>Price:</strong> ₹{{ $product->price }}</p>
        <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
        <p><strong>Bidding:</strong> {{ $product->is_bidding ? 'Yes' : 'No' }}</p>

        <!-- Highest Bid -->
        <p class="mt-2">
            <strong>Highest Bid:</strong> 
            {{ $product->bids->max('bid_amount') ?? 'No bids yet' }}
        </p>

        <!-- Status -->
        @if($product->bidding_end_time)
            <p>
                <strong>Status:</strong>
                <span class="{{ now()->greaterThan($product->bidding_end_time) ? 'text-red-600' : 'text-green-600' }}">
                    {{ now()->greaterThan($product->bidding_end_time) ? 'Closed' : 'Open' }}
                </span>
            </p>
        @endif

        <!-- Timer -->
        @if($product->bidding_end_time)
            <p>
                <strong>Time Left:</strong> 
                <span id="timer-{{ $product->id }}" class="font-semibold text-blue-600"></span>
            </p>
        @endif
    </div>

    <!-- 🔥 ACTION BUTTONS -->
    <div class="mt-4 space-y-2">

        <!-- View Details -->
        <a href="{{ route('products.show', $product->id) }}"
           class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           View Details
        </a>

        <!-- Bid Form -->
        @if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
            <form method="POST" action="{{ route('bids.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="flex gap-2 mt-2">
                    <input type="number" name="bid_amount" placeholder="Enter bid"
                        class="flex-1 border rounded p-2" required>

                    <button class="bg-green-600 text-white px-4 rounded hover:bg-green-700">
                        Bid
                    </button>
                </div>
            </form>
        @endif

        <!-- Winner -->
        @php
            $highestBid = $product->bids->sortByDesc('bid_amount')->first();
        @endphp

        @if($product->bidding_end_time && now()->greaterThan($product->bidding_end_time))
            <p class="text-green-600 font-semibold text-sm">
                Winner: {{ $highestBid && $highestBid->user ? $highestBid->user->name : 'No bids' }}
            </p>
        @endif

    </div>

</div>

        @empty
            <p class="text-red-500">No products found.</p>
        @endforelse

    </div>
</div>

<!-- 🔥 TIMER SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    @foreach($products as $product)
        @if($product->bidding_end_time)

            let endTime{{ $product->id }} = new Date("{{ $product->bidding_end_time }}").getTime();

            let timer{{ $product->id }} = setInterval(function () {

                let now = new Date().getTime();
                let distance = endTime{{ $product->id }} - now;

                if (distance <= 0) {
                    clearInterval(timer{{ $product->id }});
                    document.getElementById("timer-{{ $product->id }}").innerHTML = "Bidding Closed";
                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("timer-{{ $product->id }}").innerHTML =
                    hours + "h " + minutes + "m " + seconds + "s";

            }, 1000);

        @endif
    @endforeach

});
</script>

@endsection