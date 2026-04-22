@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

<!-- Alerts -->
@if(session('success'))
    <div class="bg-green-200/40 backdrop-blur border border-green-300 text-green-800 p-3 rounded-lg mb-4 shadow">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-200/40 backdrop-blur border border-red-300 text-red-800 p-3 rounded-lg mb-4 shadow">
        {{ session('error') }}
    </div>
@endif

<!-- 🔍 FILTER -->
<div class="bg-white/30 backdrop-blur-xl border border-white/30 p-6 rounded-2xl shadow-lg mb-6">
    <h3 class="text-lg font-semibold mb-4">Filter Products</h3>

    <form method="GET" action="{{ route('products.index') }}" 
          class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

        <div>
            <label class="text-sm text-gray-500">Search</label>
            <input type="text" name="search" 
                value="{{ request('search') }}"
                placeholder="Search by name..."
                class="w-full mt-1 px-4 py-2 bg-white/40 backdrop-blur border border-white/40 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
        </div>

        <div>
            <label class="text-sm text-gray-500">Category</label>
            <select name="category" 
                class="w-full mt-1 px-4 py-2 bg-white/40 backdrop-blur border border-white/40 rounded-lg focus:ring-2 focus:ring-green-400">
                <option value="">All</option>
                <option value="Fruits" {{ request('category') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                <option value="Vegetables" {{ request('category') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-500">Max Price</label>
            <input type="number" name="price" 
                value="{{ request('price') }}"
                class="w-full mt-1 px-4 py-2 bg-white/40 backdrop-blur border border-white/40 rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        <div class="flex gap-2">
            <button class="w-full bg-green-500/80 backdrop-blur text-white py-2 rounded-lg hover:bg-green-600/80 transition shadow-md">
                Search
            </button>

            <a href="{{ route('products.index') }}"
               class="w-full text-center bg-gray-400/80 text-white py-2 rounded-lg hover:bg-gray-500/80 backdrop-blur">
               Reset
            </a>
        </div>

    </form>
</div>

<!-- 📦 PRODUCTS -->
<h2 class="text-2xl font-semibold mb-4">All Products</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @forelse($products as $product)

    <div class="relative bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] transition duration-300 overflow-hidden flex flex-col h-full">

        <!-- ✨ Glow -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>

        <!-- 🖼 IMAGE -->
        <div class="h-48 bg-white/20 flex items-center justify-center overflow-hidden">
    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}"
             class="h-full w-full object-cover transition duration-300 hover:scale-105">
    @else
        <span class="text-gray-400">No Image</span>
    @endif
</div>

        <!-- 📄 CONTENT -->
        <div class="p-4 flex flex-col flex-grow">

            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>

            <p class="text-sm text-gray-600">{{ $product->category }}</p>

            <p class="text-green-700 font-bold mt-1">
                ₹{{ $product->price }}
            </p>

            <p class="text-sm text-gray-700">
                Qty: {{ $product->quantity }}
            </p>

            <!-- STATUS -->
            @if($product->bidding_end_time)
                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full
                    {{ now()->greaterThan($product->bidding_end_time) ? 'bg-red-300/40 text-red-800' : 'bg-green-300/40 text-green-800' }}">
                    {{ now()->greaterThan($product->bidding_end_time) ? 'Closed' : 'Open' }}
                </span>
            @endif

            <!-- TIMER -->
            @if($product->bidding_end_time)
                <p class="text-sm mt-1 text-blue-600">
                    ⏳ <span id="timer-{{ $product->id }}"></span>
                </p>
            @endif

            <!-- BID -->
            <p class="text-sm mt-2">
                Highest Bid:
                <span class="font-semibold">
                    {{ $product->bids->max('bid_amount') ?? 'No bids yet' }}
                </span>
            </p>

            <!-- WINNER -->
            @php
                $highestBid = $product->bids->sortByDesc('bid_amount')->first();
            @endphp

            @if($product->bidding_end_time && now()->greaterThan($product->bidding_end_time))
                <p class="mt-2 inline-block bg-green-400/30 backdrop-blur text-green-900 px-3 py-1 rounded-full text-xs font-semibold border border-green-300/40">
                    🏆 Winner: {{ $highestBid && $highestBid->user ? $highestBid->user->name : 'No bids' }}
                </p>
            @endif

            <!-- ACTIONS -->
            <div class="mt-auto pt-4 space-y-2">

                <!-- ACTIONS -->

<div class="mt-auto pt-4 space-y-2">

<!-- View Details -->
<a href="{{ route('products.show', $product->id) }}"
   class="block text-center bg-blue-500/80 backdrop-blur text-white py-2 rounded-lg hover:bg-blue-600/80 transition shadow-md">
    View Details
</a>

<!-- 🛒 BUY NOW (NEW) -->
@auth
    @if(auth()->user()->isConsumer())
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <button class="w-full bg-orange-500/80 backdrop-blur text-white py-2 rounded-lg hover:bg-orange-600/80 transition shadow-md">
                🛒 Buy Now
            </button>
        </form>
    @endif
@endauth

<!-- BIDDING -->
@if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
    <form method="POST" action="{{ route('bids.store') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="flex gap-2 mt-2">
            <input type="number" name="bid_amount"
                class="flex-1 bg-white/40 backdrop-blur border border-white/40 rounded-lg px-3 py-2"
                placeholder="Enter bid" required>

            <button class="bg-green-500/80 backdrop-blur text-white px-4 rounded-lg hover:bg-green-600/80">
                Bid
            </button>
        </div>
    </form>
@endif

</div>


            </div>

        </div>

    </div>

    @empty
        <p class="text-gray-600 col-span-3 text-center">
            No products found.
        </p>
    @endforelse

</div>

</div>

@endsection
