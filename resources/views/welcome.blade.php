<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('ui.site_title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-3xl">🌾</span>
                <span class="text-2xl font-bold text-green-700">{{ __('ui.site_name') }}</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-gray-700 hover:text-green-700 transition font-medium">{{ __('ui.home') }}</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-green-700 transition font-medium">{{ __('ui.marketplace') }}</a>
                <a href="#features" class="text-gray-700 hover:text-green-700 transition font-medium">{{ __('ui.why_us') }}</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-700 transition font-medium">{{ __('ui.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-700 transition font-medium">{{ __('ui.sign_in') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section with Background Image -->
    <div class="relative pt-20 pb-32 bg-gradient-to-b from-green-50 to-white overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
        
        <div class="relative max-w-7xl mx-auto px-6 pt-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-4">
                            {{ __('ui.hero_title') }} <span class="text-green-700">{{ __('ui.hero_title_emphasis') }}</span>
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            {{ __('ui.hero_subtitle') }}
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            @if(auth()->user()->isFarmer())
                                <a href="{{ route('products.create') }}"
                                   class="px-8 py-4 bg-green-700 text-white font-bold text-lg rounded-lg hover:bg-green-800 transition shadow-lg">
                                    {{ __('ui.start_selling') }}
                                </a>
                            @else
                                <a href="{{ route('consumer.dashboard') }}"
                                   class="px-8 py-4 bg-green-700 text-white font-bold text-lg rounded-lg hover:bg-green-800 transition shadow-lg">
                                    {{ __('ui.shop_now') }}
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}"
                               class="px-8 py-4 bg-gray-200 text-gray-800 font-bold text-lg rounded-lg hover:bg-gray-300 transition">
                                {{ __('ui.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="px-8 py-4 bg-green-700 text-white font-bold text-lg rounded-lg hover:bg-green-800 transition shadow-lg">
                                {{ __('ui.get_started_free') }}
                            </a>
                            <a href="{{ route('login') }}"
                               class="px-8 py-4 bg-gray-200 text-gray-800 font-bold text-lg rounded-lg hover:bg-gray-300 transition">
                                {{ __('ui.sign_in') }}
                            </a>
                        @endauth
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex gap-6 pt-4">
                        <div>
                            <div class="text-2xl font-bold text-green-700">{{ \App\Models\Product::count() }}+</div>
                            <div class="text-sm text-gray-600">{{ __('ui.fresh_products') }}</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-700">{{ \App\Models\User::where('role', 'farmer')->count() }}</div>
                            <div class="text-sm text-gray-600">{{ __('ui.local_farmers') }}</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-700">{{ \App\Models\User::where('role', 'consumer')->count() }}+</div>
                            <div class="text-sm text-gray-600">{{ __('ui.happy_customers') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Right Image Placeholder -->
                <div class="relative h-96 bg-gradient-to-br from-green-200 to-green-100 rounded-2xl overflow-hidden shadow-xl">
                    <div class="absolute inset-0 flex items-center justify-center text-6xl">
                        🥬
                    </div>
                    <div class="absolute top-4 right-4 bg-white/90 px-4 py-2 rounded-lg text-sm font-semibold text-gray-800 shadow-lg">
                        {{ __('ui.fresh_daily') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('ui.why_choose_us') }}</h2>
                <p class="text-xl text-gray-600">{{ __('ui.why_choose_us_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 bg-gray-50 rounded-xl border-2 border-green-100 hover:border-green-300 transition">
                    <div class="text-5xl mb-4">🌱</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('ui.feature_fresh_local_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('ui.feature_fresh_local_text') }}
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 bg-gray-50 rounded-xl border-2 border-green-100 hover:border-green-300 transition">
                    <div class="text-5xl mb-4">💰</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('ui.feature_fair_bidding_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('ui.feature_fair_bidding_text') }}
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 bg-gray-50 rounded-xl border-2 border-green-100 hover:border-green-300 transition">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('ui.feature_community_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('ui.feature_community_text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="bg-gradient-to-r from-green-700 to-green-600 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-white mb-2">{{ \App\Models\Product::count() }}</div>
                    <div class="text-green-100 font-medium">{{ __('ui.active_listings') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-white mb-2">{{ \App\Models\User::where('role', 'farmer')->count() }}</div>
                    <div class="text-green-100 font-medium">{{ __('ui.verified_farmers') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-white mb-2">{{ \App\Models\User::where('role', 'consumer')->count() }}</div>
                    <div class="text-green-100 font-medium">{{ __('ui.active_buyers') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-white mb-2">{{ \App\Models\Bid::count() }}</div>
                    <div class="text-green-100 font-medium">{{ __('ui.successful_bids') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-900 text-center mb-16">{{ __('ui.how_it_works') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-700 text-white rounded-full text-2xl font-bold mb-4">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('ui.how_it_works_step1_title') }}</h3>
                    <p class="text-gray-600">{{ __('ui.how_it_works_step1_text') }}</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-700 text-white rounded-full text-2xl font-bold mb-4">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('ui.how_it_works_step2_title') }}</h3>
                    <p class="text-gray-600">{{ __('ui.how_it_works_step2_text') }}</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-700 text-white rounded-full text-2xl font-bold mb-4">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('ui.how_it_works_step3_title') }}</h3>
                    <p class="text-gray-600">{{ __('ui.how_it_works_step3_text') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="bg-green-800 py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                {{ __('ui.join_fresh_revolution') }}
            </h2>
            <p class="text-xl text-green-100 mb-10">
                {{ __('ui.join_revolution_text') }}
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-block px-10 py-4 bg-white text-green-800 font-bold text-lg rounded-lg hover:bg-gray-100 transition shadow-lg">
                    {{ __('ui.go_to_dashboard') }}
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-block px-10 py-4 bg-white text-green-800 font-bold text-lg rounded-lg hover:bg-gray-100 transition shadow-lg">
                    {{ __('ui.get_started_free') }}
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>&copy; 2026 Digital Farmer Market. Connecting farmers and consumers. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
        <div class="absolute top-32 right-16 animate-pulse">
            <div class="bg-white/20 backdrop-blur rounded-full p-4">
                <span class="text-3xl">🍎</span>
            </div>
        </div>
        <div class="absolute bottom-20 left-20 animate-bounce" style="animation-delay: 1s;">
            <div class="bg-white/20 backdrop-blur rounded-full p-4">
                <span class="text-3xl">🌽</span>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    {{ __('Why Choose Our Farmer Market?') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('We\'re revolutionizing the way you buy and sell fresh produce') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">🌱</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Fresh ;& Local') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Get the freshest produce directly from local farmers in your area.') }}
                        {{ __('No middlemen, just pure farm-to-table goodness.') }}
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">💰</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Fair Pricing') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Competitive bidding system ensures fair prices for both farmers and consumers.') }}
                        {{ __('Support local agriculture while saving money.') }}
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Community Driven') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Build connections with local farmers and fellow food enthusiasts.') }}
                        {{ __('Be part of a sustainable food ecosystem.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-gradient-to-r from-green-600 to-emerald-600">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="text-white">
                    <div class="text-3xl md:text-4xl font-bold mb-2">
                        {{ \App\Models\Product::count() }}
                    </div>
                    <div class="text-green-100">{{ __('Products Listed') }}</div>
                </div>
                <div class="text-white">
                    <div class="text-3xl md:text-4xl font-bold mb-2">
                        {{ \App\Models\User::where('role', 'farmer')->count() }}
                    </div>
                    <div class="text-green-100">{{ __('Active Farmers') }}</div>
                </div>
                <div class="text-white">
                    <div class="text-3xl md:text-4xl font-bold mb-2">
                        {{ \App\Models\User::where('role', 'consumer')->count() }}
                    </div>
                    <div class="text-green-100">{{ __('Happy Consumers') }}</div>
                </div>
                <div class="text-white">
                    <div class="text-3xl md:text-4xl font-bold mb-2">
                        {{ \App\Models\Bid::count() }}
                    </div>
                    <div class="text-green-100">{{ __('Bids Placed') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                {{ __('Ready to Start Your Fresh Journey?') }}
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                {{ __('Join thousands of farmers and consumers already using our platform') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('products.index') }}"
                       class="bg-green-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-green-700 transition transform hover:scale-105 shadow-lg">
                        {{ __('Explore Marketplace') }}
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="bg-green-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-green-700 transition transform hover:scale-105 shadow-lg">
                        {{ __('Get Started Free') }}
                    </a>
                    <a href="{{ route('login') }}"
                       class="bg-white text-green-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-green-50 transition transform hover:scale-105 shadow-lg border-2 border-green-600">
                        {{ __('Sign In') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>

</body>
</html>
