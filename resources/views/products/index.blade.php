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

    <div class="relative bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] transition duration-300 overflow-hidden flex flex-col h-full group">

        <!-- ✨ Glow -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>

        <!-- Status Badge -->
        @if($product->bidding_end_time)
            <div class="absolute top-4 right-4 z-10">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full shadow-lg
                    {{ now()->greaterThan($product->bidding_end_time) ? 'bg-red-500/90 text-white' : 'bg-green-500/90 text-white' }}">
                    {{ now()->greaterThan($product->bidding_end_time) ? '🏁 Closed' : '🔥 Open' }}
                </span>
            </div>
        @endif

        <!-- 🖼 IMAGE -->
        <div class="h-48 bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center overflow-hidden relative">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
            @else
                <div class="text-center">
                    <span class="text-6xl mb-2 block">🥕</span>
                    <span class="text-gray-400 text-sm">No Image</span>
                </div>
            @endif
        </div>

        <!-- 📄 CONTENT -->
        <div class="p-6 flex flex-col flex-grow">

            <!-- Product Info -->
            <div class="mb-4">
                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $product->category }}</p>

                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-green-600">
                        ₹{{ $product->price }}
                    </div>
                    <div class="text-sm text-gray-500">
                        Qty: {{ $product->quantity }}
                    </div>
                </div>
            </div>

            <!-- Bidding Info -->
            @if($product->is_bidding)
                <div class="bg-blue-50/50 backdrop-blur rounded-lg p-4 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-800">Highest Bid:</span>
                        <span class="font-bold text-blue-600">
                            ₹{{ $product->bids->max('bid_amount') ?? $product->price }}
                        </span>
                    </div>

                    @if($product->bidding_end_time)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-blue-700">⏳ Time Left:</span>
                            <span id="timer-{{ $product->id }}" class="font-mono text-blue-600"></span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Winner Announcement -->
            @php
                $highestBid = $product->bids->sortByDesc('bid_amount')->first();
            @endphp

            @if($product->bidding_end_time && now()->greaterThan($product->bidding_end_time))
                <div class="bg-gradient-to-r from-green-100 to-emerald-100 border border-green-200 rounded-lg p-3 mb-4">
                    <div class="flex items-center text-green-800">
                        <span class="text-lg mr-2">🏆</span>
                        <div>
                            <div class="font-semibold text-sm">Auction Ended</div>
                            <div class="text-xs">
                                Winner: {{ $highestBid && $highestBid->user ? $highestBid->user->name : 'No bids' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ACTIONS -->
            <div class="mt-auto space-y-3">

                <!-- View Details -->
                <a href="{{ route('products.show', $product->id) }}"
                   class="block text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-lg font-medium">
                    👁️ View Details
                </a>

                <!-- Buy Now (for consumers) -->
                @auth
                    @if(auth()->user()->isConsumer())
                        <form method="POST" action="{{ route('orders.store') }}" class="mb-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition shadow-lg font-medium">
                                🛒 Buy Now - ₹{{ $product->price }}
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Bidding Form -->
                @if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
                    @auth
                        @if(auth()->user()->isConsumer())
                            <form method="POST" action="{{ route('bids.store') }}" class="space-y-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input type="number"
                                               name="bid_amount"
                                               class="w-full bg-white/60 backdrop-blur border border-white/40 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-400 focus:border-transparent outline-none"
                                               placeholder="Enter bid amount"
                                               min="{{ ($product->bids->max('bid_amount') ?? $product->price) + 1 }}"
                                               required>
                                    </div>
                                    <button class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-lg font-medium whitespace-nowrap">
                                        💰 Bid
                                    </button>
                                </div>

                                <div class="text-xs text-gray-600 text-center">
                                    Minimum bid: ₹{{ ($product->bids->max('bid_amount') ?? $product->price) + 1 }}
                                </div>
                            </form>
                        @endif
                    @else
                        <div class="text-center py-2">
                            <a href="{{ route('login') }}"
                               class="text-green-600 hover:text-green-700 text-sm font-medium">
                                Sign in to bid →
                            </a>
                        </div>
                    @endauth
                @endif

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
