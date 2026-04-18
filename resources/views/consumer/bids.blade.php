@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-8">

    <h2 class="text-xl font-bold mb-4">My Bids</h2>

    @forelse($bids as $bid)

    <div class="bg-white shadow p-4 mb-3 rounded">

        <p><strong>Product:</strong> {{ $bid->product->name }}</p>
        <p><strong>Your Bid:</strong> ₹{{ $bid->bid_amount }}</p>
        <p><strong>Date:</strong> {{ $bid->created_at->format('d M Y H:i') }}</p>

    </div>

    @empty
        <p>No bids placed yet.</p>
    @endforelse

</div>

@endsection