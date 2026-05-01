@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10 px-6">

<div class="grid md:grid-cols-2 gap-8">

    <!-- 🖼 IMAGE SECTION -->
    <div class="bg-white/30 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl p-6">

        <div class="h-80 flex items-center justify-center overflow-hidden rounded-xl relative">
            @auth
                @if(auth()->user()->isConsumer())
                    <button onclick="toggleWishlist({{ $product->id }}, this)" class="absolute top-4 right-4 z-20 p-3 rounded-full backdrop-blur-md bg-white/60 shadow hover:bg-white/90 transition group/wishlist">
                        <svg class="w-8 h-8 transition-colors duration-300 {{ $isWishlisted ? 'text-pink-500 fill-pink-500' : 'text-gray-400 fill-transparent group-hover/wishlist:text-pink-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                        </svg>
                    </button>
                @endif
            @endauth

            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="h-full w-full object-contain transition duration-300 hover:scale-105">
            @else
                <span class="text-gray-400">{{ __('No Image') }}</span>
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
            {{ __('Quantity:') }} {{ $product->quantity }}
        </p>

        <!-- Status Badge -->
        <span class="mt-3 inline-block px-3 py-1 text-xs rounded-full w-fit
            {{ $product->status == 'pending' ? 'bg-yellow-300/40 text-yellow-800' : '' }}
            {{ $product->status == 'approved' ? 'bg-green-300/40 text-green-800' : '' }}
            {{ $product->status == 'rejected' ? 'bg-red-300/40 text-red-800' : '' }}">
            {{ ucfirst(__($product->status)) }}
        </span>

        <!-- Highest Bid -->
        <div class="mt-4">
            <p class="text-sm">
                {{ __('Highest Bid:') }}
                <span class="font-semibold">
                    {{ $product->bids->max('bid_amount') ?? __('No bids yet') }}
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
                    placeholder="{{ __('Enter your bid') }}" required>

                <button class="bg-green-500/80 backdrop-blur text-white px-5 rounded-lg hover:bg-green-600/80">
                    {{ __('Bid') }}
                </button>
            </form>
            @endif

            <!-- 🛒 BUY NOW (NEW FEATURE UI) -->
            @if(!$product->is_bidding)
            <button class="w-full bg-blue-500/80 backdrop-blur text-white py-2 rounded-lg hover:bg-blue-600/80 shadow-md">
                {{ __('Buy Now') }}
            </button>
            @endif

        </div>

    </div>

</div>

<!-- 📊 BIDDING HISTORY -->
<div class="mt-10 bg-white/30 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl p-6">

    <h3 class="text-xl font-semibold mb-4">{{ __('Bidding History') }}</h3>

    <div class="space-y-2 max-h-64 overflow-y-auto">

        @forelse($product->bids->sortByDesc('bid_amount') as $bid)
            <div class="flex justify-between items-center bg-white/40 backdrop-blur px-4 py-2 rounded-lg">
                <span class="font-medium">{{ $bid->user->name }}</span>
                <span class="text-green-700 font-semibold">₹{{ $bid->bid_amount }}</span>
            </div>
        @empty
            <p class="text-gray-600">{{ __('No bids yet') }}</p>
        @endforelse

    </div>

</div>

</div>

@endsection

@section('scripts')
<script>
    function toggleWishlist(productId, btn) {
        event.preventDefault();
        event.stopPropagation();
        
        fetch(`/wishlist/${productId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const svg = btn.querySelector('svg');
            if (data.status === 'added') {
                svg.classList.remove('text-gray-400', 'fill-transparent');
                svg.classList.add('text-pink-500', 'fill-pink-500');
            } else {
                svg.classList.add('text-gray-400', 'fill-transparent');
                svg.classList.remove('text-pink-500', 'fill-pink-500');
            }
        });
    }
</script>
@endsection
