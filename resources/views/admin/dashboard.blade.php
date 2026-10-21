<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WM SMOKY</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); }
        .sidebar-active { background: linear-gradient(135deg, #FF2A55 0%, #FF5E00 100%); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="bg-gray-50">

    <!-- SIDEBAR -->
    <div class="fixed left-0 top-0 w-64 h-screen bg-white border-r border-gray-200 shadow-sm flex flex-col">
        <!-- Logo -->
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

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.index') ? 'sidebar-active text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                <i data-lucide="chart-2" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.module', 'menu') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="utensils" class="w-5 h-5"></i>
                <span class="font-semibold">Menu</span>
            </a>

            <a href="{{ route('dashboard.inventory') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.inventory') ? 'sidebar-active text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span class="font-semibold">Inventory</span>
            </a>

            <a href="{{ route('order-management.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('order-management.*') ? 'bg-gradient-to-r from-red-500 to-orange-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                <span class="font-semibold">Pesanan</span>
            </a>

            <a href="{{ route('dashboard.analytics') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.analytics') ? 'sidebar-active text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
                <span class="font-semibold">Analytics</span>
            </a>

            <a href="{{ route('admin.module', 'pengeluaran') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                <span class="font-semibold">Pengeluaran</span>
            </a>

            <a href="{{ route('admin.module', 'bundling') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="gift" class="w-5 h-5"></i>
                <span class="font-semibold">Bundling</span>
            </a>

            <a href="{{ route('dashboard.settings') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.settings') ? 'sidebar-active text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span class="font-semibold">Pengaturan</span>
            </a>
        </nav>

        <!-- User Info -->
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
            <h1 class="text-3xl font-bold text-gray-900">Dashboard WM SMOKY</h1>
            <p class="text-gray-600 mt-1">Kelola seluruh sistem penjualan makanan dengan mudah</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Penjualan Hari Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['sales_today'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">{{ $stats['orders_today'] }} pesanan</p>
            </div>

            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Penjualan Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['sales_month'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">{{ $stats['orders_month'] }} pesanan</p>
            </div>

            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pengeluaran Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['expenses_month'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                        <i data-lucide="wallet" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Total biaya operasional</p>
            </div>

            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Profit Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['profit_month'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i data-lucide="zap" class="w-6 h-6 text-orange-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Pendapatan bersih</p>
            </div>
        </div>

        <!-- Charts & Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Top Products -->
            <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Produk Terlaris</h2>
                <div class="space-y-3">
                    @forelse($topProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $product->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->qty }} terjual | Rp {{ number_format($product->total, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-orange-400 to-red-500" style="width: {{ ($product->total / $topProducts->sum('total')) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran</h2>
                <div class="space-y-3">
                    @forelse($paymentMethods as $method)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="font-semibold text-gray-900 text-sm">{{ $method->payment_method }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-gray-500">{{ $method->count }} transaksi</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($method->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStockIngredients->count() > 0)
            <div class="mb-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-yellow-900">Stok Bahan Rendah</h3>
                        <p class="text-sm text-yellow-800 mt-1">{{ $lowStockIngredients->count() }} bahan memiliki stok di bawah minimum. Segera lakukan pemesanan.</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($lowStockIngredients as $ingredient)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $ingredient->name }} ({{ $ingredient->stock }} {{ $ingredient->unit }})</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
                <a href="{{ route('admin.module', 'pesanan') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold">Lihat Semua →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200">
                        <tr class="text-gray-600 text-xs font-semibold uppercase">
                            <th class="text-left py-3">No. Pesanan</th>
                            <th class="text-left py-3">Pelanggan</th>
                            <th class="text-left py-3">Item</th>
                            <th class="text-left py-3">Total</th>
                            <th class="text-left py-3">Metode</th>
                            <th class="text-left py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 font-semibold text-gray-900">{{ $order->order_code }}</td>
                                <td class="py-3 text-gray-700">{{ $order->customer_name ?? 'Guest' }}</td>
                                <td class="py-3 text-gray-700">{{ $order->items->count() }} item</td>
                                <td class="py-3 font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-3 text-gray-700 text-xs"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $order->payment_method }}</span></td>
                                <td class="py-3">
                                    @if($order->status === 'Selesai')
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Selesai</span>
                                    @elseif($order->status === 'Pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">Pending</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">Batal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500">Belum ada pesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
