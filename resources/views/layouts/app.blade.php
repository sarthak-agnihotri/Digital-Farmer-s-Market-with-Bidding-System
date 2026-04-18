<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Market</title>

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-lg font-bold">Farmer Market</h1>

        <div class="flex items-center gap-3 flex-wrap">

    <!-- Public -->
    <a href="{{ route('products.index') }}" class="bg-gray-700 px-3 py-1 rounded">Products</a>

    @auth

        {{-- Consumer --}}
        @if(auth()->user()->isConsumer())
            <a href="{{ route('consumer.dashboard') }}" class="bg-green-500 px-3 py-1 rounded">Dashboard</a>
            <a href="{{ route('consumer.bids') }}" class="bg-purple-500 px-3 py-1 rounded">My Bids</a>
        @endif

        {{-- Farmer --}}
        @if(auth()->user()->isFarmer())
            <a href="{{ route('products.create') }}" class="bg-yellow-500 px-3 py-1 rounded">Add Product</a>
        @endif

        {{-- Admin --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.products') }}" class="bg-blue-500 px-3 py-1 rounded">Admin Panel</a>
        @endif

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 px-3 py-1 rounded">Logout</button>
        </form>

    @endauth

</div>
    </div>
</nav>

    <!-- 🔥 THIS IS IMPORTANT -->
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>