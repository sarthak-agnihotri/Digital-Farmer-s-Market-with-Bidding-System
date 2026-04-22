@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

<h2 class="text-2xl font-bold mb-6">📊 Admin Dashboard</h2>

<!-- STATS -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

    <div class="bg-white/30 backdrop-blur border rounded-2xl p-6 shadow">
        <p class="text-gray-600">Total Revenue</p>
        <h3 class="text-2xl font-bold text-green-700">
            ₹{{ $totalRevenue }}
        </h3>
    </div>

    <div class="bg-white/30 backdrop-blur border rounded-2xl p-6 shadow">
        <p class="text-gray-600">Total Orders</p>
        <h3 class="text-2xl font-bold">
            {{ $totalOrders }}
        </h3>
    </div>

    <div class="bg-white/30 backdrop-blur border rounded-2xl p-6 shadow">
        <p class="text-gray-600">Avg Order Value</p>
        <h3 class="text-2xl font-bold">
            ₹{{ $totalOrders ? round($totalRevenue / $totalOrders) : 0 }}
        </h3>
    </div>

</div>

<!-- CHART -->
<div class="bg-white/30 backdrop-blur border rounded-2xl p-6 shadow">
    <h3 class="text-lg font-semibold mb-4">Revenue Chart</h3>
    <canvas id="revenueChart"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($revenueData->pluck('date'));
const data = @json($revenueData->pluck('total'));

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue',
            data: data,
            borderWidth: 2,
            tension: 0.3
        }]
    }
});
</script>

@endsection
