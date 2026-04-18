@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-8 bg-white shadow-lg rounded-lg p-6">

    <!-- Product Title -->
    <h2 class="text-2xl font-bold mb-4">
        {{ $product->name }}
    </h2>

    <!-- Image -->
    <div class="w-full h-64 bg-gray-100 flex items-center justify-center mb-4">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                 class="h-full object-contain">
        @else
            <span>No Image</span>
        @endif
    </div>

    <!-- Details -->
    <div class="space-y-2">
        <p><strong>Category:</strong> {{ $product->category }}</p>
        <p><strong>Price:</strong> ₹{{ $product->price }}</p>
        <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
        <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
    </div>

    <!-- Highest Bid -->
    <div class="mt-4">
        <p><strong>Highest Bid:</strong> 
            {{ $product->bids->max('bid_amount') ?? 'No bids yet' }}
        </p>
    </div>

    <!-- Bid Form -->
    @if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
    <div class="mt-4">
        <form method="POST" action="{{ route('bids.store') }}" class="flex gap-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="number" name="bid_amount"
                class="border px-3 py-2 rounded w-full"
                placeholder="Enter your bid" required>

            <button class="bg-green-600 text-white px-4 rounded hover:bg-green-700">
                Bid
            </button>
        </form>
    </div>
    @endif

    <!-- Bidding History -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Bidding History</h3>

        @forelse($product->bids->sortByDesc('bid_amount') as $bid)
            <div class="border p-2 mb-2 rounded flex justify-between">
                <span>{{ $bid->user->name }}</span>
                <span>₹{{ $bid->bid_amount }}</span>
            </div>
        @empty
            <p class="text-gray-500">No bids yet</p>
        @endforelse
    </div>

</div>

@endsection