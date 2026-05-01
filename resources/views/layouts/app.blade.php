<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Farmer Market</title>

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                   {{ __('ui.products') }}
                </a>

                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="text-gray-600 hover:text-green-600 font-medium transition">
                       {{ __('ui.profile') }}
                    </a>

                    <a href="{{ route('notifications.index') }}"
                       class="relative text-gray-600 hover:text-green-600 font-medium transition">
                       {{ __('ui.notifications') }}
                       @if(auth()->user()->unreadNotifications->count())
                           <span id="notification-count" class="absolute -top-2 -right-3 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[11px] text-white">{{ auth()->user()->unreadNotifications->count() }}</span>
                       @else
                           <span id="notification-count" class="hidden"></span>
                       @endif
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-2 rounded-full text-sm {{ app()->getLocale() === 'en' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:text-green-600' }}">
                            EN
                        </a>
                        <a href="{{ route('locale.switch', 'hi') }}" class="px-3 py-2 rounded-full text-sm {{ app()->getLocale() === 'hi' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:text-green-600' }}">
                            HI
                        </a>
                    </div>

                    {{-- 👤 USER NAME --}}
                    <span class="text-gray-500 hidden md:block">
                        Hi, {{ auth()->user()->name }}
                    </span>

                    {{-- Consumer --}}
                    @if(auth()->user()->isConsumer())
                        <a href="{{ route('consumer.dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition transform hover:scale-105">
                           {{ __('ui.dashboard') }}
                        </a>

                        <a href="{{ route('consumer.bids') }}"
                           class="px-4 py-2 rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition transform hover:scale-105">
                           {{ __('ui.my_bids') }}
                        </a>

                        <a href="{{ route('consumer.wishlist') }}"
                           class="px-4 py-2 rounded-lg bg-pink-100 text-pink-600 hover:bg-pink-200 transition transform hover:scale-105">
                           {{ __('ui.wishlist') }}
                        </a>
                    @endif

                    {{-- Farmer --}}
                    @if(auth()->user()->isFarmer())
                        <a href="{{ route('products.create') }}"
                           class="px-4 py-2 rounded-lg bg-green-500 text-white shadow hover:bg-green-600 transition transform hover:scale-105">
                           {{ __('ui.add_product') }}
                        </a>
                    @endif

                    {{-- Admin --}}
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-blue-500 text-white shadow hover:bg-blue-600 transition transform hover:scale-105">
                           {{ __('ui.admin_panel') }}
                        </a>
                    @endif

                    {{-- Logout --}}
                    <a href="{{ route('logout.show') }}"
                       class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition transform hover:scale-105">
                        {{ __('ui.logout') }}
                    </a>

                @endauth

            </div>
        </div>
    </nav>

    <!-- 🌟 MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Analytics & Real-time Dashboard Script -->
    @if(Route::currentRouteName() === 'dashboard')
    <script>
        let dashboardChart = null;

        function updateDashboardStats() {
            fetch('/api/dashboard-stats')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('stat-total-products').textContent = data.total_products;
                    document.getElementById('stat-pending-products').textContent = data.pending_products;
                    document.getElementById('stat-open-bids').textContent = data.open_bids;

                    // Update chart
                    if (dashboardChart) {
                        dashboardChart.data.datasets[0].data = [data.approved_products, data.pending_products, data.rejected_products];
                        dashboardChart.update();
                    }
                })
                .catch(err => console.error('Failed to update dashboard stats:', err));
        }

        function initDashboardChart() {
            const ctx = document.getElementById('dashboardChart');
            if (!ctx) return;

            dashboardChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [0, 0, 0],
                        backgroundColor: ['#22c55e', '#f97316', '#ef4444'],
                        borderColor: ['#fff', '#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 16,
                                font: { size: 13 }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDashboardChart();
            updateDashboardStats();
            setInterval(updateDashboardStats, 30000); // Update every 30 seconds
        });
    </script>
    @endif

    @yield('scripts')
</body>
</html>