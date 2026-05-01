<nav x-data="{ open: false }" class="bg-white shadow-sm border-b">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">

            <!-- 🌾 Logo -->
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌾</span>
                <span class="text-xl font-bold text-green-600">{{ __('Farmer Market') }}</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex items-center gap-4">

                <!-- Products -->
                <a href="{{ route('products.index') }}"
                   class="text-gray-600 hover:text-green-600 font-medium transition">
                    {{ __('Products') }}
                </a>

                @auth

                    <!-- User Name -->
                    <span class="text-gray-500 text-sm">
                        Hi, {{ Auth::user()->name }}
                    </span>

                    <!-- Farmer -->
                    @if(Auth::user()->isFarmer())
                        <a href="{{ route('products.create') }}"
                           class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition transform hover:scale-105">
                           {{ __('+ Add Product') }}
                        </a>
                    @endif

                    <!-- Consumer -->
                    @if(Auth::user()->isConsumer())
                        <a href="{{ route('consumer.dashboard') }}"
                           class="bg-green-100 text-green-600 px-4 py-2 rounded-lg hover:bg-green-200 transition">
                           {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('consumer.bids') }}"
                           class="bg-purple-100 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-200 transition">
                           {{ __('My Bids') }}
                        </a>
                    @endif

                    <!-- Admin -->
                    @if(Auth::user()->isAdmin())

    <a href="{{ route('admin.dashboard') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
       {{ __('📊 Dashboard') }}
    </a>

    <a href="{{ route('admin.products') }}"
       class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition">
       {{ __('📦 Products') }}
    </a>

@endif

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            {{ __('Logout') }}
                        </button>
                    </form>

                @endauth

            </div>

            <!-- Mobile Button -->
            <div class="sm:hidden">
                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- 📱 Mobile Menu -->
    <div x-show="open" class="sm:hidden px-6 pb-4 space-y-2">

        <a href="{{ route('products.index') }}" class="block text-gray-600">
            {{ __('Products') }}
        </a>

        @auth

            <div class="text-sm text-gray-500">
                Hi, {{ Auth::user()->name }}
            </div>

            @if(Auth::user()->isFarmer())
                <a href="{{ route('products.create') }}" class="block bg-green-500 text-white px-4 py-2 rounded-lg">
                    {{ __('+ Add Product') }}
                </a>
            @endif

            @if(Auth::user()->isConsumer())
                <a href="{{ route('consumer.dashboard') }}" class="block bg-green-100 text-green-600 px-4 py-2 rounded-lg">
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('consumer.bids') }}" class="block bg-purple-100 text-purple-600 px-4 py-2 rounded-lg">
                    {{ __('My Bids') }}
                </a>
            @endif

           @if(Auth::user()->isAdmin())

    <a href="{{ route('admin.dashboard') }}"
       class="block bg-blue-500 text-white px-4 py-2 rounded-lg">
       {{ __('📊 Dashboard') }}
    </a>

    <a href="{{ route('admin.products') }}"
       class="block bg-indigo-500 text-white px-4 py-2 rounded-lg">
       {{ __('📦 Products') }}
    </a>

@endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left bg-red-500 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>

        @endauth

    </div>

</nav>