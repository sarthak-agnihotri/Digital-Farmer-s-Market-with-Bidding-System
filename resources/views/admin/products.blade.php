@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- 🧠 Header -->
    <h2 class="text-2xl font-semibold mb-6">Admin Dashboard</h2>

    <!-- 📊 Modern Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

        <a href="?status=" class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">📊</div>
            <div>
                <p class="text-sm text-gray-500">Total</p>
                <h3 class="text-xl font-bold">{{ $totalProducts }}</h3>
            </div>
        </a>

        <a href="?status=pending" class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">⏳</div>
            <div>
                <p class="text-sm text-gray-500">Pending</p>
                <h3 class="text-xl font-bold">{{ $pendingCount }}</h3>
            </div>
        </a>

        <a href="?status=approved" class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-full">✅</div>
            <div>
                <p class="text-sm text-gray-500">Approved</p>
                <h3 class="text-xl font-bold">{{ $approvedCount }}</h3>
            </div>
        </a>

        <a href="?status=rejected" class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex items-center gap-4">
            <div class="bg-red-100 text-red-600 p-3 rounded-full">❌</div>
            <div>
                <p class="text-sm text-gray-500">Rejected</p>
                <h3 class="text-xl font-bold">{{ $rejectedCount }}</h3>
            </div>
        </a>

    </div>

    <!-- 🔍 Search + Filter -->
    <form method="GET" class="flex flex-col md:flex-row gap-4 mb-6">

        <input type="text" name="search" placeholder="Search product..."
            value="{{ request('search') }}"
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">

        <select name="status"
            class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
            <option value="">All</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
            <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
        </select>

        <button class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
            Filter
        </button>

    </form>

    <!-- 📦 Products -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($products as $product)

        <div class="bg-white rounded-2xl shadow hover:shadow-xl hover:scale-105 transition duration-300 overflow-hidden flex flex-col">

            <!-- 📷 Image -->
            <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="h-full w-full object-cover">
                @else
                    <span class="text-gray-400">No Image</span>
                @endif
            </div>

            <!-- 📄 Content -->
            <div class="p-4 flex flex-col flex-grow">

                <h3 class="font-semibold text-lg">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $product->category }}
                </p>

                <p class="text-green-600 font-bold mt-1">
                    ₹{{ $product->price }}
                </p>

                <p class="text-sm text-gray-600 mt-1">
                    Farmer: {{ $product->user->name ?? '-' }}
                </p>

                <!-- 🏷️ Status -->
                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full w-fit
                    {{ $product->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                    {{ $product->status == 'approved' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $product->status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}">
                    {{ ucfirst($product->status) }}
                </span>

                <!-- ⚡ Actions -->
                @if($product->status == 'pending')
                <div class="mt-auto pt-4 flex gap-2">

                    <button onclick="approve({{ $product->id }})"
                        class="w-1/2 bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">
                        Approve
                    </button>

                    <button onclick="reject({{ $product->id }})"
                        class="w-1/2 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
                        Reject
                    </button>

                </div>
                @endif

            </div>

        </div>

        @empty
            <p class="text-gray-500 col-span-3 text-center">
                No products found.
            </p>
        @endforelse

    </div>

    <!-- 📄 Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

<!-- ⚡ AJAX -->
<script>
function approve(id){
    fetch(`/admin/products/${id}/approve`, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}

function reject(id){
    fetch(`/admin/reject/${id}`, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}
</script>

@endsection