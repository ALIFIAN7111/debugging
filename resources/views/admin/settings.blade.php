<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Dashboard Admin WM SMOKY</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
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

            <a href="{{ route('dashboard.analytics') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
                <span class="font-semibold">Analytics</span>
            </a>

            <a href="{{ route('admin.module', 'pengeluaran') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                <span class="font-semibold">Pengeluaran</span>
            </a>

            <a href="{{ route('dashboard.settings') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-red-500 to-orange-500 text-white transition">
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
                <i data-lucide="settings" class="w-8 h-8 text-orange-600"></i>
                <h1 class="text-3xl font-bold text-gray-900">Pengaturan Sistem</h1>
            </div>
            <p class="text-gray-600">Kelola konfigurasi bisnis WM SMOKY Anda</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                <p class="text-green-800 font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Settings Form -->
        <form action="{{ route('dashboard.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Informasi Toko -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                    <i data-lucide="store" class="w-5 h-5 text-orange-600"></i>
                    <h2 class="text-lg font-bold text-gray-900">Informasi Toko</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Toko</label>
                        <input type="text" name="shop_name" value="{{ $settings['shop_name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('shop_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nomor Telepon</label>
                        <input type="text" name="shop_phone" value="{{ $settings['shop_phone'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('shop_phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat Toko</label>
                    <textarea name="shop_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">{{ $settings['shop_address'] }}</textarea>
                    @error('shop_address')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Teks Katalog Menu -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                    <i data-lucide="utensils" class="w-5 h-5 text-orange-600"></i>
                    <h2 class="text-lg font-bold text-gray-900">Teks Katalog Menu</h2>
                </div>
                <p class="text-xs text-gray-500 mb-4">Edit tulisan yang tampil di section Katalog (foto 1: label kuning + judul besar). Berlaku di Landing dan Dashboard Member setelah disimpan.</p>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Label kecil (kuning)</label>
                        <input type="text" name="catalog_label" value="{{ $settings['catalog_label'] }}" maxlength="80" placeholder="Katalog Menu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('catalog_label')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Judul besar</label>
                        <input type="text" name="catalog_title" value="{{ $settings['catalog_title'] }}" maxlength="120" placeholder="Pilih jagoanmu malam ini" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('catalog_title')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Subjudul</label>
                        <input type="text" name="catalog_subtitle" value="{{ $settings['catalog_subtitle'] }}" maxlength="200" placeholder="Dimasak fresh setelah kamu pesan." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('catalog_subtitle')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                    <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                    <h2 class="text-lg font-bold text-gray-900">Jam Operasional</h2>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Jam Buka - Tutup</label>
                    <input type="text" name="operating_hours" value="{{ $settings['operating_hours'] }}" placeholder="19:00 - 00:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: HH:MM - HH:MM (contoh: 19:00 - 00:00)</p>
                    @error('operating_hours')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Konfigurasi Harga -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                    <i data-lucide="tag" class="w-5 h-5 text-green-600"></i>
                    <h2 class="text-lg font-bold text-gray-900">Konfigurasi Harga</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Tarif Pajak (%)</label>
                        <div class="flex items-center">
                            <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <span class="ml-2 text-gray-600 font-semibold">%</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pajak diterapkan otomatis pada setiap transaksi</p>
                        @error('tax_rate')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Biaya Layanan (%)</label>
                        <div class="flex items-center">
                            <input type="number" name="service_charge" value="{{ $settings['service_charge'] }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <span class="ml-2 text-gray-600 font-semibold">%</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Biaya layanan opsional untuk layanan dine-in</p>
                        @error('service_charge')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Simpan Pengaturan
                </button>
                <a href="{{ route('dashboard.index') }}" class="px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition flex items-center gap-2">
                    <i data-lucide="x" class="w-5 h-5"></i>
                    Batal
                </a>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="mt-12 bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-red-900">Zona Berbahaya</h3>
                    <p class="text-sm text-red-800 mt-1">Tindakan di bawah tidak dapat dibatalkan. Lakukan dengan hati-hati.</p>
                    <button type="button" class="mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition" onclick="alert('Fitur reset database akan ditambahkan di update selanjutnya')">
                        Reset Semua Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
