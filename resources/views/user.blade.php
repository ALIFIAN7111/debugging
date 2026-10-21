@php
    $warung = $warung ?? config('warung');
    $catalog = collect($products ?? [])->map(fn ($product) => [
        'id' => $product->id,
        'name' => $product->name,
        'price' => (float) $product->harga,
        'harga' => (float) $product->harga,
        'category' => strtolower($product->category ?? 'mie'),
        'description' => $product->description ?? 'Racikan hangat favorit yang dibuat fresh saat dipesan.',
        'image' => $product->image ? asset($product->image) : null,
        'stock' => (int) ($product->stock ?? 0),
        'available' => (bool) ($product->is_available ?? true) && (int) ($product->stock ?? 0) > 0,
        'rating' => round((float) ($product->rating ?? 5.0), 1),
        'spice_level' => (int) ($product->spice_level ?? 0),
        'is_best_seller' => (bool) ($product->is_best_seller ?? false),
    ])->values();
    $bundlesData = collect($bundles ?? [])->map(fn ($b) => [
        'id' => $b->id,
        'name' => $b->name,
        'description' => $b->description,
        'price' => (float) $b->price,
        'original_price' => $b->original_price !== null ? (float) $b->original_price : null,
        'badge' => $b->badge,
        'is_popular' => (bool) ($b->is_popular ?? false),
        'discount_percent' => (($b->original_price ?? 0) > ($b->price ?? 0) && ($b->original_price ?? 0) > 0)
            ? (int) round((1 - ((float) $b->price / (float) $b->original_price)) * 100) : 0,
    ])->values();
    $placeholder = asset('assets/menu/placeholder.svg');
    $avgRating = $catalog->count() ? round($catalog->avg('rating'), 1) : null;
    $maxDiscount = $bundlesData->count() ? (int) $bundlesData->max('discount_percent') : 0;
    $waLink = 'https://wa.me/'.($warung['phone_wa'] ?? '6281234567890').'?text='.urlencode($warung['wa_greeting'] ?? 'Halo WM SMOKY!');
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="WARMINDO SMOKY Bontang — Indomie smoky, dok-dok, rice bowl, dan es kekinian. Pesan online, pantau pesanan.">
    <title>WARMINDO SMOKY — Bontang Hitz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg:#0d0f14; --card:#12151c; --border:rgba(255,255,255,.08);
            --grad:linear-gradient(135deg,#ff6a00,#ff3d2e); --price:#ffc61a; --open:#1fc38a;
            --text:#fff; --muted:#a9b1c1;
            --radius-card:20px; --radius-btn:12px; --radius-chip:999px;
        }
        * { box-sizing:border-box }
        html { scroll-behavior:smooth }
        body { margin:0; background:var(--bg); color:var(--text); font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif; overflow-x:clip }
        section { scroll-margin-top:96px }
        h1,h2,h3,.font-display { font-family:'Outfit','Plus Jakarta Sans',sans-serif; font-weight:800; letter-spacing:-.01em }
        :focus-visible { outline:3px solid #ff6a00; outline-offset:2px; border-radius:8px }
        select option { color:#111 }
        .wrap { max-width:1280px; margin-inline:auto; padding-inline:20px }
        @media(min-width:640px){ .wrap{padding-inline:32px} }
        #site-header { background:rgba(13,15,20,.82); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px) }
        .nav-link { display:inline-flex; align-items:center; min-height:44px; padding:8px 14px; border-radius:var(--radius-chip); color:var(--muted); transition:color .2s ease,background .2s ease }
        .nav-link:hover { color:#fff; background:rgba(255,255,255,.06) }
        .nav-link.is-active { color:#fff }
        .nav-link.is-active::after { content:''; position:absolute; left:14px; right:14px; bottom:4px; height:3px; border-radius:99px; background:var(--grad) }
        .nav-link { position:relative }
        .glass { background:var(--card); border:1px solid var(--border) }
        .btn-grad { background:var(--grad); border-radius:var(--radius-btn); transition:transform .2s ease,box-shadow .2s ease,filter .2s ease }
        .btn-grad:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(255,106,0,.35); filter:brightness(1.05) }
        .hero-title { line-height:1.12; font-size:clamp(1.9rem,4.5vw + 1rem,3.4rem); display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; text-wrap:balance }
        .text-grad { background:var(--grad); -webkit-background-clip:text; background-clip:text; color:transparent }
        .menu-card { border-radius:var(--radius-card); border:1px solid transparent }
        .menu-photo { width:100%; aspect-ratio:4/3; object-fit:cover; display:block }
        .clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden }
        .filter-bar { scrollbar-width:thin }
        .filter-btn { min-height:44px; border:1px solid var(--border); transition:background .2s ease,color .2s ease,border-color .2s ease }
        .filter-btn[aria-pressed="true"] { background:var(--grad); color:#fff; border-color:transparent }
        .filter-btn:disabled { opacity:.45; cursor:not-allowed }
        .skeleton { position:relative; overflow:hidden; background:rgba(255,255,255,.07) }
        .skeleton::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(255,255,255,.14),transparent); animation:shimmer 1.4s infinite }
        @keyframes shimmer { from{transform:translateX(-100%)} to{transform:translateX(100%)} }
        .step-dot { height:8px; border-radius:99px; background:rgba(255,255,255,.14) }
        .step-dot.done { background:#ff6a00 }
        .step-dot.current { background:var(--price) }
        .is-loading .refresh-icon { animation:rot 1s linear infinite }
        @keyframes rot { to{transform:rotate(360deg)} }
        .cart-drawer{transform:translateX(110%);transition:transform .25s cubic-bezier(.2,.8,.2,1)}.cart-drawer.is-open{transform:translateX(0)}.scrim{opacity:0;pointer-events:none;transition:opacity .2s ease}.scrim.is-open{opacity:1;pointer-events:auto}.modal{opacity:0;pointer-events:none;transform:scale(.96) translateY(12px);transition:opacity .2s ease,transform .2s ease}.modal.is-open{opacity:1;pointer-events:auto;transform:scale(1) translateY(0)}.toast{transform:translate(-50%,140%);opacity:0;transition:transform .2s ease,opacity .2s ease}.toast.show{transform:translate(-50%,0);opacity:1}
        @keyframes rise{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        .rise { animation:rise .45s cubic-bezier(.2,.8,.2,1) both }
        .spice-btn[aria-pressed="true"] { background:var(--grad); color:#fff; border-color:transparent }
        @media (prefers-reduced-motion:reduce){ html{scroll-behavior:auto} *,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important} }
    </style>
</head>
<body class="min-h-screen">
<div id="scrim" class="scrim fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"></div>

<!-- 1. NAVBAR -->
<header id="site-header" class="sticky top-0 z-30 border-b border-white/10">
    <div class="wrap flex items-center justify-between gap-2 py-3">
        <a href="#beranda" class="flex shrink-0 items-center gap-3 rounded-xl" aria-label="WARMINDO SMOKY — beranda">
            <span class="grid h-11 w-11 place-items-center rounded-xl text-white shadow-lg" style="background:var(--grad)" aria-hidden="true"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 4-6 6.5-6 11a6 6 0 0 0 12 0c0-4.5-3-7-6-11Z"/></svg></span>
            <span><strong class="font-display block text-lg tracking-wide">WARMINDO SMOKY</strong><small class="block text-[10px] font-bold uppercase tracking-[.22em] text-[#ffc61a]">{{ $warung['sub'] ?? 'BONTANG HITZ' }}</small></span>
        </a>
        <nav class="hidden items-center gap-1 text-sm font-bold lg:flex" aria-label="Navigasi utama">
            <a href="#beranda" class="nav-link" data-nav="beranda">Beranda</a>
            <a href="#menu" class="nav-link" data-nav="menu">Katalog Menu</a>
            <a href="#paket" class="nav-link" data-nav="paket">Paket Hemat</a>
            <a href="#lokasi" class="nav-link" data-nav="lokasi">Vibe &amp; Lokasi</a>
            <a href="#testimoni" class="nav-link" data-nav="testimoni">Kata Gen Z</a>
        </nav>
        <div class="flex items-center gap-2">
            <a href="#paket" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 text-[#ffc61a] transition duration-200 hover:border-[#ff6a00]" aria-label="Lihat promo paket hemat"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 4-6 6.5-6 11a6 6 0 0 0 12 0c0-4.5-3-7-6-11Z"/></svg></a>
            <button id="cart-button" class="relative grid h-11 w-11 place-items-center rounded-xl border border-white/10 bg-white/5 text-white transition duration-200 hover:border-[#ff6a00]" aria-label="Buka keranjang belanja">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9h-12L6 6Zm0 0L5 3H2m4 18a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm12 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z"/></svg>
                <span id="cart-count" class="absolute -right-2 -top-2 grid h-6 min-w-6 place-items-center rounded-full px-1 text-xs font-black text-white" style="background:var(--grad)">0</span>
            </button>
            <a href="#orders" id="orders-button" class="nav-link hidden text-sm font-bold md:inline-flex" data-nav="orders">Pesanan saya</a>
            @auth
            <div class="relative hidden sm:block" id="user-menu-wrap">
                <button id="user-menu-button" class="flex min-h-11 items-center gap-2 rounded-full border border-white/10 bg-white/5 py-1.5 pl-1.5 pr-3 transition duration-200 hover:bg-white/10" aria-haspopup="menu" aria-expanded="false" aria-label="Menu akun {{ auth()->user()->name }}">
                    <span class="grid h-9 w-9 place-items-center rounded-full text-xs font-black text-black" style="background:#ffc61a" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    <span class="max-w-24 truncate text-sm font-bold">{{ auth()->user()->name }}</span>
                </button>
                <div id="user-menu" role="menu" aria-label="Menu akun" class="glass absolute right-0 top-full z-50 mt-2 hidden w-52 rounded-2xl p-2 shadow-xl">
                    <p class="truncate px-3 pb-1 pt-2 text-xs font-bold text-[#a9b1c1]">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}" role="none">@csrf<button type="submit" role="menuitem" class="flex min-h-11 w-full items-center gap-2 rounded-xl px-3 text-left text-sm font-bold text-red-300 transition duration-200 hover:bg-white/5">Keluar</button></form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="hidden min-h-11 items-center rounded-xl border border-white/10 px-4 py-2.5 text-sm font-bold sm:inline-flex">Masuk</a>
            @endauth
            <a href="#menu" class="btn-grad hidden min-h-11 items-center px-5 py-2.5 text-sm font-black text-white sm:inline-flex">Pesan Sekarang</a>
            <button id="nav-toggle" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 bg-white/5 lg:hidden" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-nav"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        </div>
    </div>
    <div id="mobile-nav" class="hidden border-t border-white/10 bg-[#0d0f14]/95 px-5 py-3 backdrop-blur-xl lg:hidden">
        <nav class="wrap flex flex-col gap-1 !px-0 text-sm font-bold" aria-label="Navigasi seluler">
            <a href="#beranda" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Beranda</a>
            <a href="#menu" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Katalog Menu</a>
            <a href="#paket" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Paket Hemat</a>
            <a href="#lokasi" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Vibe &amp; Lokasi</a>
            <a href="#testimoni" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Kata Gen Z</a>
            <a href="#orders" class="rounded-xl px-3 py-3 transition duration-200 hover:bg-white/5">Pesanan saya</a>
            <a href="#menu" class="btn-grad mt-2 inline-flex min-h-11 items-center justify-center px-5 py-3 text-sm font-black text-white">Pesan Sekarang</a>
            @auth<form method="POST" action="{{ route('logout') }}" class="sm:hidden">@csrf<button type="submit" class="w-full rounded-xl px-3 py-3 text-left text-red-300">Keluar</button></form>
            @else<a href="{{ route('login') }}" class="rounded-xl px-3 py-3 text-[#ffc61a] sm:hidden">Masuk</a>@endauth
        </nav>
    </div>
</header>

<main class="wrap pb-28 pt-8 sm:pb-20">
    <!-- 2. HERO -->
    <section id="beranda" aria-labelledby="hero-title" class="relative overflow-hidden">
        <div class="pointer-events-none absolute left-1/2 top-0 h-72 w-72 -translate-x-1/2 rounded-full bg-[#ff3d2e]/20 blur-[110px]" aria-hidden="true"></div>
        <div class="relative grid items-center gap-8 lg:grid-cols-[1.05fr_.95fr]">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-[#ff6a00]/40 bg-[#ff6a00]/10 px-4 py-2 text-xs font-black uppercase tracking-wider text-[#ffb08a]">Nongkrong &amp; makan hits #1 Bontang</span>
                <h1 id="hero-title" class="hero-title font-display mt-5 max-w-xl font-extrabold">Sensasi Indomie Smoky &amp; Dok-Dok Bontang <span class="text-grad">Kekinian</span></h1>
                <p class="mt-4 max-w-lg text-base leading-7 text-[#a9b1c1]">Wajan panas, aroma smoky, WiFi kencang. Nongkrong sampai malam tanpa bikin dompet nangis.</p>
                <p id="open-status" class="mt-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold" aria-live="polite"><span class="h-2 w-2 rounded-full bg-[#1fc38a]" aria-hidden="true"></span>Memuat jam buka...</p>
                @if($avgRating)<p id="hero-rating" class="mt-3 flex items-center gap-2 text-sm font-bold text-[#ffc61a]"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 1.5 12.6 7l6 .4-4.6 3.8 1.5 5.8L10 13.7 4.5 17l1.5-5.8L1.4 7.4l6-.4L10 1.5Z"/></svg>{{ number_format($avgRating, 1) }}/5.0 rating menu</p>@endif
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#menu" class="btn-grad inline-flex min-h-11 items-center gap-2 px-6 py-3.5 text-sm font-black text-white">Lihat Katalog Menu</a>
                    <a href="#lokasi" class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 text-sm font-bold transition duration-200 hover:border-[#ff6a00]"><svg class="h-4 w-4 text-[#ff6a00]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.1 7-11a7 7 0 1 0-14 0c0 5.9 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>Lokasi Strategis</a>
                </div>
            </div>
            <div class="glass overflow-hidden rounded-[20px] p-3">
                <img id="hero-img" src="{{ asset('assets/menu/mie.jpg') }}" alt="Mangkuk mie smoky hangat WM SMOKY" class="aspect-[4/3] w-full rounded-2xl object-cover" fetchpriority="high" onerror="this.onerror=null;this.src='{{ $placeholder }}'">
                <div id="hero-best" class="flex items-center justify-between gap-3 p-3" aria-live="polite">
                    <div class="min-w-0"><p class="text-xs font-bold uppercase tracking-wider text-[#a9b1c1]">Best seller</p><p class="truncate text-sm font-black" id="hero-best-name">Memuat menu terlaris...</p><p class="text-sm font-black text-[#ffc61a]" id="hero-best-price"></p></div>
                    <button id="hero-best-add" class="btn-grad grid h-11 w-11 shrink-0 place-items-center text-xl font-black text-white" aria-label="Tambah best seller ke keranjang" disabled>+</button>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. KATALOG -->
    <section id="menu" aria-labelledby="menu-title" class="pt-14">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div><span class="text-xs font-black uppercase tracking-[.2em] text-[#ff8a4d]">{{ $catalog['label'] ?? 'Katalog Menu' }}</span><h2 id="menu-title" class="font-display mt-2 text-3xl sm:text-4xl">{{ $catalog['title'] ?? 'Pilih jagoanmu malam ini.' }}</h2><p class="mt-2 text-sm text-[#a9b1c1]">{{ $catalog['subtitle'] ?? 'Dimasak fresh setelah kamu pesan.' }}</p></div>
            <div class="relative w-full sm:w-72" id="search-wrap">
                <label for="search" class="sr-only">Cari menu favorit</label>
                <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#a9b1c1]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3m2.3-5.2a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"/></svg>
                <input id="search" class="glass w-full rounded-2xl py-3 pl-11 pr-4 text-sm text-white outline-none transition duration-200 focus:border-[#ff6a00] disabled:cursor-not-allowed disabled:opacity-50" placeholder="Cari menu..." type="search" autocomplete="off">
            </div>
        </div>
        <div id="filters" class="filter-bar mt-6 flex gap-2 overflow-x-auto pb-2" role="group" aria-label="Filter kategori menu">
            <button data-filter="all" aria-pressed="true" class="filter-btn flex shrink-0 items-center gap-2 rounded-full px-5 py-2.5 text-sm font-black text-white"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 6h16M7 12h10m-7 6h4"/></svg>Semua</button>
            <button data-filter="mie" aria-pressed="false" class="filter-btn flex shrink-0 items-center gap-2 rounded-full bg-white/5 px-5 py-2.5 text-sm font-bold text-[#a9b1c1]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M5 12h14M5 12a7 7 0 0 0 14 0M8 12V7m4 5V5m4 7V7"/></svg>Mie Dok-Dok</button>
            <button data-filter="indomie" aria-pressed="false" class="filter-btn flex shrink-0 items-center gap-2 rounded-full bg-white/5 px-5 py-2.5 text-sm font-bold text-[#a9b1c1]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 4-6 6.5-6 11a6 6 0 0 0 12 0c0-4.5-3-7-6-11Z"/></svg>Indomie Custom</button>
            <button data-filter="rice" aria-pressed="false" class="filter-btn flex shrink-0 items-center gap-2 rounded-full bg-white/5 px-5 py-2.5 text-sm font-bold text-[#a9b1c1]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16a8 8 0 0 1-16 0Zm2 0c0-4 3-8 6-8"/></svg>Rice Bowl</button>
            <button data-filter="snack" aria-pressed="false" class="filter-btn flex shrink-0 items-center gap-2 rounded-full bg-white/5 px-5 py-2.5 text-sm font-bold text-[#a9b1c1]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10l-1 12H8L7 8Zm3 0a2 2 0 0 1 4 0"/></svg>Snack</button>
            <button data-filter="drink" aria-pressed="false" class="filter-btn flex shrink-0 items-center gap-2 rounded-full bg-white/5 px-5 py-2.5 text-sm font-bold text-[#a9b1c1]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10l-1.5 16h-7L7 4Zm3 4h4"/></svg>Es Kekinian</button>
        </div>
        <div id="menu-skeleton" class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" aria-hidden="true">
            @for ($i = 0; $i < 8; $i++)
            <div class="glass overflow-hidden rounded-[20px] p-3"><div class="skeleton aspect-[4/3] rounded-2xl"></div><div class="space-y-2 p-2"><div class="skeleton h-4 rounded-full"></div><div class="skeleton h-3 w-2/3 rounded-full"></div><div class="skeleton h-8 rounded-xl"></div></div></div>
            @endfor
        </div>
        <div id="menu-grid" class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"></div>
        <div id="menu-error" class="glass hidden rounded-[20px] px-6 py-12 text-center">
            <h3 class="text-xl font-black">Menu gagal dimuat.</h3>
            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#a9b1c1]">Koneksi bermasalah. Coba muat ulang sebentar lagi ya.</p>
            <button id="retry-menu" class="btn-grad mt-6 inline-flex min-h-11 items-center gap-2 px-5 py-3 text-sm font-black text-white">Coba lagi</button>
        </div>
        <div id="empty-state" class="glass hidden rounded-[20px] border-dashed px-6 py-16 text-center">
            <img src="{{ $placeholder }}" alt="Ilustrasi mangkuk kosong" class="mx-auto h-20 w-28 rounded-2xl object-cover">
            <h3 class="mt-4 text-xl font-black">Menu lagi disiapkan dapur kami.</h3>
            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#a9b1c1]">Cek lagi sebentar ya! Tim dapur sedang meracik yang hangat-hangat buat kamu.</p>
            <button id="reload-menu" class="btn-grad mt-6 inline-flex min-h-11 items-center gap-2 px-5 py-3 text-sm font-black text-white">Muat ulang</button>
        </div>
    </section>

    <!-- 4. PAKET -->
    <section id="paket" aria-labelledby="paket-title" class="pt-14">
        <div class="mx-auto mb-8 max-w-2xl text-center">
            <span class="rounded-full border border-[#ffc61a]/30 bg-[#ffc61a]/10 px-3 py-1 text-xs font-black uppercase tracking-widest text-[#ffc61a]">Hemat Banget</span>
            <h2 id="paket-title" class="font-display mt-3 text-3xl">Bundling Kombo Gen Z</h2>
            <p id="bundles-subtitle" class="mt-2 text-sm text-[#a9b1c1]">@if($maxDiscount>0)Hemat sampai {{ $maxDiscount }}%@else Makan wareg, dompet tenang.@endif</p>
        </div>
        <div id="bundles-grid" class="grid grid-cols-1 items-stretch gap-6 md:grid-cols-3" aria-live="polite"></div>
    </section>

    <!-- 5. VIBE -->
    <section id="vibe" aria-labelledby="vibe-title" class="pt-14">
        <div class="mx-auto mb-8 max-w-2xl text-center"><h2 id="vibe-title" class="font-display text-3xl">Kenapa WM SMOKY rame terus?</h2><p class="mt-2 text-sm text-[#a9b1c1]">Fasilitas komplit buat nugas, mabar, atau chilling.</p></div>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="glass rounded-[20px] p-6 text-center"><div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-xl bg-[#ff3d2e]/15 text-[#ff6a6a]"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M5 12a10 10 0 0 1 14 0m-4 4a6 6 0 0 1-6 0m-2 4h.01"/></svg></div><h3 class="font-bold">Free WiFi Kencang</h3><p class="mt-1 text-xs text-[#a9b1c1]">Anti lag buat mabar</p></div>
            <div class="glass rounded-[20px] p-6 text-center"><div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-xl bg-[#ff6a00]/15 text-[#ff8a4d]"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/></svg></div><h3 class="font-bold">Stopkontak Tiap Meja</h3><p class="mt-1 text-xs text-[#a9b1c1]">Laptop &amp; HP aman</p></div>
            <div class="glass rounded-[20px] p-6 text-center"><div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-xl bg-[#ffc61a]/15 text-[#ffc61a]"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18V6l10-2v12M9 18a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm10-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/></svg></div><h3 class="font-bold">Playlist Spotify Hits</h3><p class="mt-1 text-xs text-[#a9b1c1]">Lagu TikTok &amp; indie kekinian</p></div>
            <div class="glass rounded-[20px] p-6 text-center"><div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-xl bg-[#1fc38a]/15 text-[#1fc38a]"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg></div><h3 class="font-bold">Buka Sampai Malam</h3><p class="mt-1 text-xs text-[#a9b1c1]">{{ $warung['open_time'] ?? '19:00' }} – {{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}</p></div>
        </div>
    </section>

    <!-- 6. LOKASI -->
    <section id="lokasi" aria-labelledby="lokasi-title" class="pt-14">
        <div class="glass rounded-[20px] p-6 lg:p-10">
            <div class="grid items-center gap-8 lg:grid-cols-2">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#ff8a4d]">Spot Strategis</span>
                    <h2 id="lokasi-title" class="font-display mt-2 text-3xl">Lokasi WM SMOKY</h2>
                    <p class="mt-3 text-sm leading-relaxed text-[#a9b1c1]">Pusat keramaian Bontang. Pas buat kumpul sepulang sekolah, kuliah, atau kerja shift.</p>
                    <div class="mt-6 space-y-4 text-sm">
                        <p class="flex items-start gap-3"><svg class="h-5 w-5 shrink-0 text-[#ff3d2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.1 7-11a7 7 0 1 0-14 0c0 5.9 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>{{ $warung['address'] ?? '' }}</p>
                        <p class="flex items-center gap-3"><svg class="h-5 w-5 shrink-0 text-[#ff8a4d]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>Setiap Hari: {{ $warung['open_time'] ?? '19:00' }} – {{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}</p>
                        <p class="flex items-center gap-3"><svg class="h-5 w-5 shrink-0 text-[#ffc61a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5c0 8 8 16 16 16l2-4-4-2-2 2a12 12 0 0 1-6-6l2-2-2-4L3 5Z"/></svg>WhatsApp: {{ $warung['phone_display'] ?? '' }}</p>
                    </div>
                    <a href="{{ $warung['maps_link'] ?? 'https://www.google.com/maps' }}" target="_blank" rel="noopener" class="btn-grad mt-8 inline-flex min-h-11 items-center gap-2 px-6 py-3 text-sm font-bold text-white">Buka Google Maps Direction</a>
                </div>
                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <iframe id="map-frame" title="Peta lokasi WM SMOKY" src="{{ $warung['maps_embed'] ?? '' }}" class="h-64 w-full border-0 lg:h-80" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    <div id="map-fallback" class="hidden items-center justify-between gap-3 bg-white/5 p-4 text-sm"><p class="text-[#a9b1c1]">Peta gagal dimuat. Buka via tombol di samping ya.</p><a href="{{ $warung['maps_link'] ?? 'https://www.google.com/maps' }}" target="_blank" rel="noopener" class="btn-grad inline-flex min-h-11 shrink-0 items-center px-4 py-2.5 font-bold text-white">Buka Maps</a></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONI -->
    <section id="testimoni" aria-labelledby="testimoni-title" class="pt-14">
        <div class="mx-auto mb-8 max-w-2xl text-center"><h2 id="testimoni-title" class="font-display text-3xl">Kata Gen Z</h2><p class="mt-2 text-sm text-[#a9b1c1]">Cerita hangat dari meja-meja kami.</p></div>
        {{-- TODO: ganti dengan ulasan asli pelanggan. Data contoh dari config, jangan tampilkan sebagai nyata di produksi. --}}
        <div class="grid gap-4 md:grid-cols-3">
            @foreach(($warung['testimonials'] ?? []) as $t)
            <figure class="glass rounded-[20px] p-6"><blockquote class="text-sm leading-6 text-[#d4dae3]">“{{ $t['text'] }}”</blockquote><figcaption class="mt-4 text-sm font-black">{{ $t['name'] }} @if($warung['testimonials_sample'] ?? false)<span class="ml-2 rounded-full border border-[#ffc61a]/40 px-2 py-0.5 text-[10px] uppercase text-[#ffc61a]">Contoh</span>@endif</figcaption></figure>
            @endforeach
        </div>
    </section>

    <!-- 8. PESANAN -->
    <section id="orders" aria-labelledby="orders-title" class="glass mt-14 rounded-[20px] px-6 py-7 sm:px-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div><span class="text-xs font-black uppercase tracking-[.2em] text-[#ff8a4d]">Track your comfort food</span><h2 id="orders-title" class="font-display mt-2 text-2xl">Pesanan terakhir</h2><p class="mt-1 text-sm text-[#a9b1c1]">Pantau status masakanmu dari dapur sampai meja.</p></div>
            <button id="refresh-orders" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 self-start rounded-xl bg-white/10 px-4 py-2.5 text-sm font-black transition duration-200 hover:bg-white/15 sm:self-center" aria-label="Muat ulang daftar pesanan"><svg class="refresh-icon h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v6h6M20 20v-6h-6M5.5 9a8 8 0 0 1 13-2.5M18.5 15a8 8 0 0 1-13 2.5"/></svg><span>Refresh</span></button>
        </div>
        <div id="orders-list" class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3" aria-live="polite"><p class="text-sm text-[#a9b1c1]">Memuat pesanan kamu...</p></div>
    </section>

    <!-- 9. FOOTER -->
    <footer class="glass mt-14 rounded-[20px] px-6 py-10 sm:px-10" aria-label="Informasi WARMINDO SMOKY">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div><p class="font-display text-lg">WARMINDO SMOKY</p><p class="mt-1 text-[10px] font-bold uppercase tracking-[.22em] text-[#ffc61a]">{{ $warung['sub'] ?? 'BONTANG HITZ' }}</p><p class="mt-3 max-w-xs text-sm leading-6 text-[#a9b1c1]">Comfort food smoky buat nemenin tiap cerita.</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ $warung['instagram'] ?? '#' }}" target="_blank" rel="noopener" aria-label="Instagram WM SMOKY" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 transition duration-200 hover:border-[#ff6a00]"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1" fill="currentColor"/></svg></a>
                    <a href="{{ $warung['tiktok'] ?? '#' }}" target="_blank" rel="noopener" aria-label="TikTok WM SMOKY" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 transition duration-200 hover:border-[#ff6a00]"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18V6l10-2v12M9 18a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm10-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/></svg></a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" aria-label="WhatsApp WM SMOKY" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 transition duration-200 hover:border-[#ff6a00]"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 0 1-16 5.6L3 21l3.6-1.8A9 9 0 1 1 21 12Zm-8 4c-.5 0-3-1.5-3.5-2.5-.4-.8 0-1.2.5-2l1-1c.6.4 1.2 1.2 1 1.7l1.5.7c.6.3 1.7-.6 2-1.2l1 1c.3.6-.3 2.3-3.5 3.3Z"/></svg></a>
                </div>
            </div>
            <div><p class="text-xs font-black uppercase tracking-[.18em] text-[#ffc61a]">Jam buka</p><p class="mt-3 text-sm leading-6">Senin – Minggu<br>{{ $warung['open_time'] ?? '19:00' }} – {{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}</p></div>
            <div><p class="text-xs font-black uppercase tracking-[.18em] text-[#ffc61a]">Alamat &amp; kontak</p><p class="mt-3 text-sm leading-6">{{ $warung['address'] ?? '' }}<br>{{ $warung['phone_display'] ?? '' }}<br>{{ $warung['email'] ?? '' }}</p></div>
            <div><p class="text-xs font-black uppercase tracking-[.18em] text-[#ffc61a]">Link cepat</p><nav class="mt-3 flex flex-col gap-1 text-sm font-bold" aria-label="Link cepat"><a href="#menu" class="rounded-lg px-1 py-2.5 transition hover:text-[#ff8a4d]">Menu</a><a href="#paket" class="rounded-lg px-1 py-2.5 transition hover:text-[#ff8a4d]">Paket</a><a href="#lokasi" class="rounded-lg px-1 py-2.5 transition hover:text-[#ff8a4d]">Lokasi</a></nav></div>
        </div>
        <div class="mt-8 flex flex-col gap-2 border-t border-white/10 pt-5 text-xs text-[#a9b1c1] sm:flex-row sm:items-center sm:justify-between"><p>© 2026 WARMINDO SMOKY. Built for Gen Z vibe.</p><p id="year"></p></div>
    </footer>
</main>

<!-- CART DRAWER -->
<aside id="cart-drawer" class="cart-drawer fixed right-0 top-0 z-50 flex h-full w-full max-w-md flex-col border-l border-white/10 bg-[#0d0f14]" role="dialog" aria-modal="true" aria-label="Keranjang belanja">
    <div class="flex items-center justify-between border-b border-white/10 px-6 py-5"><div><p class="text-xs font-black uppercase tracking-[.18em] text-[#ff8a4d]">Keranjang kamu</p><h2 class="font-display mt-1 text-2xl">Siap checkout?</h2></div><button id="close-cart" class="grid h-11 w-11 place-items-center rounded-xl bg-white/5 text-2xl transition duration-200 hover:bg-white/10" aria-label="Tutup keranjang">×</button></div>
    <div id="cart-items" class="flex-1 overflow-y-auto px-6 py-5"></div>
    <div class="border-t border-white/10 bg-white/[.03] px-6 py-5"><label class="mb-3 block"><span class="mb-2 block text-sm font-bold">Catatan (opsional)</span><textarea id="cart-note" rows="2" class="glass w-full rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-[#ff6a00]" placeholder="Contoh: es sedikit, sambal dipisah..."></textarea></label><div class="mb-4 flex justify-between text-sm"><span class="text-[#a9b1c1]">Subtotal</span><strong id="cart-total" class="text-xl text-[#ffc61a]">Rp 0</strong></div><button id="checkout-button" class="btn-grad min-h-11 w-full px-5 py-4 font-black text-white disabled:cursor-not-allowed disabled:opacity-40">Lanjut checkout</button></div>
</aside>

<!-- CUSTOM MODAL -->
<div id="custom-modal" class="modal fixed inset-0 z-[60] grid place-items-center bg-black/70 p-5 backdrop-blur-sm" role="dialog" aria-modal="true" aria-label="Custom menu">
    <div class="glass w-full max-w-lg rounded-[20px] p-6"><div class="flex items-center gap-4"><img id="custom-img" src="{{ $placeholder }}" alt="Foto menu" class="h-20 w-20 rounded-2xl object-cover"><div class="min-w-0"><h3 id="custom-title" class="font-display truncate text-xl"></h3><p id="custom-price" class="font-black text-[#ffc61a]"></p></div><button id="custom-close" class="ml-auto grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white/5 text-2xl" aria-label="Tutup custom menu">×</button></div>
    <div class="mt-6"><p class="mb-2 text-sm font-bold">Level pedas:</p><div id="custom-spice" class="grid grid-cols-5 gap-2" role="group" aria-label="Level pedas"></div></div>
    <div class="mt-5"><p class="mb-2 text-sm font-bold">Topping tambahan:</p><div id="custom-toppings" class="space-y-2"></div></div>
    <label class="mt-5 block"><span class="mb-2 block text-sm font-bold">Catatan (opsional)</span><input id="custom-note" class="glass w-full rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-[#ff6a00]" placeholder="Contoh: tanpa daun bawang"></label>
    <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-4"><div><span class="text-xs text-[#a9b1c1]">Total:</span><p id="custom-subtotal" class="font-display text-xl">Rp 0</p></div><button id="custom-confirm" class="btn-grad min-h-11 px-6 py-3 text-sm font-black text-white">Tambahkan</button></div></div>
</div>

<!-- CHECKOUT MODAL -->
<div id="checkout-modal" class="modal fixed inset-0 z-[60] grid place-items-center bg-black/70 p-5 backdrop-blur-sm" role="dialog" aria-modal="true" aria-label="Konfirmasi pesanan">
    <div class="glass w-full max-w-md rounded-[20px] p-6 sm:p-8"><div class="flex items-start justify-between"><div><span class="text-xs font-black uppercase tracking-[.18em] text-[#ff8a4d]">Satu langkah lagi</span><h2 class="font-display mt-2 text-2xl">Konfirmasi pesanan</h2></div><button id="close-modal" class="grid h-11 w-11 place-items-center rounded-xl text-2xl text-[#a9b1c1] transition duration-200 hover:bg-white/5" aria-label="Tutup konfirmasi pesanan">×</button></div>
    <form id="checkout-form" class="mt-6 space-y-4"><label class="block"><span class="mb-2 block text-sm font-bold">Metode pembayaran</span><select id="payment-method" class="glass min-h-11 w-full rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-[#ff6a00]" required><option value="" disabled selected>Memuat metode pembayaran...</option></select></label><div id="payment-guide" class="rounded-xl bg-white/5 p-3 text-sm leading-6 text-[#a9b1c1]">Pilih metode pembayaran untuk melihat langkah selanjutnya.</div><label class="block"><span class="mb-2 block text-sm font-bold">Catatan (opsional)</span><textarea id="order-notes" rows="3" class="glass w-full rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-[#ff6a00]" placeholder="Contoh: tidak pedas, sambal dipisah..."></textarea></label><div id="checkout-error" class="hidden rounded-xl border border-red-400/30 bg-red-500/10 p-3 text-sm font-bold text-red-200"></div><button class="btn-grad min-h-11 w-full px-5 py-4 font-black text-white" type="submit">Buat pesanan <span id="checkout-total-label"></span></button></form></div>
</div>

<div id="toast" class="toast fixed bottom-20 left-1/2 z-[70] rounded-full bg-white px-5 py-3 text-sm font-bold text-black shadow-xl sm:bottom-7" role="status">Pesanan berhasil ditambahkan</div>

<nav class="fixed inset-x-0 bottom-0 z-30 border-t border-white/10 bg-[#0d0f14]/95 px-4 py-2 backdrop-blur-xl sm:hidden" aria-label="Navigasi bawah">
    <div class="mx-auto grid max-w-md grid-cols-4 gap-1 text-center text-[10px] font-black text-[#a9b1c1]">
        <a href="#menu" class="rounded-xl px-2 py-2.5" aria-label="Ke katalog menu">Menu</a>
        <a href="#paket" class="rounded-xl px-2 py-2.5" aria-label="Ke paket hemat">Paket</a>
        <button type="button" id="mobile-cart-button" class="relative rounded-xl bg-white/10 px-2 py-2.5 text-white" aria-label="Buka keranjang">Keranjang<span id="mobile-cart-count" class="absolute -right-1 -top-1 hidden min-w-5 rounded-full px-1 py-0.5 text-[10px] text-white" style="background:var(--grad)"></span></button>
        <a href="#orders" class="rounded-xl px-2 py-2.5" aria-label="Ke pesanan saya">Pesanan</a>
    </div>
</nav>

<script>
const initialProducts=@json($catalog);
const initialBundles=@json($bundlesData);
const PLACEHOLDER=@json($placeholder);
const WARUNG={open:@json($warung['open_time'] ?? '19:00'),close:@json($warung['close_time'] ?? '00:00'),tz:@json($warung['timezone_label'] ?? 'WITA'),toppings:@json($warung['toppings'] ?? []),spices:@json($warung['spice_levels'] ?? [])};
const state={products:initialProducts.map(norm),bundles:initialBundles,cart:migrateCart(),filter:'all',query:'',menuStatus:'loading',custom:null};
const rupiah=v=>new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v||0);
const esc=v=>String(v??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[c]));
const CAT_LABEL={mie:'Mie Dok-Dok',indomie:'Indomie Custom',rice:'Rice Bowl',snack:'Snack',drink:'Es Kekinian',nasi:'Nasi',minum:'Minuman'};
function norm(p){return{id:Number(p.id),name:p.name??'',price:Number(p.price??p.harga??0),category:String(p.category||'mie').toLowerCase(),description:p.description||'Racikan hangat favorit yang dibuat fresh saat dipesan.',image:p.image||null,stock:Number(p.stock??0),available:p.available!==false,rating:Number(p.rating??5).toFixed(1),spice:Number(p.spice_level??p.spice??0),best:!!(p.is_best_seller??p.best)}}
function migrateCart(){try{const raw=JSON.parse(localStorage.getItem('wm-smoky-cart')||'[]');return raw.map(x=>({key:x.key||('p-'+x.id+'--'),kind:x.kind||'product',id:Number(x.id),name:x.name,price:Number(x.price||0),image:x.image||null,quantity:Number(x.quantity||1),spice:x.spice||null,toppings:x.toppings||[],note:x.note||''}))}catch(e){return[]}}
function save(){localStorage.setItem('wm-smoky-cart',JSON.stringify(state.cart))}
function toast(m){const el=document.getElementById('toast');el.textContent=m;el.classList.add('show');setTimeout(()=>el.classList.remove('show'),2600)}
function cartKey(l){return l.kind==='bundle'?'b-'+l.id+'-'+(l.spice||''):'p-'+l.id+'-'+(l.spice||'')+'-'+(l.toppings||[]).join('|')}
function qtyInCart(id,kind){kind=kind||'product';const plainKey=(kind==='bundle'?'b-':'p-')+id+'--';const l=state.cart.find(x=>x.key===plainKey);return l?l.quantity:0}
function totalQtyInCart(id,kind){kind=kind||'product';return state.cart.filter(x=>x.kind===kind&&Number(x.id)===Number(id)).reduce((s,x)=>s+x.quantity,0)}
const statusStyle=s=>({Menunggu:'bg-amber-400/15 text-amber-200',Pending:'bg-amber-400/15 text-amber-200',Diproses:'bg-blue-400/15 text-blue-200',Siap:'bg-violet-400/15 text-violet-200',Selesai:'bg-green-400/15 text-green-200',Dibatalkan:'bg-red-400/15 text-red-200',Batal:'bg-red-400/15 text-red-200'}[s]||'bg-white/10 text-white');

// OPEN STATUS
function updateOpenStatus(){const el=document.getElementById('open-status');if(!el)return;const now=new Date();const hm=String(now.getHours()).padStart(2,'0')+':'+String(now.getMinutes()).padStart(2,'0');const toM=t=>{const[a,b]=t.split(':').map(Number);return a*60+b};const cur=toM(hm),o=toM(WARUNG.open),c=toM(WARUNG.close);let open=c<o?(cur>=o||cur<c):(cur>=o&&cur<c);el.innerHTML=open?`<span class="h-2 w-2 rounded-full bg-[#1fc38a]" aria-hidden="true"></span>BUKA SEKARANG (${esc(WARUNG.open)} – ${esc(WARUNG.close)} ${esc(WARUNG.tz)})`:`<span class="h-2 w-2 rounded-full bg-red-400" aria-hidden="true"></span>TUTUP · buka ${esc(WARUNG.open)} ${esc(WARUNG.tz)}`}

// MENU
function photoHTML(p,cls){cls=cls||'menu-photo';if(p.image)return `<img src="${esc(p.image)}" alt="${esc(p.name)}" loading="lazy" class="${cls}" onerror="this.onerror=null;this.src='${PLACEHOLDER}'">`;return `<img src="${PLACEHOLDER}" alt="Ilustrasi ${esc(p.name)}" loading="lazy" class="${cls}">`}
function spiceHTML(p){if(!p.spice)return '';return `<span class="inline-flex items-center gap-1 rounded-full bg-[#ff6a00]/15 px-2 py-1 text-[10px] font-black text-[#ff8a4d]"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 4-6 6.5-6 11a6 6 0 0 0 12 0c0-4.5-3-7-6-11Z"/></svg>Lvl ${p.spice}</span>`}
function actionHTML(p){
    if(p.available===false)return `<span class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-black text-[#a9b1c1]">Habis</span>`;
    const q=qtyInCart(p.id,'product');
    let h=q>0?`<div class="flex items-center gap-2" role="group" aria-label="Ubah jumlah ${esc(p.name)}"><button data-dec="${p.id}" class="grid h-11 w-11 place-items-center rounded-xl bg-white/10 text-xl font-black transition duration-200 hover:bg-white/15" aria-label="Kurangi ${esc(p.name)}">−</button><span class="w-5 text-center text-sm font-black" aria-live="polite">${q}</span><button data-inc="${p.id}" class="grid h-11 w-11 place-items-center rounded-xl text-xl font-black text-white" style="background:var(--grad)" aria-label="Tambah ${esc(p.name)}">+</button></div>`:`<button data-add="${p.id}" class="min-h-11 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-black transition duration-200 hover:text-white" style="--tw:none" onmouseover="this.style.background='linear-gradient(135deg,#ff6a00,#ff3d2e)'" onmouseout="this.style.background=''" aria-label="Tambah ${esc(p.name)} ke keranjang">+ Tambah</button>`;
    return `<div class="flex items-center gap-2">${h}<button data-custom="${p.id}" class="min-h-11 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-bold text-[#a9b1c1] transition duration-200 hover:border-[#ff6a00] hover:text-white" aria-label="Custom ${esc(p.name)}">Custom</button></div>`;
}
function updateMenuChrome(hasItems){
    const hasCatalog=state.products.length>0;
    const search=document.getElementById('search'),filters=document.getElementById('filters');
    search.disabled=!hasCatalog;filters.querySelectorAll('.filter-btn').forEach(b=>{b.disabled=!hasCatalog});
    document.getElementById('search-wrap').style.opacity=hasCatalog?'1':'.55';filters.style.opacity=hasCatalog?'1':'.55';
    const err=state.menuStatus==='error';
    document.getElementById('menu-error').classList.toggle('hidden',!err);
    document.getElementById('empty-state').classList.toggle('hidden',err||hasItems);
    document.getElementById('menu-grid').classList.toggle('hidden',err||!hasItems);
    document.getElementById('menu-skeleton').classList.toggle('hidden',state.menuStatus!=='loading');
}
function renderMenu(){
    const grid=document.getElementById('menu-grid');
    const q=state.query.trim().toLowerCase();
    const list=state.products.filter(p=>(state.filter==='all'||p.category===state.filter)&&(!q||p.name.toLowerCase().includes(q)||(p.description||'').toLowerCase().includes(q)));
    if(state.menuStatus!=='error')state.menuStatus=list.length||state.products.length?'ready':'empty';
    updateMenuChrome(list.length>0);
    if(!list.length){grid.innerHTML='';if(state.products.length&&state.menuStatus==='ready'){grid.classList.remove('hidden');document.getElementById('empty-state').classList.add('hidden');document.getElementById('menu-error').classList.add('hidden');grid.innerHTML=`<div class="glass col-span-full rounded-[20px] px-6 py-12 text-center"><h3 class="text-lg font-black">Menu tidak ditemukan.</h3><p class="mt-1 text-sm text-[#a9b1c1]">Coba kata kunci atau kategori lain.</p></div>`}return}
    grid.innerHTML=list.map((p,i)=>{
        const soldOut=p.available===false;
        return `<article class="menu-card glass rise overflow-hidden" style="animation-delay:${Math.min(i*60,420)}ms">
        <div class="relative m-3 overflow-hidden rounded-2xl bg-white/5">${photoHTML(p)}
            <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-black/60 px-2.5 py-1 text-[10px] font-black text-white backdrop-blur"><svg class="h-3 w-3 text-[#ffc61a]" viewBox="0 0 20 20" fill="currentColor"><path d="M10 1.5 12.6 7l6 .4-4.6 3.8 1.5 5.8L10 13.7 4.5 17l1.5-5.8L1.4 7.4l6-.4L10 1.5Z"/></svg>${esc(p.rating)}</span>
            <span class="absolute right-3 top-3 rounded-full ${soldOut?'bg-gray-600':'bg-black/60'} px-2.5 py-1 text-[10px] font-black uppercase text-white backdrop-blur">${soldOut?'Habis':esc(CAT_LABEL[p.category]||p.category)}</span></div>
        <div class="p-5 pt-2"><div class="flex items-start justify-between gap-2"><h3 class="leading-tight">${esc(p.name)}</h3>${p.best?'<span class="shrink-0 rounded-full px-2 py-1 text-[10px] font-black text-white" style="background:var(--grad)">Best seller</span>':''}</div>
        <div class="mt-2 flex gap-2">${spiceHTML(p)}</div>
        <p class="clamp-2 mt-2 min-h-10 text-[13px] leading-5 text-[#a9b1c1]">${esc(p.description)}</p>
        <div class="mt-4 flex min-h-11 flex-wrap items-center justify-between gap-2"><strong class="text-lg text-[#ffc61a]">${rupiah(p.price)}</strong>${actionHTML(p)}</div></div></article>`;
    }).join('');
    grid.querySelectorAll('[data-add]').forEach(b=>b.addEventListener('click',()=>addPlain(Number(b.dataset.add))));
    grid.querySelectorAll('[data-inc]').forEach(b=>b.addEventListener('click',()=>addPlain(Number(b.dataset.inc))));
    grid.querySelectorAll('[data-dec]').forEach(b=>b.addEventListener('click',()=>decProduct(Number(b.dataset.dec))));
    grid.querySelectorAll('[data-custom]').forEach(b=>b.addEventListener('click',()=>openCustom(Number(b.dataset.custom))));
    renderBest();
}
function addPlain(id){const p=state.products.find(x=>Number(x.id)===id);if(!p||p.available===false){toast('Stok menu ini sedang habis');return}const key='p-'+p.id+'--';let line=state.cart.find(x=>x.key===key);line?line.quantity++:state.cart.push({key,kind:'product',id:p.id,name:p.name,price:p.price,image:p.image,quantity:1,spice:null,toppings:[],note:''});save();renderCart();renderMenu();toast(`${p.name} masuk keranjang`)}
function decProduct(id){const key='p-'+id+'--';const line=state.cart.find(x=>x.key===key);if(!line)return;line.quantity--;if(line.quantity<=0)state.cart=state.cart.filter(x=>x.key!==key);save();renderCart();renderMenu()}
function renderBest(){const best=state.products.find(p=>p.best&&p.available!==false)||state.products.find(p=>p.available!==false);const n=document.getElementById('hero-best-name'),pr=document.getElementById('hero-best-price'),btn=document.getElementById('hero-best-add'),hi=document.getElementById('hero-img');if(!best||!n)return;n.textContent=best.name;pr.textContent=rupiah(best.price);if(hi&&best.image){hi.src=best.image;hi.alt=best.name;hi.onerror=function(){this.onerror=null;this.src=PLACEHOLDER}}btn.disabled=false;btn.setAttribute('aria-label',`Tambah ${best.name} ke keranjang`);btn.onclick=()=>addPlain(best.id)}

// BUNDLES
function renderBundles(){
    const grid=document.getElementById('bundles-grid');if(!grid)return;
    if(!state.bundles.length){grid.innerHTML=`<div class="glass col-span-full rounded-[20px] p-8 text-center text-sm text-[#a9b1c1]">Paket hemat segera hadir.</div>`;return}
    const maxD=Math.max(...state.bundles.map(b=>b.discount_percent||0));
    const sub=document.getElementById('bundles-subtitle');if(sub&&maxD>0)sub.textContent=`Hemat sampai ${maxD}%`;
    grid.innerHTML=state.bundles.map(b=>`
    <div class="glass flex flex-col rounded-[20px] p-6 ${b.is_popular?'border-2 border-[#ff6a00] shadow-[0_8px_40px_rgba(255,106,0,.2)]':''} transition duration-200 hover:-translate-y-1">
        ${b.is_popular?'<span class="mb-3 self-start rounded-full px-3 py-1 text-[10px] font-black uppercase text-white" style="background:var(--grad)">Most Popular</span>':''}
        <div class="flex items-start justify-between gap-3"><span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-[#a9b1c1]">${esc(b.badge||'Paket')}</span>${b.discount_percent?`<span class="rounded-full bg-[#1fc38a]/15 px-3 py-1 text-xs font-black text-[#1fc38a]">-${b.discount_percent}%</span>`:''}</div>
        <h3 class="font-display mt-3 text-xl">${esc(b.name)}</h3>
        <p class="mt-1 text-xs leading-5 text-[#a9b1c1]">${esc(b.description||'')}</p>
        <p class="mt-4"><span class="font-display text-2xl text-[#ffc61a]">${rupiah(b.price)}</span>${b.original_price?` <s class="text-sm text-[#a9b1c1]">${rupiah(b.original_price)}</s>`:''}</p>
        <button data-bundle="${b.id}" class="${b.is_popular?'btn-grad text-white':'border border-white/10 bg-white/5 hover:border-[#ff6a00]'} mt-5 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-black transition duration-200">Pesan Paket Ini</button>
    </div>`).join('');
    grid.querySelectorAll('[data-bundle]').forEach(x=>x.addEventListener('click',()=>addBundle(Number(x.dataset.bundle))));
}
function addBundle(id){const b=state.bundles.find(x=>Number(x.id)===id);if(!b)return;const key='b-'+b.id+'-';let line=state.cart.find(x=>x.key===key);line?line.quantity++:state.cart.push({key,kind:'bundle',id:b.id,name:b.name,price:b.price,image:null,quantity:1,spice:null,toppings:[],note:b.description||''});save();renderCart();toast(`${b.name} masuk keranjang`);cart(true)}

// CUSTOM MODAL
function openCustom(id){const p=state.products.find(x=>Number(x.id)===id);if(!p||p.available===false){toast('Stok menu ini sedang habis');return}state.custom={product:p,spice:0,toppings:new Set(),note:''};document.getElementById('custom-title').textContent=p.name;document.getElementById('custom-price').textContent=rupiah(p.price);const img=document.getElementById('custom-img');img.src=p.image||PLACEHOLDER;img.alt=p.name;img.onerror=function(){this.onerror=null;this.src=PLACEHOLDER};document.getElementById('custom-note').value='';renderCustomOpts();updateCustomTotal();document.getElementById('custom-modal').classList.add('is-open');document.getElementById('scrim').classList.add('is-open')}
function closeCustom(){document.getElementById('custom-modal').classList.remove('is-open');if(!document.getElementById('cart-drawer').classList.contains('is-open'))document.getElementById('scrim').classList.remove('is-open');state.custom=null}
function renderCustomOpts(){const c=state.custom;if(!c)return;document.getElementById('custom-spice').innerHTML=WARUNG.spices.map((s,i)=>`<button data-spice="${i}" aria-pressed="${i===c.spice}" class="spice-btn min-h-11 rounded-xl border border-white/10 bg-white/5 px-2 py-2 text-xs font-bold transition duration-200">${esc(s)}</button>`).join('');document.getElementById('custom-toppings').innerHTML=WARUNG.toppings.map((t,i)=>`<label class="flex cursor-pointer items-center justify-between rounded-xl border border-white/10 bg-white/5 p-3 transition duration-200 hover:border-[#ff6a00]/50"><span class="text-xs font-bold">${esc(t.name)} (+${rupiah(t.price)})</span><input type="checkbox" data-topping="${i}" class="h-5 w-5 accent-[#ff6a00]" ${c.toppings.has(i)?'checked':''}></label>`).join('');
document.querySelectorAll('#custom-spice [data-spice]').forEach(b=>b.addEventListener('click',()=>{state.custom.spice=Number(b.dataset.spice);renderCustomOpts();updateCustomTotal()}));
document.querySelectorAll('#custom-toppings [data-topping]').forEach(ch=>ch.addEventListener('change',()=>{const i=Number(ch.dataset.topping);ch.checked?state.custom.toppings.add(i):state.custom.toppings.delete(i);updateCustomTotal()}))}
function customTotal(){const c=state.custom;if(!c)return 0;let t=c.product.price;[...c.toppings].forEach(i=>t+=Number(WARUNG.toppings[i]?.price||0));return t}
function updateCustomTotal(){document.getElementById('custom-subtotal').textContent=rupiah(customTotal())}
function confirmCustom(){const c=state.custom;if(!c)return;const tops=[...c.toppings].map(i=>WARUNG.toppings[i]?.name).filter(Boolean);const topsPrice=[...c.toppings].reduce((s,i)=>s+Number(WARUNG.toppings[i]?.price||0),0);const unit=c.product.price+topsPrice;const spiceName=WARUNG.spices[c.spice]||null;const note=document.getElementById('custom-note').value.trim();const key='p-'+c.product.id+'-'+(spiceName||'')+'-'+tops.join('|')+'-'+note;let line=state.cart.find(x=>x.key===key);line?line.quantity++:state.cart.push({key,kind:'product',id:c.product.id,name:c.product.name,price:unit,image:c.product.image,quantity:1,spice:spiceName,toppings:tops,note});save();renderCart();closeCustom();renderMenu();toast(`${c.product.name} (custom) masuk keranjang`)}

// CART
function renderCart(){
    const wrap=document.getElementById('cart-items');
    const total=state.cart.reduce((s,x)=>s+Number(x.price||0)*x.quantity,0);
    const count=state.cart.reduce((s,x)=>s+x.quantity,0);
    document.getElementById('cart-count').textContent=count;
    const mc=document.getElementById('mobile-cart-count');if(mc){mc.textContent=count;mc.classList.toggle('hidden',count===0)}
    document.getElementById('cart-total').textContent=rupiah(total);
    document.getElementById('checkout-total-label').textContent=total?`• ${rupiah(total)}`:'';
    document.getElementById('checkout-button').disabled=!state.cart.length;
    wrap.innerHTML=state.cart.length?state.cart.map(x=>`<div class="glass mb-3 flex items-center gap-3 rounded-2xl p-3"><div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-white/5">${x.image?`<img src="${esc(x.image)}" alt="${esc(x.name)}" loading="lazy" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='${PLACEHOLDER}'">`:`<img src="${PLACEHOLDER}" alt="Ilustrasi ${esc(x.name)}" loading="lazy" class="h-full w-full object-cover">`}</div><div class="min-w-0 flex-1"><p class="truncate text-sm font-black">${esc(x.name)}${x.kind==='bundle'?' <span class="text-[10px] text-[#ffc61a]">PAKET</span>':''}</p>${x.spice?`<p class="text-[11px] text-[#ff8a4d]">${esc(x.spice)}</p>`:''}${(x.toppings||[]).length?`<p class="truncate text-[11px] text-[#a9b1c1]">+ ${esc(x.toppings.join(', '))}</p>`:''}${x.note?`<p class="truncate text-[11px] italic text-[#a9b1c1]">“${esc(x.note)}”</p>`:''}<p class="mt-1 text-xs font-bold text-[#ffc61a]">${rupiah(x.price)}</p></div><div class="flex items-center gap-1"><button data-minus="${esc(x.key)}" class="grid h-11 w-11 place-items-center rounded-lg bg-white/10 font-black" aria-label="Kurangi ${esc(x.name)}">−</button><span class="w-4 text-center text-sm font-black">${x.quantity}</span><button data-plus="${esc(x.key)}" class="grid h-11 w-11 place-items-center rounded-lg text-white" style="background:var(--grad)" aria-label="Tambah ${esc(x.name)}">+</button></div><button data-remove="${esc(x.key)}" class="grid h-11 w-11 shrink-0 place-items-center rounded-lg text-lg text-red-300 transition duration-200 hover:bg-white/5" aria-label="Hapus ${esc(x.name)} dari keranjang">×</button></div>`).join(''):'<div class="grid h-full place-items-center text-center"><div><p class="mt-4 font-black">Keranjang masih kosong</p><p class="mt-1 text-sm text-[#a9b1c1]">Pilih comfort food favoritmu dulu.</p></div></div>';
    wrap.querySelectorAll('[data-minus]').forEach(b=>b.addEventListener('click',()=>changeLine(b.dataset.minus,-1)));
    wrap.querySelectorAll('[data-plus]').forEach(b=>b.addEventListener('click',()=>changeLine(b.dataset.plus,1)));
    wrap.querySelectorAll('[data-remove]').forEach(b=>b.addEventListener('click',()=>{state.cart=state.cart.filter(x=>x.key!==b.dataset.remove);save();renderCart();renderMenu();toast('Item dihapus dari keranjang')}));
}
function changeLine(key,d){const l=state.cart.find(x=>x.key===key);if(!l)return;l.quantity+=d;if(l.quantity<=0)state.cart=state.cart.filter(x=>x.key!==key);save();renderCart();renderMenu()}
function cart(o=true){document.getElementById('cart-drawer').classList.toggle('is-open',o);document.getElementById('scrim').classList.toggle('is-open',o)}
function modal(o=true){document.getElementById('checkout-modal').classList.toggle('is-open',o);document.getElementById('scrim').classList.toggle('is-open',o)}

// ORDERS
function setOrdersLoading(l){const b=document.getElementById('refresh-orders');if(!b)return;b.disabled=l;b.classList.toggle('is-loading',l);b.setAttribute('aria-busy',String(l));const s=b.querySelector('span');if(s)s.textContent=l?'Memuat...':'Refresh'}
function orderCard(o){
    const steps=['Menunggu','Diproses','Siap','Selesai'];
    const cancelled=['Dibatalkan','Batal'].includes(o.status);
    const idx=steps.indexOf(o.status==='Pending'?'Menunggu':o.status);
    const items=(o.items||[]).map(i=>{let opt='';try{const p=typeof i.options==='string'?JSON.parse(i.options):i.options;const bits=[];if(p&&p.spice)bits.push(p.spice);if(p&&p.toppings&&p.toppings.length)bits.push('+ '+p.toppings.join(', '));if(p&&p.note)bits.push('“'+p.note+'”');if(bits.length)opt=' ('+bits.join(' · ')+')'}catch(e){}return `${i.product_name} ×${i.quantity}${opt}`});
    const itemText=items.length?(items.slice(0,3).join(', ')+(items.length>3?` +${items.length-3} lainnya`:'')):'-';
    const stepper=cancelled?`<p class="mt-3 text-xs font-bold text-red-300">Pesanan dibatalkan. Hubungi kasir bila butuh bantuan.</p>`:`<div class="mt-3 flex gap-1.5" aria-label="Progres pesanan: ${esc(o.status)}">${steps.map((s,i)=>`<span class="step-dot h-2 flex-1 ${i<idx?'done':i===idx?'current':''}" title="${s}"></span>`).join('')}</div><p class="mt-2 text-[11px] font-bold text-[#a9b1c1]">${idx>=0?`Tahap ${idx+1} dari 4: ${esc(o.status)}`:`Status: ${esc(o.status)}`}</p>`;
    return `<div class="rounded-2xl bg-white/5 p-4"><div class="flex items-center justify-between gap-2"><strong class="truncate text-sm">${esc(o.order_code)}</strong><span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-black uppercase ${statusStyle(o.status)}">${esc(o.status)}</span></div><p class="mt-2 text-xs leading-5 text-[#a9b1c1]">${esc(itemText)}</p><p class="mt-2 text-sm font-black text-[#ffc61a]">${rupiah(o.total)}</p>${stepper}</div>`;
}
function ordersEmpty(m){return `<div class="col-span-full flex flex-col items-center rounded-2xl bg-white/5 px-6 py-10 text-center"><p class="text-sm font-black">Belum ada pesanan</p><p class="mt-1 max-w-xs text-[13px] leading-5 text-[#a9b1c1]">${m}</p><a href="#menu" class="btn-grad mt-4 inline-flex min-h-11 items-center rounded-xl px-5 py-2.5 text-sm font-black text-white">Pesan sekarang</a></div>`}

// API
async function loadProducts(){
    state.menuStatus='loading';updateMenuChrome(false);
    try{const r=await fetch('/api/products',{headers:{Accept:'application/json'}});if(!r.ok)throw new Error('http '+r.status);const j=await r.json();
        if(Array.isArray(j.data)&&j.data.length){state.products=j.data.map(norm);state.menuStatus='ready'}
        else if(state.products.length){state.menuStatus='ready'}else{state.products=[];state.menuStatus='empty'}
        renderMenu()}catch(e){state.menuStatus='error';updateMenuChrome(false)}
}
async function loadBundles(){try{const r=await fetch('/api/bundles',{headers:{Accept:'application/json'}});if(!r.ok)throw new Error('x');const j=await r.json();if(Array.isArray(j.data)&&j.data.length)state.bundles=j.data;renderBundles()}catch(e){renderBundles()}}
function paymentGuide(){const el=document.getElementById('payment-method'),v=(el.value||'').toLowerCase(),g=document.getElementById('payment-guide');g.textContent=v.includes('qris')?'Tampilkan QRIS di kasir setelah pesanan dibuat. Simpan kode pesanan kamu.':v.includes('transfer')?'Transfer setelah pesanan dibuat. Admin/kasir akan mengonfirmasi pembayaran.':v.includes('tunai')?'Bayar tunai di kasir. Tunjukkan kode pesanan setelah checkout.':'Ikuti instruksi kasir setelah pesanan dibuat.'}
async function loadPaymentMethods(){const s=document.getElementById('payment-method');try{const r=await fetch('/api/payment-methods',{headers:{Accept:'application/json'}});if(!r.ok)throw new Error('x');const j=await r.json(),m=j.data||[];s.innerHTML=m.length?'<option value="" disabled selected>Pilih metode pembayaran</option>'+m.map(x=>`<option value="${esc(x.name)}">${esc(x.name)}</option>`).join(''):'<option value="" disabled selected>Metode pembayaran belum tersedia</option>';s.disabled=!m.length;paymentGuide()}catch(e){s.innerHTML='<option value="" disabled selected>Metode pembayaran belum tersedia, coba lagi nanti</option>';s.disabled=true}}
async function orders(){const list=document.getElementById('orders-list');setOrdersLoading(true);try{const r=await fetch('/api/orders',{headers:{Accept:'application/json'}});if(!r.ok)throw new Error('x');const j=await r.json(),items=j.data?.data||[];list.innerHTML=items.length?items.slice(0,3).map(orderCard).join(''):ordersEmpty('Makan pertama hari ini dimulai dari sini.')}catch(e){list.innerHTML=ordersEmpty('Belum bisa memuat pesanan. Periksa koneksi lalu tekan Refresh.')}finally{setOrdersLoading(false)}}

// NAV
const menuBtn=document.getElementById('user-menu-button'),menuEl=document.getElementById('user-menu');
if(menuBtn&&menuEl){const setM=o=>{menuEl.classList.toggle('hidden',!o);menuBtn.setAttribute('aria-expanded',String(o))};menuBtn.addEventListener('click',e=>{e.stopPropagation();setM(menuEl.classList.contains('hidden'))});document.addEventListener('click',e=>{if(!document.getElementById('user-menu-wrap').contains(e.target))setM(false)});document.addEventListener('keydown',e=>{if(e.key==='Escape'){setM(false);cart(false);modal(false);closeCustom()}})}
const navToggle=document.getElementById('nav-toggle'),mobileNav=document.getElementById('mobile-nav');
navToggle.addEventListener('click',()=>{const open=mobileNav.classList.toggle('hidden')===false;navToggle.setAttribute('aria-expanded',String(open))});
mobileNav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{mobileNav.classList.add('hidden');navToggle.setAttribute('aria-expanded','false')}));
const navLinks=[...document.querySelectorAll('[data-nav]')];
const secMap={beranda:'beranda',menu:'menu',paket:'paket',vibe:'lokasi',lokasi:'lokasi',testimoni:'testimoni',orders:'orders'};
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){const key=secMap[e.target.id]||e.target.id;navLinks.forEach(l=>l.classList.toggle('is-active',l.dataset.nav===key||(key==='lokasi'&&l.dataset.nav==='lokasi')))}}),{rootMargin:'-40% 0px -55% 0px'});
['beranda','menu','paket','vibe','lokasi','testimoni','orders'].forEach(id=>{const s=document.getElementById(id);if(s)io.observe(s)});

// EVENTS
let searchTimer=null;
document.getElementById('filters').addEventListener('click',e=>{const b=e.target.closest('[data-filter]');if(!b||b.disabled)return;state.filter=b.dataset.filter;document.querySelectorAll('.filter-btn').forEach(x=>{const on=x===b;x.setAttribute('aria-pressed',String(on));x.classList.toggle('text-white',on);x.classList.toggle('bg-white/5',!on)});renderMenu()});
document.getElementById('search').addEventListener('input',e=>{if(e.target.disabled)return;clearTimeout(searchTimer);searchTimer=setTimeout(()=>{state.query=e.target.value;renderMenu()},300)});
document.getElementById('cart-button').addEventListener('click',()=>cart(true));
document.getElementById('mobile-cart-button').addEventListener('click',()=>cart(true));
document.getElementById('close-cart').addEventListener('click',()=>cart(false));
document.getElementById('scrim').addEventListener('click',()=>{cart(false);modal(false);closeCustom()});
document.getElementById('checkout-button').addEventListener('click',()=>{if(!state.cart.length)return;const cn=document.getElementById('cart-note').value.trim();const on=document.getElementById('order-notes');if(cn&&!on.value)on.value=cn;cart(false);modal(true)});
document.getElementById('close-modal').addEventListener('click',()=>modal(false));
document.getElementById('custom-close').addEventListener('click',closeCustom);
document.getElementById('custom-confirm').addEventListener('click',confirmCustom);
document.getElementById('orders-button').addEventListener('click',e=>{e.preventDefault();document.getElementById('orders').scrollIntoView({behavior:'smooth'})});
document.getElementById('refresh-orders').addEventListener('click',()=>{orders().then(()=>toast('Pesanan diperbarui'))});
document.getElementById('payment-method').addEventListener('change',paymentGuide);
document.getElementById('reload-menu').addEventListener('click',e=>{const b=e.currentTarget;b.classList.add('is-loading');loadProducts().finally(()=>b.classList.remove('is-loading'))});
document.getElementById('retry-menu').addEventListener('click',loadProducts);
document.getElementById('map-frame').addEventListener('error',()=>{document.getElementById('map-fallback').classList.remove('hidden');document.getElementById('map-fallback').classList.add('flex')});
setInterval(()=>{if(!document.hidden&&!document.querySelector('#orders-list .is-loading'))orders().catch(()=>{})},60000);
document.getElementById('year').textContent=new Date().getFullYear();

document.getElementById('checkout-form').addEventListener('submit',async e=>{e.preventDefault();const box=document.getElementById('checkout-error');box.classList.add('hidden');
if(!document.getElementById('payment-method').value){box.textContent='Pilih metode pembayaran dulu ya.';box.classList.remove('hidden');return}
try{const r=await fetch('/api/orders',{method:'POST',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({payment_method:document.getElementById('payment-method').value,notes:document.getElementById('order-notes').value||document.getElementById('cart-note').value,items:state.cart.map(x=>x.kind==='bundle'?{item_type:'bundle',bundle_id:x.id,quantity:x.quantity}:{item_type:'product',product_id:x.id,quantity:x.quantity,unit_price:x.price,options:{spice:x.spice,toppings:x.toppings||[],note:x.note||''}})}});const j=await r.json();if(!r.ok)throw new Error(j.message||'Pesanan belum bisa diproses, coba lagi ya.');state.cart=[];save();renderCart();renderMenu();modal(false);document.getElementById('order-notes').value='';document.getElementById('cart-note').value='';toast(`Pesanan ${j.data.order_code} berhasil dibuat`);orders()}catch(err){box.textContent=err.message||'Pesanan belum bisa diproses, coba lagi ya.';box.classList.remove('hidden')}});
updateOpenStatus();setInterval(updateOpenStatus,60000);
renderMenu();renderCart();renderBundles();loadProducts();loadBundles();loadPaymentMethods();orders();
</script>
</body>
</html>
