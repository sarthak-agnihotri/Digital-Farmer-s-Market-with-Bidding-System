@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6 text-center">
        Welcome {{ auth()->user()->name }} 👋
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Browse Products -->
        <a href="{{ route('products.index') }}"
           class="bg-blue-600 text-white p-6 rounded shadow hover:bg-blue-700 text-center">
            🛒 Browse Products
        </a>

        <!-- My Bids -->
        <a href="{{ route('consumer.bids') }}"
           class="bg-green-600 text-white p-6 rounded shadow hover:bg-green-700 text-center">
            💰 My Bids
        </a>

        <!-- Profile -->
        <a href="#"
           class="bg-gray-600 text-white p-6 rounded shadow text-center">
            👤 My Profile
        </a>

    </div>

</div>

@endsection