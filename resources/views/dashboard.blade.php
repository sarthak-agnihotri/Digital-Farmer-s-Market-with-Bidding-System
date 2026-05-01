@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- 👋 Welcome -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6 border">
        <h2 class="text-2xl font-semibold">
            {{ __('Welcome,') }} <span class="text-green-600">{{ auth()->user()->name }}</span> 👋
        </h2>
        <p class="text-gray-500 mt-1">{{ __('Role:') }} {{ ucfirst(auth()->user()->role) }}</p>
    </div>

    <!-- 📊 Analytics Dashboard -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ __('Analytics & Live Trends') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Real-time product and bidding insights.') }}</p>
            </div>
            <div class="text-sm text-gray-600">{{ __('Updated every 30 seconds') }}</div>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">{{ __('Total Products') }}</p>
                <p id="stat-total-products" class="mt-3 text-2xl font-bold text-green-700">0</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">{{ __('Pending Approval') }}</p>
                <p id="stat-pending-products" class="mt-3 text-2xl font-bold text-orange-700">0</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">{{ __('Open Bids') }}</p>
                <p id="stat-open-bids" class="mt-3 text-2xl font-bold text-blue-700">0</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-sm font-medium text-gray-700 mb-3">{{ __('Products by Status') }}</h3>
            <div class="h-64 w-full max-w-md mx-auto">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ⚡ Modern Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Add Product -->
        <a href="{{ route('products.create') }}"
           class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">

            <div class="bg-green-100 text-green-600 p-3 rounded-full text-xl">➕</div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Quick Actions') }}</p>
                <h3 class="font-semibold">{{ __('Add Product') }}</h3>
            </div>
        </a>

        <!-- View Products -->
        <a href="{{ route('products.index') }}"
           class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">

            <div class="bg-blue-100 text-blue-600 p-3 rounded-full text-xl">🛒</div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Manage') }}</p>
                <h3 class="font-semibold">{{ __('View Products') }}</h3>
            </div>
        </a>

        <!-- Total Products -->
        <div class="bg-white p-5 rounded-2xl shadow flex items-center gap-4">

            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full text-xl">📦</div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Total Products') }}</p>
                <h3 class="text-xl font-bold">
                    {{ \App\Models\Product::where('user_id', auth()->id())->count() }}
                </h3>
            </div>
        </div>

    </div>

    <!-- 📦 My Products -->
    <h3 class="text-2xl font-semibold mb-4 border-l-4 border-green-500 pl-3">
        {{ __('My Products') }}
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @php
            $myProducts = \App\Models\Product::where('user_id', auth()->id())->latest()->get();
        @endphp

        @forelse($myProducts as $product)

        <div class="bg-white rounded-2xl shadow hover:shadow-xl hover:scale-105 transition duration-300 overflow-hidden">

            <!-- Image -->
            <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="h-full w-full object-cover">
                @else
                    <span class="text-gray-400">{{ __('No Image') }}</span>
                @endif
            </div>

            <!-- Content -->
            <div class="p-4">

                <h4 class="font-semibold text-lg">
                    {{ $product->name }}
                </h4>

                <p class="text-gray-500 text-sm">
                    {{ $product->category }}
                </p>

                <p class="text-green-600 font-bold mt-2">
                    ₹{{ $product->price }}
                </p>

                <!-- Status -->
                <p class="mt-2 text-sm">
                    Status:
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $product->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ ucfirst(__($product->status)) }}
                    </span>
                </p>

                <!-- Actions -->
                <div class="flex justify-between mt-4 items-center gap-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:underline text-sm font-medium">{{ __('Edit') }}</a>
                    
                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-sm font-medium">{{ __('Delete') }}</button>
                    </form>
                </div>

            </div>

        </div>

        @empty
            <p class="text-gray-500">{{ __('No products added yet.') }}</p>
        @endforelse

    </div>

</div>

@endsection