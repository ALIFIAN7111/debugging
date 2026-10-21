<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir — WM SMOKY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F7F4EE] text-[#17202D] antialiased">
    <header class="border-b border-[#E8E1D6] bg-[#FFF9EF] px-5 py-4 sm:px-8">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
            <div><p class="text-xs font-black uppercase tracking-[.18em] text-[#F2674A]">WM SMOKY</p><h1 class="mt-1 text-xl font-black">🛒 Aplikasi Kasir</h1></div>
            <div class="flex items-center gap-3">
                @if (auth()->user()->role === 'admin')<a href="{{ route('admin') }}" class="rounded-xl border border-[#E8E1D6] px-4 py-2 text-sm font-bold text-[#69717D]">Admin</a>@endif
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-xl bg-[#17202D] px-4 py-2 text-sm font-bold text-white">Keluar</button></form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-7 sm:px-8" x-data="cashier(@js($products->map(fn ($product) => ['id' => $product->id, 'name' => $product->name, 'price' => (float) $product->harga])))">
        @if (session('status'))<div class="mb-6 rounded-xl border border-[#BCE9DF] bg-[#E7F6F2] px-4 py-3 text-sm font-bold text-[#197A69]">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">{{ $errors->first() }}</div>@endif

        <div class="grid gap-6 lg:grid-cols-[1.2fr_.8fr]">
            <section><div class="mb-4 flex items-end justify-between"><div><h2 class="text-xl font-black">Pilih menu</h2><p class="mt-1 text-sm text-[#69717D]">Klik menu untuk menambah ke keranjang.</p></div><span class="rounded-full bg-[#17202D] px-3 py-1 text-xs font-bold text-white">{{ $products->count() }} menu</span></div>
                @if ($products->isEmpty())<div class="rounded-2xl border border-[#E8E1D6] bg-white p-8 text-center text-sm text-[#69717D]">Belum ada menu. Admin perlu menambah produk dulu.</div>@else
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">@foreach ($products as $product)<button type="button" @click="add({ id: {{ $product->id }}, name: @js($product->name), price: {{ (float) $product->harga }} })" class="rounded-2xl border border-[#E8E1D6] bg-white p-5 text-left transition hover:-translate-y-1 hover:border-[#F7C843] hover:shadow-[0_6px_0_#F7C843]"><p class="font-black">{{ $product->name }}</p><p class="mt-3 text-lg font-black text-[#F2674A]">Rp {{ number_format($product->harga, 0, ',', '.') }}</p><p class="mt-2 text-xs font-bold text-[#69717D]">+ Tambah</p></button>@endforeach</div>@endif
            </section>

            <section class="h-fit rounded-2xl border border-[#E8E1D6] bg-white p-5 sm:p-6"><h2 class="text-xl font-black">Keranjang</h2>
                <form method="POST" action="{{ route('kasir.order.store') }}" class="mt-5">@csrf
                    <template x-for="(item, index) in items" :key="item.product_id"><div><input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id"><input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity"></div></template>
                    <div class="divide-y divide-[#F0EBE2]"><template x-if="items.length === 0"><p class="py-6 text-sm text-[#69717D]">Keranjang masih kosong.</p></template><template x-for="item in items" :key="item.product_id"><div class="py-3"><div class="flex justify-between gap-3"><p class="font-bold" x-text="item.name"></p><button type="button" @click="remove(item.product_id)" class="text-xs font-bold text-[#D84C35]">Hapus</button></div><div class="mt-2 flex items-center justify-between"><div class="flex items-center gap-2"><button type="button" @click="change(item.product_id, -1)" class="grid h-7 w-7 place-items-center rounded-lg bg-[#FFF9EF] font-black">−</button><span class="w-6 text-center font-bold" x-text="item.quantity"></span><button type="button" @click="change(item.product_id, 1)" class="grid h-7 w-7 place-items-center rounded-lg bg-[#FFF9EF] font-black">+</button></div><span class="font-black text-[#F2674A]" x-text="rupiah(item.price * item.quantity)"></span></div></div></template></div>
                    <div class="mt-5 border-t-2 border-[#17202D] pt-4"><div class="flex items-center justify-between"><span class="font-bold">Total</span><span class="text-2xl font-black" x-text="rupiah(total)"></span></div></div>
                    <div class="mt-5 space-y-3"><input name="customer_name" placeholder="Nama pembeli (opsional)" class="w-full rounded-xl border-2 border-[#E8E1D6] px-3 py-2.5"><select name="payment_method" required class="w-full rounded-xl border-2 border-[#E8E1D6] px-3 py-2.5"><option value="">Pilih pembayaran</option>@foreach ($paymentMethods as $method)<option value="{{ $method->name }}">{{ $method->name }}</option>@endforeach</select><textarea name="notes" maxlength="500" placeholder="Catatan pesanan (opsional)" class="h-20 w-full rounded-xl border-2 border-[#E8E1D6] px-3 py-2.5"></textarea><button :disabled="items.length === 0" class="w-full rounded-xl bg-[#F2674A] py-3 font-black text-white disabled:cursor-not-allowed disabled:opacity-50">Simpan transaksi</button></div>
                </form>
            </section>
        </div>

        <section class="mt-8 overflow-hidden rounded-2xl border border-[#E8E1D6] bg-white"><div class="border-b border-[#E8E1D6] px-6 py-5"><h2 class="text-lg font-black">Transaksi terbaru</h2></div><div class="divide-y divide-[#F0EBE2]">@forelse ($recentOrders as $order)<div class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"><div><p class="font-bold">{{ $order->order_code }} · {{ $order->customer_name ?: 'Pembeli umum' }}</p><p class="mt-1 text-xs text-[#69717D]">{{ $order->items->sum('quantity') }} item · {{ $order->payment_method }} · {{ $order->status }}</p></div><p class="font-black text-[#F2674A]">Rp {{ number_format($order->total, 0, ',', '.') }}</p></div>@empty<div class="px-6 py-8 text-sm text-[#69717D]">Belum ada transaksi.</div>@endforelse</div></section>
    </main>

    <script>
        function cashier(products) { return { items: [], get total() { return this.items.reduce((total, item) => total + item.price * item.quantity, 0); }, add(product) { const item = this.items.find(item => item.product_id === product.id); if (item) { item.quantity++; return; } this.items.push({ product_id: product.id, name: product.name, price: product.price, quantity: 1 }); }, change(id, amount) { const item = this.items.find(item => item.product_id === id); if (!item) return; item.quantity += amount; if (item.quantity < 1) this.remove(id); }, remove(id) { this.items = this.items.filter(item => item.product_id !== id); }, rupiah(value) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value); } } }
    </script>
</body>
</html>
