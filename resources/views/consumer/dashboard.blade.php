@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">
                        {{ __('Welcome back,') }} {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-green-100 text-lg">
                        {{ __('Discover fresh produce and place bids on premium items') }}
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur rounded-full p-6">
                        <span class="text-4xl">🛒</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">
                    {{ \App\Models\Product::count() }}
                </div>
                <div class="text-gray-600">{{ __('Products Available') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">
                    {{ \App\Models\Bid::where('user_id', auth()->id())->count() }}
                </div>
                <div class="text-gray-600">{{ __('Your Bids') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">
                    @php
                        $wonBidsCount = \App\Models\Bid::where('user_id', auth()->id())
                            ->whereHas('product', function($query) {
                                $query->whereNotNull('bidding_end_time')
                                      ->where('bidding_end_time', '<', now());
                            })
                            ->whereRaw('bid_amount = (SELECT MAX(bid_amount) FROM bids b2 WHERE b2.product_id = bids.product_id)')
                            ->count();
                    @endphp
                    {{ $wonBidsCount }}
                </div>
                <div class="text-gray-600">{{ __('Bids Won') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">
                    ₹{{ \App\Models\Bid::where('user_id', auth()->id())->sum('bid_amount') }}
                </div>
                <div class="text-gray-600">{{ __('Total Spent') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Actions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Quick Actions') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('products.index') }}"
                           class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition transform hover:scale-105">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <span class="text-2xl">🛒</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ __('Browse Products') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Explore fresh produce') }}</p>
                            </div>
                        </a>

                        <a href="{{ route('consumer.bids') }}"
                           class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition transform hover:scale-105">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <span class="text-2xl">💰</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ __('My Bids') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Track your offers') }}</p>
                            </div>
                        </a>

                        <a href="#"
                           class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition transform hover:scale-105">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <span class="text-2xl">⭐</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ __('Favorites') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Saved products') }}</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                            <div class="bg-gray-100 p-3 rounded-full mr-4">
                                <span class="text-2xl">👤</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ __('My Profile') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Update information') }}</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Bids -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ __('Recent Bids') }}</h2>
                        <a href="{{ route('consumer.bids') }}"
                           class="text-green-600 hover:text-green-700 text-sm font-medium">
                            {{ __('View All →') }}
                        </a>
                    </div>

                    @php
                        $recentBids = \App\Models\Bid::where('user_id', auth()->id())
                            ->with('product')
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp

                    @forelse($recentBids as $bid)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg mb-3">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-2 rounded-full mr-3">
                                    <span class="text-lg">🥕</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $bid->product->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ __('Bid:') }} ₹{{ $bid->bid_amount }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">{{ $bid->created_at->diffForHumans() }}</span>
                                @php
                                    $isWinning = $bid->product->bidding_end_time &&
                                                now()->greaterThan($bid->product->bidding_end_time) &&
                                                $bid->bid_amount == $bid->product->bids->max('bid_amount');
                                    $statusText = $isWinning ? __('Won') : ($bid->product->bidding_end_time && now()->greaterThan($bid->product->bidding_end_time) ? __('Lost') : __('Active'));
                                @endphp
                                <div class="text-xs px-2 py-1 rounded-full {{ $isWinning ? 'bg-green-100 text-green-800' : ($bid->product->bidding_end_time && now()->greaterThan($bid->product->bidding_end_time) ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $statusText }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">💰</div>
                            <p class="text-gray-600">{{ __('No bids placed yet') }}</p>
                            <a href="{{ route('products.index') }}"
                               class="text-green-600 hover:text-green-700 font-medium">
                                {{ __('Start browsing products →') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Marketplace Highlights -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Marketplace Highlights') }}</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">{{ __('Fresh Arrivals Today') }}</span>
                            <span class="font-semibold text-green-600">
                                {{ \App\Models\Product::whereDate('created_at', today())->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">{{ __('Active Bids') }}</span>
                            <span class="font-semibold text-blue-600">
                                {{ \App\Models\Bid::whereDate('created_at', today())->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">{{ __('Farmers Online') }}</span>
                            <span class="font-semibold text-purple-600">
                                {{ \App\Models\User::where('role', 'farmer')->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tips & Tricks -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('💡 Pro Tips') }}</h2>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-600 mr-2">•</span>
                            {{ __('Place bids early for better chances') }}
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-2">•</span>
                            {{ __('Check product freshness dates') }}
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-2">•</span>
                            {{ __('Contact farmers for bulk orders') }}
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-600 mr-2">•</span>
                            {{ __('Save favorite products for later') }}
                        </li>
                    </ul>
                </div>

                <!-- Quick Search -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Quick Search') }}</h2>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-3">
                        <input type="text" name="search" placeholder="{{ __('Search products...') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit"
                                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                            {{ __('Search') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection