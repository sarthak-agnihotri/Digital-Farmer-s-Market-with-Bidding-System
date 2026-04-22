<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Market</title>

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-100 via-emerald-200 to-lime-100 min-h-screen">

    <!-- 🌾 NAVBAR -->
    <nav class="bg-white/30 backdrop-blur-xl border border-white/20 shadow-lg sticky top-4 mx-4 rounded-2xl z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <!-- Logo -->
            <h1 class="text-2xl font-bold text-green-600 tracking-wide">
                🌾 Farmer Market
            </h1>

            <!-- Menu -->
            <div class="flex items-center gap-3 flex-wrap">

                <!-- Public -->
                <a href="{{ route('products.index') }}"
                   class="text-gray-600 hover:text-green-600 font-medium transition">
                   Products
                </a>

                @auth

                    {{-- 👤 USER NAME --}}
                    <span class="text-gray-500 hidden md:block">
                        Hi, {{ auth()->user()->name }}
                    </span>

                    {{-- Consumer --}}
                    @if(auth()->user()->isConsumer())
                        <a href="{{ route('consumer.dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition transform hover:scale-105">
                           Dashboard
                        </a>

                        <a href="{{ route('consumer.bids') }}"
                           class="px-4 py-2 rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition transform hover:scale-105">
                           My Bids
                        </a>
                    @endif

                    {{-- Farmer --}}
                    @if(auth()->user()->isFarmer())
                        <a href="{{ route('products.create') }}"
                           class="px-4 py-2 rounded-lg bg-green-500 text-white shadow hover:bg-green-600 transition transform hover:scale-105">
                           + Add Product
                        </a>
                    @endif

                    {{-- Admin --}}
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-blue-500 text-white shadow hover:bg-blue-600 transition transform hover:scale-105">
                           Admin Panel
                        </a>
                    @endif

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition transform hover:scale-105">
                            Logout
                        </button>
                    </form>

                @endauth

            </div>
        </div>
    </nav>

    <!-- 🌟 MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>