<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Warmindo Smoky — Indomie Smoky & Nongkrong Hemat')</title>
    <meta name="description" content="@yield('meta_desc', 'Warmindo Smoky: indomie smoky, paket nongkrong hemat, WiFi kencang. Pesan online, pantau antrian.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{
            --bg:#0d0d0d; --card:#161616; --card2:#1e1e1e; --line:rgba(255,255,255,.09);
            --brand:#ff6b00; --brand2:#ffb700; --grad:linear-gradient(135deg,#ff6b00,#ffb700);
            --text:#f5f1e8; --muted:#b8b0a1; --ok:#22c55e; --radius:18px;
        }
        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{margin:0;background:var(--bg);color:var(--text);font-family:'Poppins',system-ui,sans-serif;overflow-x:clip}
        a{color:inherit}
        :focus-visible{outline:3px solid var(--brand2);outline-offset:2px;border-radius:8px}
        .wrap{max-width:1200px;margin-inline:auto;padding-inline:20px}
        @media(min-width:640px){.wrap{padding-inline:32px}}
        .topbar{position:sticky;top:0;z-index:40;background:rgba(13,13,13,.86);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
        .navlink{display:inline-flex;align-items:center;min-height:44px;padding:8px 14px;border-radius:999px;color:var(--muted);font-weight:600;font-size:.9rem}
        .navlink:hover{color:#fff;background:rgba(255,255,255,.06)}
        .btn-grad{background:var(--grad);color:#1a1000;border:0;border-radius:12px;font-weight:800;min-height:44px;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.8rem 1.4rem;cursor:pointer;transition:transform .18s ease,filter .18s ease}
        .btn-grad:hover{transform:translateY(-2px);filter:brightness(1.06)}
        .btn-ghost{border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);border-radius:12px;min-height:44px;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.8rem 1.2rem;font-weight:600;cursor:pointer}
        .btn-ghost:hover{border-color:var(--brand)}
        .card{background:var(--card);border:1px solid var(--line);border-radius:var(--radius)}
        .chip{border:1px solid var(--line);border-radius:999px;padding:.55rem 1rem;min-height:44px;font-weight:600;background:rgba(255,255,255,.03);color:var(--muted);cursor:pointer}
        .chip[aria-pressed="true"]{background:var(--grad);color:#1a1000;border-color:transparent}
        .field{width:100%;background:#0f0f0f;border:1px solid var(--line);border-radius:12px;color:var(--text);padding:.85rem 1rem;min-height:44px}
        .field:focus{border-color:var(--brand);outline:none}
        select.field option{color:#111}
        section{scroll-margin-top:90px}
        footer a:hover{color:var(--brand2)}
        @media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important}}
    </style>
    @stack('head')
</head>
<body>
    <header class="topbar">
        <div class="wrap flex items-center justify-between gap-2 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl" aria-label="Warmindo Smoky — beranda">
                <span class="grid h-11 w-11 place-items-center rounded-xl text-white" style="background:var(--grad)" aria-hidden="true"><i class="fa-solid fa-fire"></i></span>
                <span><strong class="block leading-tight">WARMINDO SMOKY</strong><small class="block text-[10px] font-bold uppercase tracking-[.22em]" style="color:var(--brand2)">Bontang Hitz</small></span>
            </a>
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                <a class="navlink" href="{{ route('home') }}#menu">Menu</a>
                <a class="navlink" href="{{ route('home') }}#paket">Paket Hemat</a>
                <a class="navlink" href="{{ route('home') }}#ulasan">Ulasan</a>
                <a class="navlink" href="{{ route('home') }}#lokasi">Lokasi</a>
            </nav>
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('member.dashboard') }}" class="btn-ghost !py-2.5 text-sm"><i class="fa-solid fa-gauge-high"></i><span class="hidden sm:inline">Dashboard</span></a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn-ghost !py-2.5 text-sm" type="submit"><i class="fa-solid fa-right-from-bracket"></i><span class="hidden sm:inline">Keluar</span></button></form>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost !py-2.5 text-sm"><i class="fa-solid fa-user"></i> Masuk</a>
                    <a href="{{ route('member.dashboard') }}" class="btn-grad !py-2.5 text-sm">Pesan Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    <main>@yield('content')</main>

    <footer class="mt-16 border-t" style="border-color:var(--line);background:#0a0a0a">
        <div class="wrap grid gap-8 py-10 sm:grid-cols-3">
            <div>
                <p class="font-extrabold">WARMINDO SMOKY</p>
                <p class="mt-2 text-sm" style="color:var(--muted)">Indomie smoky, WiFi kencang, nongkrong hemat sampai malam.</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[.18em]" style="color:var(--brand2)">Jam buka</p>
                <p class="mt-2 text-sm">Senin – Minggu<br>{{ config('warung.open_time', '19:00') }} – {{ config('warung.close_time', '00:00') }} {{ config('warung.timezone_label', 'WITA') }}</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[.18em]" style="color:var(--brand2)">Kontak</p>
                <p class="mt-2 text-sm">{{ config('warung.address', 'Bontang') }}<br>{{ config('warung.phone_display', '') }}</p>
                <p class="mt-3 flex gap-3 text-lg">
                    <a href="{{ config('warung.instagram', '#') }}" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ config('warung.tiktok', '#') }}" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="{{ route('home') }}" aria-label="Beranda"><i class="fa-solid fa-house"></i></a>
                </p>
            </div>
        </div>
        <div class="wrap flex flex-col gap-1 border-t py-5 text-xs sm:flex-row sm:justify-between" style="border-color:var(--line);color:var(--muted)">
            <p>© 2026 Warmindo Smoky.</p>
            <p><a href="{{ route('home') }}">Beranda</a> · <a href="{{ route('login') }}">Login</a> · <a href="{{ route('member.dashboard') }}">Dashboard</a></p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
