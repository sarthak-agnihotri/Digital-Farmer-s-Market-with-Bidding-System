@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold mb-6">Admin Panel - Product Approval</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($products as $product)

        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">

            <!-- 🖼️ IMAGE -->
            <div class="w-full bg-gray-100 flex items-center justify-center overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="h-full w-auto object-contain">
                @else
                    <span class="text-gray-400">No Image</span>
                @endif
            </div>

            <!-- 📦 CONTENT -->
            <div class="p-4">

                <div>
                    <h3 class="text-lg font-semibold mb-1">
                        {{ $product->name }}
                    </h3>

                    <p class="text-sm mb-2">
                        <strong>Status:</strong>
                        <span class="{{ strtolower($product->status) == 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </p>
                </div>

                <!-- 🔘 BUTTONS -->
                @if(strtolower(trim($product->status)) == 'pending')

                <div class="flex gap-2 mt-3">

                    <!-- APPROVE -->
                    <form method="POST" action="{{ route('admin.approve', $product->id) }}" class="w-1/2">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition text-sm">
                            Approve
                        </button>
                    </form>

                    <!-- REJECT -->
                    <form method="POST" action="{{ route('admin.reject', $product->id) }}" class="w-1/2">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition text-sm">
                            Reject
                        </button>
                    </form>

                </div>

                @else
                    <p class="text-green-600 font-semibold text-sm mt-3">Approved</p>
                @endif

            </div>

        </div>

        @empty
            <p class="text-gray-500">No pending products for approval.</p>
        @endforelse

    </div>

</div>

@endsection