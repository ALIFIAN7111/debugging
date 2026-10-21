<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Dashboard Admin WM SMOKY</title>
    
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

    <!-- SIDEBAR (simplified untuk detail page) -->
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

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('order-management.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span class="font-semibold">Kembali</span>
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
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('order-management.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $order->order_code }}</h1>
            </div>
            <p class="text-gray-600">Dipesan pada {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                <p class="text-green-800 font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Pelanggan -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Pelanggan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-semibold text-gray-900">{{ $order->customer_name ?? 'Guest' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran</p>
                            <p class="font-semibold text-gray-900">{{ $order->payment_method }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kasir</p>
                            <p class="font-semibold text-gray-900">{{ $order->cashier?->name ?? 'Sistem' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Daftar Item -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Item</h2>
                    <div class="space-y-3">
                        @forelse($order->items as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-6">Tidak ada item</p>
                        @endforelse
                    </div>
                </div>

                <!-- Catatan Pesanan -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan Pesanan</h2>
                    <form action="{{ route('order-management.update-notes', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">{{ $order->notes }}</textarea>
                        <button type="submit" class="mt-3 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition text-sm">
                            Simpan Catatan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Status Pesanan</h2>
                    <div class="mb-4">
                        @if($order->status === 'Selesai')
                            <span class="status-badge status-selesai">Selesai</span>
                        @elseif($order->status === 'Pending')
                            <span class="status-badge status-pending">Pending</span>
                        @else
                            <span class="status-badge status-batal">Batal</span>
                        @endif
                    </div>

                    <form action="{{ route('order-management.update-status', $order->id) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                            <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Batal" {{ $order->status === 'Batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-sm">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Aksi -->
                <div class="space-y-2">
                    <a href="{{ route('order-management.print', $order->id) }}" target="_blank" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Print Pesanan
                    </a>
                    <a href="{{ route('order-management.index') }}" class="w-full px-4 py-2 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
