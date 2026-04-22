@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10 px-6">

<div class="grid md:grid-cols-2 gap-8">

    <!-- 🖼 IMAGE SECTION -->
    <div class="bg-white/30 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl p-6">

        <div class="h-80 flex items-center justify-center overflow-hidden rounded-xl">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="h-full w-full object-contain transition duration-300 hover:scale-105">
            @else
                <span class="text-gray-400">No Image</span>
            @endif
        </div>

    </div>

    <!-- 📄 DETAILS SECTION -->
    <div class="bg-white/30 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col">

        <!-- Title -->
        <h2 class="text-3xl font-bold mb-2">
            {{ $product->name }}
        </h2>

        <!-- Category -->
        <p class="text-gray-600 mb-2">
            {{ $product->category }}
        </p>

        <!-- Price -->
        <p class="text-2xl font-bold text-green-700 mb-3">
            ₹{{ $product->price }}
        </p>

        <!-- Quantity -->
        <p class="text-sm text-gray-700">
            Quantity: {{ $product->quantity }}
        </p>

        <!-- Status Badge -->
        <span class="mt-3 inline-block px-3 py-1 text-xs rounded-full w-fit
            {{ $product->status == 'pending' ? 'bg-yellow-300/40 text-yellow-800' : '' }}
            {{ $product->status == 'approved' ? 'bg-green-300/40 text-green-800' : '' }}
            {{ $product->status == 'rejected' ? 'bg-red-300/40 text-red-800' : '' }}">
            {{ ucfirst($product->status) }}
        </span>

        <!-- Highest Bid -->
        <div class="mt-4">
            <p class="text-sm">
                Highest Bid:
                <span class="font-semibold">
                    {{ $product->bids->max('bid_amount') ?? 'No bids yet' }}
                </span>
            </p>
        </div>

        <!-- 🔥 ACTIONS -->
        <div class="mt-6 space-y-3">

            <!-- BID -->
            @if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
            <form method="POST" action="{{ route('bids.store') }}" class="flex gap-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <input type="number" name="bid_amount"
                    class="flex-1 px-4 py-2 bg-white/40 backdrop-blur border border-white/40 rounded-lg"
                    placeholder="Enter your bid" required>

                <button class="bg-green-500/80 backdrop-blur text-white px-5 rounded-lg hover:bg-green-600/80">
                    Bid
                </button>
            </form>
            @endif

            <!-- 🛒 BUY NOW (NEW FEATURE UI) -->
            @if(!$product->is_bidding)
            <button class="w-full bg-blue-500/80 backdrop-blur text-white py-2 rounded-lg hover:bg-blue-600/80 shadow-md">
                Buy Now
            </button>
            @endif

        </div>

    </div>

</div>

<!-- 📊 BIDDING HISTORY -->
<div class="mt-10 bg-white/30 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl p-6">

    <h3 class="text-xl font-semibold mb-4">Bidding History</h3>

    <div class="space-y-2 max-h-64 overflow-y-auto">

        @forelse($product->bids->sortByDesc('bid_amount') as $bid)
            <div class="flex justify-between items-center bg-white/40 backdrop-blur px-4 py-2 rounded-lg">
                <span class="font-medium">{{ $bid->user->name }}</span>
                <span class="text-green-700 font-semibold">₹{{ $bid->bid_amount }}</span>
            </div>
        @empty
            <p class="text-gray-600">No bids yet</p>
        @endforelse

    </div>

</div>

</div>

@endsection
