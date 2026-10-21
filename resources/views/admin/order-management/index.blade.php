<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Dashboard Admin WM SMOKY</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .status-batal { background-color: #fee2e2; color: #991b1b; }
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

            <a href="{{ route('order-management.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-red-500 to-orange-500 text-white transition">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                <span class="font-semibold">Pesanan</span>
            </a>

            <a href="{{ route('dashboard.analytics') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
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
        <div class="mb-8 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <i data-lucide="receipt" class="w-8 h-8 text-orange-600"></i>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Pesanan</h1>
                </div>
                <p class="text-gray-600">Kelola semua pesanan pelanggan dengan mudah</p>
            </div>
            <a href="{{ route('order-management.create') }}" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Pesanan Baru
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                <p class="text-green-800 font-medium">{{ session('status') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pesanan Pending</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_pending'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pesanan Selesai</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_completed'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pesanan Batal</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_cancelled'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm mb-6">
            <form action="{{ route('order-management.filter') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Cari Pesanan</label>
                        <input type="text" name="search" placeholder="No. Pesanan atau Nama..." value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                            <option value="all">Semua Status</option>
                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center gap-2 text-sm">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Cari
                    </button>
                    <a href="{{ route('order-management.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition text-sm">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr class="text-gray-600 text-xs font-semibold uppercase">
                            <th class="text-left py-3 px-6">No. Pesanan</th>
                            <th class="text-left py-3 px-6">Pelanggan</th>
                            <th class="text-left py-3 px-6">Item</th>
                            <th class="text-left py-3 px-6">Total</th>
                            <th class="text-left py-3 px-6">Metode</th>
                            <th class="text-left py-3 px-6">Status</th>
                            <th class="text-left py-3 px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <span class="font-semibold text-gray-900">{{ $order->order_code }}</span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </td>
                                <td class="py-4 px-6 text-gray-700">{{ $order->customer_name ?? 'Guest' }}</td>
                                <td class="py-4 px-6 text-gray-700">{{ $order->items->count() }} item</td>
                                <td class="py-4 px-6 font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-4 px-6">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $order->payment_method }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($order->status === 'Selesai')
                                        <span class="status-badge status-selesai">Selesai</span>
                                    @elseif($order->status === 'Pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @else
                                        <span class="status-badge status-batal">Batal</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('order-management.show', $order->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition" title="Lihat Detail">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('order-management.print', $order->id) }}" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition" title="Print" target="_blank">
                                            <i data-lucide="printer" class="w-4 h-4"></i>
                                        </a>
                                        @if($order->status === 'Pending')
                                            <form action="{{ route('order-management.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500">
                                    <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                                    <p class="font-medium">Tidak ada pesanan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                    </div>
                    <div class="flex gap-2">
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
