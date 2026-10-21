<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Dashboard Admin WM SMOKY</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .modal { display: none; }
        .modal.active { display: flex; }
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

            <a href="{{ route('dashboard.inventory') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-red-500 to-orange-500 text-white transition">
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
                    <i data-lucide="package" class="w-8 h-8 text-orange-600"></i>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Inventory</h1>
                </div>
                <p class="text-gray-600">Pantau stok bahan baku dan produksi</p>
            </div>
            <button onclick="openModal('addIngredientModal')" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Tambah Bahan
            </button>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                <p class="text-green-800 font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b border-gray-200">
            <button onclick="switchTab('ingredients')" class="px-4 py-3 font-semibold text-orange-600 border-b-2 border-orange-600">
                Bahan Baku
            </button>
            <button onclick="switchTab('production')" class="px-4 py-3 font-semibold text-gray-600 hover:text-orange-600">
                Stok Produksi
            </button>
        </div>

        <!-- Ingredients Tab -->
        <div id="ingredients-tab" class="space-y-6">
            <!-- Ingredients List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($ingredients as $ingredient)
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $ingredient->name }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $ingredient->unit }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="editIngredient({{ $ingredient->id }})" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('dashboard.ingredient.destroy', $ingredient->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bahan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        @php
                            $percentage = ($ingredient->stock / ($ingredient->minimum_stock + 50)) * 100;
                            $status = $ingredient->stock <= $ingredient->minimum_stock ? 'Rendah' : 'Normal';
                            $color = $ingredient->stock <= $ingredient->minimum_stock ? 'red' : 'green';
                        @endphp

                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-900">{{ $ingredient->stock }} {{ $ingredient->unit }}</span>
                                <span class="text-xs font-semibold {{ $color === 'red' ? 'text-red-600' : 'text-green-600' }}">{{ $status }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full {{ $color === 'red' ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Min: {{ $ingredient->minimum_stock }} {{ $ingredient->unit }}</p>
                        </div>

                        <!-- Cost Info -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Harga per Unit:</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($ingredient->unit_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-gray-600">Total Nilai:</span>
                                <span class="font-bold text-orange-600">Rp {{ number_format($ingredient->stock * $ingredient->unit_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-100 rounded-xl p-12 text-center">
                        <i data-lucide="package" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                        <p class="text-gray-600 font-medium">Belum ada bahan baku</p>
                        <p class="text-sm text-gray-500 mt-1">Mulai tambahkan bahan baku untuk tracking inventory</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Production Tab -->
        <div id="production-tab" class="hidden space-y-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Stok Produksi Harian</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200">
                            <tr class="text-gray-600 text-xs font-semibold uppercase">
                                <th class="text-left py-3">Produk</th>
                                <th class="text-left py-3">Jumlah</th>
                                <th class="text-left py-3">Unit</th>
                                <th class="text-left py-3">Tanggal Produksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($productionStocks as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 font-semibold text-gray-900">{{ $stock->name }}</td>
                                    <td class="py-3 text-gray-700">{{ $stock->quantity }}</td>
                                    <td class="py-3 text-gray-700">{{ $stock->unit }}</td>
                                    <td class="py-3 text-gray-700">{{ $stock->production_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">Belum ada stok produksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Ingredient -->
    <div id="addIngredientModal" class="modal fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Tambah Bahan Baku</h2>
                <button onclick="closeModal('addIngredientModal')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form action="{{ route('dashboard.ingredient.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Nama Bahan</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Unit</label>
                        <input type="text" name="unit" placeholder="kg, liter, pcs" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Stok Awal</label>
                        <input type="number" name="stock" value="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Min Stok</label>
                        <input type="number" name="minimum_stock" value="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Harga/Unit</label>
                        <input type="number" name="unit_cost" value="0" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition">
                        Tambah
                    </button>
                    <button type="button" onclick="closeModal('addIngredientModal')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function switchTab(tab) {
            document.getElementById('ingredients-tab').classList.toggle('hidden', tab !== 'ingredients');
            document.getElementById('production-tab').classList.toggle('hidden', tab !== 'production');
        }

        function editIngredient(id) {
            alert('Fitur edit akan ditambahkan segera');
        }
    </script>
</body>
</html>
