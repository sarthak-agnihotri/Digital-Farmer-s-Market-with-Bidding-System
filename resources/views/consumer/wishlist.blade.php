@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center">
            <span class="text-4xl mr-3">❤️</span> {{ __('My Wishlist') }}
        </h2>
        <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-medium">
            {{ __('← Continue Shopping') }}

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-200/40 backdrop-blur border border-green-300 text-green-800 p-3 rounded-lg mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($wishlists as $wishlist)
            @php $product = $wishlist->product; @endphp
            @if($product)
            <div class="relative bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] transition duration-300 overflow-hidden flex flex-col h-full group" id="wishlist-item-{{ $product->id }}">
                
                <!-- Remove from wishlist btn -->
                <button onclick="toggleWishlist({{ $product->id }}, this)" class="absolute top-4 right-4 z-20 p-2 rounded-full backdrop-blur-md bg-white/60 shadow-sm hover:bg-red-50 hover:text-red-500 transition group/remove">
                    <svg class="w-6 h-6 text-pink-500 fill-pink-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                    </svg>
                </button>

                <!-- 🖼 IMAGE -->
                <div class="h-48 bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center overflow-hidden relative" onclick="window.location.href='{{ route('products.show', $product->id) }}'" style="cursor: pointer;">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                    @else
                        <div class="text-center">
                            <span class="text-6xl mb-2 block">🥕</span>
                            <span class="text-gray-400 text-sm">{{ __('No Image') }}</span>
                        </div>
                    @endif
                </div>

                <!-- 📄 CONTENT -->
                <div class="p-6 flex flex-col flex-grow">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">
                            <a href="{{ route('products.show', $product->id) }}" class="hover:text-green-600 transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->category }}</p>

                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-green-600">
                                ₹{{ $product->price }}
                            </div>
                            <div class="text-sm px-2 py-1 bg-gray-100 rounded text-gray-600">
                                {{ ucfirst($product->status) }}
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="mt-auto space-y-3">
                        <a href="{{ route('products.show', $product->id) }}"
                           class="block w-full text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-lg font-medium">
                            👁️ {{ __('View Details') }}
                        </a>
                    </div>
                </div>

            </div>
            @endif
        @empty
            <div class="col-span-3 text-center py-20 bg-white/20 backdrop-blur-xl border border-white/30 rounded-3xl shadow-xl">
                <span class="text-6xl block mb-6">💔</span>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Your wishlist is empty') }}</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">{{ __('Explore the market to find fresh agricultural products, and save them here for later!') }}</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold px-8 py-3 rounded-full hover:shadow-lg hover:scale-105 transition transform">
                    {{ __('Browse Products') }}
                </a>
            </div>
        @endforelse

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
            if (data.status === 'removed') {
                const itemCard = document.getElementById('wishlist-item-' + productId);
                if (itemCard) {
                    itemCard.style.opacity = '0';
                    itemCard.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        itemCard.remove();
                        // check if empty
                        const grid = document.querySelector('.grid');
                        if (grid && grid.children.length === 0) {
                            window.location.reload(); // reload to show empty state
                        }
                    }, 300);
                }
            }
        });
    }
</script>
@endsection
