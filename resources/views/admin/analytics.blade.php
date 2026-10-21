<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Dashboard Admin WM SMOKY</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- SIDEBAR -->
    <div class="fixed left-0 top-0 w-64 h-screen bg-white border-r border-gray-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-white font-bold">
                    🔥
                </div>
                <div>
                    <h1 class="font-bold text-gray-900">WM SMOKY</h1>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="chart-2" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.module', 'menu') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="utensils" class="w-5 h-5"></i>
                <span class="font-semibold">Menu</span>
            </a>

            <a href="{{ route('dashboard.inventory') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span class="font-semibold">Inventory</span>
            </a>

            <a href="{{ route('admin.module', 'pesanan') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                <span class="font-semibold">Pesanan</span>
            </a>

            <a href="{{ route('dashboard.analytics') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-red-500 to-orange-500 text-white transition">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
                <span class="font-semibold">Analytics</span>
            </a>

            <a href="{{ route('admin.module', 'pengeluaran') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                <span class="font-semibold">Pengeluaran</span>
            </a>

            <a href="{{ route('dashboard.settings') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span class="font-semibold">Pengaturan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center justify-between bg-gray-100 rounded-lg p-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-white text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-red-500 transition">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <i data-lucide="trending-up" class="w-8 h-8 text-orange-600"></i>
                <h1 class="text-3xl font-bold text-gray-900">Analytics & Laporan</h1>
            </div>
            <p class="text-gray-600">Analisis data penjualan dan performa bisnis WM SMOKY</p>
        </div>

        <!-- Daily Sales Chart -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Penjualan 7 Hari Terakhir</h2>
            <canvas id="dailySalesChart" height="80"></canvas>
        </div>

        <!-- Category Performance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Performa Kategori</h2>
                <div class="space-y-3">
                    @forelse($categoryPerformance as $item)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->qty }} terjual</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Monthly Comparison -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Perbandingan Bulanan</h2>
                <canvas id="monthlyComparisonChart" height="200"></canvas>
            </div>
        </div>

        <!-- Detailed Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-green-900">Total Penjualan</h3>
                    <i data-lucide="trending-up" class="w-5 h-5 text-green-600"></i>
                </div>
                <p class="text-3xl font-bold text-green-900">Rp {{ number_format($categoryPerformance->sum('total'), 0, ',', '.') }}</p>
                <p class="text-sm text-green-700 mt-2">{{ $categoryPerformance->sum('qty') }} item terjual</p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-blue-900">Rata-rata/Transaksi</h3>
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-blue-600"></i>
                </div>
                <p class="text-3xl font-bold text-blue-900">Rp {{ number_format($categoryPerformance->sum('total') / max(1, count($categoryPerformance)), 0, ',', '.') }}</p>
                <p class="text-sm text-blue-700 mt-2">Per produk</p>
            </div>

            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-orange-900">Produk Terlaris</h3>
                    <i data-lucide="award" class="w-5 h-5 text-orange-600"></i>
                </div>
                <p class="text-lg font-bold text-orange-900">{{ $categoryPerformance->first()?->product_name ?? 'N/A' }}</p>
                <p class="text-sm text-orange-700 mt-2">{{ $categoryPerformance->first()?->qty ?? 0 }} unit terjual</p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Daily Sales Chart
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        const dailySalesData = @json($dailySales);
        
        new Chart(dailySalesCtx, {
            type: 'line',
            data: {
                labels: dailySalesData.map(d => new Date(d.date).toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit' })),
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: dailySalesData.map(d => d.total),
                    borderColor: 'rgb(255, 90, 0)',
                    backgroundColor: 'rgba(255, 90, 0, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(255, 90, 0)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: { font: { size: 12 } }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Monthly Comparison Chart
        const monthlyCtx = document.getElementById('monthlyComparisonChart').getContext('2d');
        const monthlyData = @json($monthlyComparison);
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(d => monthNames[d.month - 1]),
                datasets: [
                    {
                        label: 'Penjualan (Rp)',
                        data: monthlyData.map(d => d.sales),
                        backgroundColor: 'rgba(255, 90, 0, 0.8)',
                        borderColor: 'rgb(255, 90, 0)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Jumlah Pesanan',
                        data: monthlyData.map(d => d.orders),
                        backgroundColor: 'rgba(255, 42, 85, 0.8)',
                        borderColor: 'rgb(255, 42, 85)',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: { font: { size: 12 } }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
