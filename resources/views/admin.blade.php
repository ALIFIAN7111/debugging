<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — WM SMOKY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F7F4EE] text-[#17202D] antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="hidden w-64 shrink-0 flex-col bg-[#17202D] px-5 py-6 text-white lg:flex">
            <a href="{{ route('admin') }}" class="flex items-center gap-3 px-2">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#F7C843] text-xl text-[#17202D]">✦</span>
                <span class="font-black tracking-[.12em]">WM SMOKY<span class="text-[#F7C843]">.ID</span><small class="mt-1 block text-[10px] font-bold tracking-[.2em] text-[#AEB7C3]">ADMIN AREA</small></span>
            </a>
            <nav class="mt-12 space-y-2 text-sm font-bold">
                <p class="mb-3 px-3 text-[10px] uppercase tracking-[.2em] text-[#77818F]">Menu utama</p>
                <a href="{{ route('admin') }}" class="flex items-center gap-3 rounded-xl bg-[#F7C843] px-3 py-3 text-[#17202D]"><span>▦</span> Dashboard</a>
                <a href="#produk" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#C0C7D0] transition hover:bg-white/10 hover:text-white"><span>🍜</span> Produk</a>
                <a href="#pengguna" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#C0C7D0] transition hover:bg-white/10 hover:text-white"><span>♙</span> Pengguna</a>
                <a href="#laporan" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#C0C7D0] transition hover:bg-white/10 hover:text-white"><span>↗</span> Laporan</a>
                <a href="{{ route('kasir') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#C0C7D0] transition hover:bg-white/10 hover:text-white"><span>🛒</span> Kasir</a>
            </nav>
            <div class="mt-auto rounded-2xl bg-white/10 p-4 text-sm">
                <p class="font-black">Butuh bantuan?</p><p class="mt-1 text-xs leading-5 text-[#AEB7C3]">Kelola menu dan akun WM SMOKY dari satu tempat.</p>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <nav class="overflow-x-auto border-b border-[#E8E1D6] bg-[#17202D] px-5 py-3 lg:hidden">
                <div class="flex min-w-max items-center gap-2 text-sm font-bold text-white">
                    <a href="{{ route('admin') }}" class="rounded-lg bg-[#F7C843] px-3 py-2 text-[#17202D]">Dashboard</a>
                    @foreach ($modules as $item)
                        <a href="{{ route('admin.module', $item['slug']) }}" class="rounded-lg px-3 py-2 text-[#C0C7D0] hover:bg-white/10 hover:text-white">{{ $item['icon'] }} {{ $item['title'] }}</a>
                    @endforeach
                    <a href="{{ route('kasir') }}" class="rounded-lg px-3 py-2 text-[#C0C7D0] hover:bg-white/10 hover:text-white">🛒 Kasir</a>
                </div>
            </nav>
            <header class="border-b border-[#E8E1D6] bg-[#FFF9EF] px-5 py-4 sm:px-8">
                <div class="mx-auto flex max-w-6xl items-center justify-between">
                    <div><p class="text-xs font-black uppercase tracking-[.18em] text-[#F2674A]">Admin dashboard</p><h1 class="mt-1 text-xl font-black sm:text-2xl">Halo, {{ auth()->user()->name }} 👋</h1></div>
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/') }}" class="hidden rounded-xl border border-[#E8E1D6] px-4 py-2 text-sm font-bold text-[#69717D] transition hover:border-[#F2674A] hover:text-[#F2674A] sm:inline-flex">Lihat landing page</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-xl bg-[#17202D] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#2B3544]">Keluar</button></form>
                    </div>
                </div>
            </header>

            <div class="mx-auto max-w-6xl space-y-7 px-5 py-7 sm:px-8">
                <section class="rounded-3xl bg-[#F7C843] p-6 shadow-[0_8px_0_#E6D8B5] sm:p-8">
                    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                        <div><span class="rounded-full bg-[#17202D]/10 px-3 py-1 text-xs font-black uppercase tracking-[.15em] text-[#17202D]">Overview hari ini</span><h2 class="mt-4 max-w-lg text-3xl font-black leading-tight tracking-[-.04em] sm:text-4xl">Bikin WM SMOKY makin rame, satu menu tiap hari.</h2><p class="mt-3 text-sm font-semibold text-[#4F4A36]">Pantau data utama dari panel admin kamu.</p></div>
                        <div class="text-7xl" aria-hidden="true">🍜</div>
                    </div>
                </section>

                <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl border border-[#E8E1D6] bg-white p-5"><p class="text-sm font-bold text-[#69717D]">Total pengguna</p><p id="pengguna" class="mt-2 text-3xl font-black">{{ number_format($stats['users']) }}</p><p class="mt-2 text-xs font-bold text-[#2A9D8F]">Akun terdaftar</p></div>
                    <div class="rounded-2xl border border-[#E8E1D6] bg-white p-5"><p class="text-sm font-bold text-[#69717D]">Total produk</p><p class="mt-2 text-3xl font-black">{{ number_format($stats['products']) }}</p><p class="mt-2 text-xs font-bold text-[#F2674A]">Menu WM SMOKY</p></div>
                    <div class="rounded-2xl border border-[#E8E1D6] bg-white p-5"><p class="text-sm font-bold text-[#69717D]">Pesanan hari ini</p><p class="mt-2 text-3xl font-black">{{ number_format($stats['orders_today']) }}</p><p class="mt-2 text-xs font-bold text-[#2A9D8F]">Omzet Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</p></div>
                    <div id="laporan" class="rounded-2xl border border-[#E8E1D6] bg-white p-5"><p class="text-sm font-bold text-[#69717D]">Stok menipis</p><p class="mt-2 flex items-center gap-2 text-3xl font-black"><span class="h-3 w-3 rounded-full {{ $stats['low_stock'] ? 'bg-[#F2674A]' : 'bg-[#2A9D8F]' }}"></span>{{ number_format($stats['low_stock']) }}</p><p class="mt-2 text-xs font-bold text-[#F2674A]">Bahan di bawah minimum</p></div>
                </section>

                <section>
                    <div class="mb-4 flex items-end justify-between"><div><h2 class="text-xl font-black">Pusat operasional</h2><p class="mt-1 text-sm text-[#69717D]">Pilih fungsi yang ingin kamu kelola.</p></div><span class="hidden rounded-full bg-[#17202D] px-3 py-1 text-xs font-bold text-white sm:inline-flex">{{ count($modules) }} modul</span></div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($modules as $item)
                            <a href="{{ route('admin.module', $item['slug']) }}" class="group rounded-2xl border border-[#E8E1D6] bg-white p-5 transition hover:-translate-y-1 hover:border-[#F7C843] hover:shadow-[0_8px_0_#F7C843]">
                                <div class="flex items-start justify-between"><span class="grid h-11 w-11 place-items-center rounded-xl bg-[#FFF9EF] text-2xl">{{ $item['icon'] }}</span><span class="text-lg text-[#AEB7C3] transition group-hover:translate-x-1 group-hover:text-[#F2674A]">→</span></div>
                                <h3 class="mt-5 font-black">{{ $item['title'] }}</h3><p class="mt-1 text-sm leading-6 text-[#69717D]">{{ $item['description'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section id="produk" class="overflow-hidden rounded-2xl border border-[#E8E1D6] bg-white">
                    <div class="flex flex-col justify-between gap-3 border-b border-[#E8E1D6] px-5 py-5 sm:flex-row sm:items-center sm:px-6"><div><h2 class="text-lg font-black">Menu produk</h2><p class="mt-1 text-sm text-[#69717D]">Daftar menu yang tersimpan di database.</p></div><a href="{{ route('admin.module', 'menu') }}" class="rounded-xl bg-[#F2674A] px-4 py-2 text-center text-sm font-black text-white transition hover:bg-[#D84C35]">+ Tambah produk</a></div>
                    @if ($products->isEmpty())
                        <div class="px-6 py-12 text-center"><div class="text-4xl">🍜</div><p class="mt-3 font-black">Belum ada produk</p><p class="mt-1 text-sm text-[#69717D]">Tambahkan menu pertama WM SMOKY kamu.</p></div>
                    @else
                        <div class="overflow-x-auto"><table class="w-full min-w-[520px] text-left"><thead class="bg-[#FFF9EF] text-xs uppercase tracking-wider text-[#69717D]"><tr><th class="px-6 py-3 font-black">Nama menu</th><th class="px-6 py-3 font-black">Harga</th><th class="px-6 py-3 font-black">Status</th><th class="px-6 py-3"></th></tr></thead><tbody class="divide-y divide-[#F0EBE2]">@foreach ($products as $product)<tr class="transition hover:bg-[#FFF9EF]"><td class="px-6 py-4 font-bold">{{ $product->name }}</td><td class="px-6 py-4 font-semibold text-[#F2674A]">Rp {{ number_format($product->harga, 0, ',', '.') }}</td><td class="px-6 py-4"><span class="rounded-full bg-[#E7F6F2] px-3 py-1 text-xs font-black text-[#2A9D8F]">Tersedia</span></td><td class="px-6 py-4 text-right"><a href="{{ route('admin.module', 'menu') }}" class="text-sm font-bold text-[#69717D] transition hover:text-[#F2674A]">Kelola ›</a></td></tr>@endforeach</tbody></table></div>
                    @endif
                </section>

                <section class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-[#E8E1D6] bg-white p-6"><p class="text-sm font-bold text-[#69717D]">Pengeluaran bulan ini</p><p class="mt-2 text-3xl font-black">Rp {{ number_format($stats['expenses_month'], 0, ',', '.') }}</p><p class="mt-2 text-xs text-[#69717D]">Gunakan modul pengeluaran untuk mencatat biaya operasional.</p></div>
                    <div class="rounded-2xl border border-[#F7C843] bg-[#F7C843] p-6"><p class="text-sm font-bold text-[#4F4A36]">Estimasi keuntungan bulan ini</p><p class="mt-2 text-3xl font-black">Rp {{ number_format($stats['revenue_today'] - $stats['expenses_month'], 0, ',', '.') }}</p><p class="mt-2 text-xs font-bold text-[#4F4A36]">Omzet tercatat dikurangi pengeluaran.</p></div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
