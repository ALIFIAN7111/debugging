<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan Baru - Dashboard Admin WM SMOKY</title>
    
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
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <i data-lucide="plus-circle" class="w-8 h-8 text-orange-600"></i>
                <h1 class="text-3xl font-bold text-gray-900">Buat Pesanan Baru</h1>
            </div>
            <p class="text-gray-600">Tambahkan pesanan baru ke sistem</p>
        </div>

        <form action="{{ route('order-management.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Pesanan -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Pesanan</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Pelanggan (Opsional)</label>
                                <input type="text" name="customer_name" placeholder="Masukkan nama pelanggan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Metode Pembayaran <span class="text-red-600">*</span></label>
                                <select name="payment_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="3" placeholder="Tambahkan catatan khusus untuk pesanan ini..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Item -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Pilih Item Menu <span class="text-red-600">*</span></h2>
                        
                        <div class="space-y-2 mb-4">
                            <input type="text" id="searchProduct" placeholder="Cari menu..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto">
                            @foreach($products as $product)
                                <div class="p-4 border border-gray-200 rounded-lg hover:border-orange-500 cursor-pointer transition" onclick="addItem({{ $product->id }}, '{{ $product->name }}', {{ $product->harga }})">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                            <p class="text-sm text-orange-600 font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <i data-lucide="plus-circle" class="w-6 h-6 text-orange-500"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('items')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <!-- Item yang ditambahkan -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Item Pesanan</h2>
                        <div id="orderItems" class="space-y-2 max-h-96 overflow-y-auto">
                            <p class="text-center text-gray-500 text-sm py-8">Belum ada item</p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border border-orange-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="subtotal" class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-orange-200">
                                <span class="font-bold text-gray-900">Total</span>
                                <span id="total" class="text-2xl font-bold text-orange-600">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="space-y-2">
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center justify-center gap-2">
                            <i data-lucide="check" class="w-5 h-5"></i>
                            Buat Pesanan
                        </button>
                        <a href="{{ route('order-management.index') }}" class="w-full px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition flex items-center justify-center gap-2">
                            <i data-lucide="x" class="w-5 h-5"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Hidden input untuk store items -->
    <input type="hidden" id="itemsInput" name="items" value="[]">

    <script>
        lucide.createIcons();

        let items = [];

        function addItem(productId, productName, price) {
            const existingItem = items.find(i => i.product_id === productId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                items.push({
                    product_id: productId,
                    product_name: productName,
                    price: price,
                    quantity: 1
                });
            }

            renderItems();
            updateTotal();
        }

        function removeItem(productId) {
            items = items.filter(i => i.product_id !== productId);
            renderItems();
            updateTotal();
        }

        function updateQuantity(productId, quantity) {
            const item = items.find(i => i.product_id === productId);
            if (item) {
                if (quantity <= 0) {
                    removeItem(productId);
                } else {
                    item.quantity = parseInt(quantity);
                    updateTotal();
                }
            }
        }

        function renderItems() {
            const container = document.getElementById('orderItems');
            
            if (items.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 text-sm py-8">Belum ada item</p>';
                return;
            }

            container.innerHTML = items.map(item => `
                <div class="p-3 bg-gray-50 rounded-lg flex items-center justify-between">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">${item.product_name}</p>
                        <p class="text-xs text-gray-600">Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${item.product_id}, this.value)" class="w-12 px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-orange-500">
                        <button type="button" onclick="removeItem(${item.product_id})" class="p-1 text-red-600 hover:bg-red-100 rounded transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </div>
            `).join('');

            // Update hidden input
            document.getElementById('itemsInput').value = JSON.stringify(items.map(i => ({
                product_id: i.product_id,
                quantity: i.quantity
            })));
        }

        function updateTotal() {
            const total = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Sebelum submit, set items ke form
        document.querySelector('form').addEventListener('submit', function() {
            const itemsArray = items.map(i => ({
                product_id: i.product_id,
                quantity: i.quantity
            }));
            
            // Tambah hidden input untuk setiap item
            itemsArray.forEach((item, idx) => {
                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = `items[${idx}][product_id]`;
                input1.value = item.product_id;
                this.appendChild(input1);

                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = `items[${idx}][quantity]`;
                input2.value = item.quantity;
                this.appendChild(input2);
            });
        });
    </script>
</body>
</html>
