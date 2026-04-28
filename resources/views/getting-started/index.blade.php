@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">
                    🎉 Welcome to Digital Farmer Market!
                </h1>
                <p class="text-xl text-green-100 mb-6">
                    Let's get you started on your fresh produce journey
                </p>
                <div class="bg-white/10 backdrop-blur rounded-lg p-4 inline-block">
                    <p class="text-lg">
                        👋 Hi <strong>{{ auth()->user()->name }}</strong>!
                        You're logged in as a <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <!-- Getting Started Steps -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                🚀 Your Quick Start Guide
            </h2>

            @if(auth()->user()->isFarmer())
                <!-- Farmer Onboarding -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl border-l-4 border-green-500">
                        <div class="bg-green-100 p-3 rounded-full">
                            <span class="text-2xl">🌱</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 1: Add Your First Product</h3>
                            <p class="text-gray-600 mb-3">
                                Start selling by listing your fresh produce. Include details like quantity, price, and photos to attract buyers.
                            </p>
                            <div class="text-sm text-green-700 font-medium">
                                💡 Tip: High-quality photos and competitive prices get more bids!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <span class="text-2xl">📦</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 2: Manage Your Listings</h3>
                            <p class="text-gray-600 mb-3">
                                Track your products, monitor bids, and manage orders from your farmer dashboard.
                            </p>
                            <div class="text-sm text-blue-700 font-medium">
                                💡 Tip: Enable bidding for premium items to get the best prices!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-purple-50 rounded-xl border-l-4 border-purple-500">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <span class="text-2xl">🤝</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 3: Connect with Buyers</h3>
                            <p class="text-gray-600 mb-3">
                                Build relationships with local consumers and expand your customer base.
                            </p>
                            <div class="text-sm text-purple-700 font-medium">
                                💡 Tip: Respond quickly to inquiries and provide excellent service!
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(auth()->user()->isConsumer())
                <!-- Consumer Onboarding -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl border-l-4 border-green-500">
                        <div class="bg-green-100 p-3 rounded-full">
                            <span class="text-2xl">🛒</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 1: Explore Fresh Products</h3>
                            <p class="text-gray-600 mb-3">
                                Browse through fresh, locally-sourced produce from farmers in your area.
                            </p>
                            <div class="text-sm text-green-700 font-medium">
                                💡 Tip: Use filters to find specific fruits, vegetables, or price ranges!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <span class="text-2xl">💰</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 2: Place Bids or Buy Now</h3>
                            <p class="text-gray-600 mb-3">
                                Place competitive bids on premium items or buy immediately at the listed price.
                            </p>
                            <div class="text-sm text-blue-700 font-medium">
                                💡 Tip: Set bid alerts and check back often for the best deals!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-purple-50 rounded-xl border-l-4 border-purple-500">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <span class="text-2xl">⭐</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 3: Track Your Orders</h3>
                            <p class="text-gray-600 mb-3">
                                Monitor your bids, purchases, and order status from your consumer dashboard.
                            </p>
                            <div class="text-sm text-purple-700 font-medium">
                                💡 Tip: Save favorite products and farmers for quick access!
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(auth()->user()->isAdmin())
                <!-- Admin Onboarding -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl border-l-4 border-green-500">
                        <div class="bg-green-100 p-3 rounded-full">
                            <span class="text-2xl">📊</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 1: Monitor the Platform</h3>
                            <p class="text-gray-600 mb-3">
                                View platform statistics, user activity, and marketplace performance.
                            </p>
                            <div class="text-sm text-green-700 font-medium">
                                💡 Tip: Regular monitoring helps maintain platform quality!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <span class="text-2xl">✅</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 2: Manage Product Listings</h3>
                            <p class="text-gray-600 mb-3">
                                Review and approve farmer product submissions to ensure quality standards.
                            </p>
                            <div class="text-sm text-blue-700 font-medium">
                                💡 Tip: Quick approval times keep farmers engaged!
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-purple-50 rounded-xl border-l-4 border-purple-500">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <span class="text-2xl">🛡️</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Step 3: Ensure Platform Security</h3>
                            <p class="text-gray-600 mb-3">
                                Monitor user activity, resolve disputes, and maintain platform integrity.
                            </p>
                            <div class="text-sm text-purple-700 font-medium">
                                💡 Tip: Fair dispute resolution builds user trust!
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Platform Benefits -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                🌟 Why Choose Our Platform?
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                    <div class="text-4xl mb-4">🌱</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Fresh & Local</h3>
                    <p class="text-sm text-gray-600">Direct from farm to table</p>
                </div>

                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Fair Pricing</h3>
                    <p class="text-sm text-gray-600">Competitive bidding system</p>
                </div>

                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Community</h3>
                    <p class="text-sm text-gray-600">Support local farmers</p>
                </div>
            </div>
        </div>

        <!-- Complete Setup Button -->
        <div class="text-center">
            <form method="POST" action="{{ route('getting-started.complete') }}">
                @csrf
                <button type="submit"
                        class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-12 py-4 rounded-full font-bold text-xl hover:from-green-700 hover:to-emerald-700 transition transform hover:scale-105 shadow-2xl">
                    🚀 I'm Ready to Start!
                </button>
            </form>

            <p class="text-gray-600 mt-4">
                This will take you to your personalized dashboard
            </p>
        </div>
    </div>
</div>
@endsection