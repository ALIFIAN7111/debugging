@extends('layouts.warmindo')

@section('title', 'Dashboard Member — Warmindo Smoky')
@section('meta_desc', 'Dashboard member Warmindo Smoky: live antrian, katalog checkout, pembayaran QRIS/Bank/Tunai, struk digital, WiFi.')

@push('head')
<style>
  .light-page{background:#FFF6E9;color:#26190F;border-radius:28px;margin-top:18px;border:1px solid #F3DFBE;box-shadow:0 24px 80px rgba(60,30,0,.12)}
  .light-page .lp-wrap{max-width:1200px;margin-inline:auto;padding:22px 18px 34px}
  @media(min-width:640px){.light-page .lp-wrap{padding:30px 32px 44px}}
  .lp-eyebrow{display:inline-flex;align-items:center;gap:.5rem;background:#26190F;color:#FFC61A;font-size:11px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;padding:.5rem .9rem;border-radius:999px}
  .lp-h1{font-size:clamp(1.7rem,3.4vw,2.6rem);line-height:1.08;font-weight:800;letter-spacing:-.02em;margin:.9rem 0 0}
  .lp-sub{color:#7A6450;margin-top:.5rem;max-width:38rem}
  .lp-grid-top{display:grid;gap:14px;margin-top:20px}
  @media(min-width:960px){.lp-grid-top{grid-template-columns:1.35fr .9fr .9fr}}
  .lp-card{background:#fff;border:1px solid #F0DCC0;border-radius:20px;padding:18px;box-shadow:0 10px 30px rgba(120,70,0,.07)}
  .lp-card h2{font-size:1rem;font-weight:800;display:flex;align-items:center;gap:.55rem;margin:0}
  .lp-card h2 i{width:34px;height:34px;display:grid;place-items:center;border-radius:11px;background:linear-gradient(135deg,#ff6b00,#ffb700);color:#fff;flex:none}
  .lp-queue-no{font-size:2.6rem;font-weight:800;letter-spacing:-.03em;line-height:1;margin:.4rem 0}
  .lp-pill{display:inline-flex;align-items:center;gap:.4rem;font-size:12px;font-weight:800;padding:.4rem .75rem;border-radius:999px;background:#FFF1D6;border:1px solid #F0D0A0;color:#8A4B00}
  .lp-pill.dot::before{content:"";width:8px;height:8px;border-radius:99px;background:#ff6b00;box-shadow:0 0 0 5px rgba(255,107,0,.18)}
  .lp-steps{display:flex;gap:6px;margin-top:12px}
  .lp-steps span{height:9px;flex:1;border-radius:99px;background:#F1E2CB}
  .lp-btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;min-height:44px;border-radius:13px;font-weight:800;padding:.75rem 1.1rem;cursor:pointer;border:1px solid transparent;transition:.18s}
  .lp-primary{background:linear-gradient(135deg,#ff6b00,#ffb700);color:#1d1206;box-shadow:0 12px 28px rgba(255,107,0,.3)}
  .lp-primary:hover{transform:translateY(-2px);filter:brightness(1.04)}
  .lp-primary:disabled{opacity:.6;transform:none;cursor:wait}
  .lp-secondary{background:#fff;border-color:#EAD3AF;color:#26190F}
  .lp-secondary:hover{border-color:#ff6b00}
  .lp-history{display:grid;gap:8px;margin-top:12px}
  @media(min-width:560px){.lp-history{grid-template-columns:1fr 1fr}}
  .lp-hist{background:#FFFBF2;border:1px solid #F0DCC0;border-radius:14px;padding:10px 12px;font-size:13px}
  .lp-wifi-code{background:#26190F;color:#FFD88A;border-radius:14px;padding:14px;text-align:center}
  .lp-main{display:grid;gap:18px;margin-top:22px}
  @media(min-width:1024px){.lp-main{grid-template-columns:minmax(0,1fr) 360px;align-items:start}}
  .lp-toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-top:14px}
  .lp-search{flex:1;min-width:200px;display:flex;align-items:center;gap:.6rem;background:#fff;border:1px solid #EAD3AF;border-radius:13px;padding:0 .9rem}
  .lp-search input{border:0;outline:0;background:transparent;min-height:44px;width:100%;color:#26190F;font-weight:600}
  .lp-chips{display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;margin-top:12px}
  .lp-chip{flex:none;min-height:44px;padding:.6rem 1rem;border-radius:999px;border:1px solid #EAD3AF;background:#fff;font-weight:700;color:#7A6450;cursor:pointer;font-size:13px}
  .lp-chip[aria-pressed="true"]{background:#26190F;color:#FFC61A;border-color:#26190F}
  .lp-menu-grid{display:grid;gap:12px;margin-top:14px}
  @media(min-width:560px){.lp-menu-grid{grid-template-columns:1fr 1fr}}
  @media(min-width:1280px){.lp-menu-grid{grid-template-columns:1fr 1fr 1fr}}
  .lp-menu{background:#fff;border:1px solid #F0DCC0;border-radius:18px;overflow:hidden;display:flex;flex-direction:column}
  .lp-menu-img{height:132px;background:#FFE9C7 center/cover;position:relative}
  .lp-menu-img.noimg{display:grid;place-items:center;font-size:2rem;background:linear-gradient(135deg,#FFE3B8,#FFC98A)}
  .lp-badge{position:absolute;top:10px;left:10px;display:flex;gap:6px}
  .lp-badge span{font-size:11px;font-weight:800;padding:.32rem .6rem;border-radius:999px}
  .b-best{background:#26190F;color:#FFC61A}.b-habis{background:#B42318;color:#fff}.b-rate{background:rgba(255,255,255,.94);color:#26190F}
  .lp-menu-body{padding:13px 14px 14px;display:flex;flex-direction:column;gap:6px;flex:1}
  .lp-menu-body h3{margin:0;font-size:.98rem;line-height:1.3}
  .lp-meta{font-size:12px;color:#8A735C;display:flex;flex-wrap:wrap;gap:8px}
  .lp-price-row{margin-top:auto;display:flex;align-items:center;justify-content:space-between;gap:8px;padding-top:8px}
  .lp-price{font-weight:800;font-size:1.02rem}
  .lp-step{display:inline-flex;align-items:center;gap:8px}
  .lp-step button{width:44px;height:44px;border-radius:12px;border:1px solid #EAD3AF;background:#fff;font-size:1.2rem;font-weight:800;cursor:pointer}
  .lp-step button.add{background:linear-gradient(135deg,#ff6b00,#ffb700);border-color:transparent}
  .lp-bundle{border:1px dashed #E0A83F;background:#FFFEF7;border-radius:18px;padding:14px}
  .lp-cart{position:sticky;top:84px}
  .lp-cart-item{display:flex;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px dashed #F0DCC0;font-size:13.5px}
  .lp-pay label{display:flex;gap:10px;align-items:flex-start;border:1px solid #EAD3AF;border-radius:14px;padding:11px 12px;cursor:pointer;background:#fff}
  .lp-pay input{width:20px;height:20px;margin-top:2px;accent-color:#ff6b00}
  .lp-pay label:has(input:checked){border-color:#ff6b00;box-shadow:0 0 0 3px rgba(255,107,0,.15)}
  .lp-total{display:flex;justify-content:space-between;align-items:center;margin-top:12px;padding-top:12px;border-top:2px solid #26190F;font-weight:800;font-size:1.1rem}
  .lp-err{display:none;background:#FEE4E2;border:1px solid #FECDC9;color:#912018;border-radius:12px;padding:.7rem .9rem;font-size:13px;font-weight:700;margin-top:10px}
  .lp-err.show{display:block}
  .lp-toast{position:fixed;left:50%;bottom:90px;transform:translateX(-50%) translateY(20px);background:#26190F;color:#FFE9C7;padding:.8rem 1.1rem;border-radius:999px;font-weight:700;font-size:13px;opacity:0;pointer-events:none;transition:.25s;z-index:80;box-shadow:0 18px 50px rgba(0,0,0,.3)}
  .lp-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
  .lp-mobilebar{position:sticky;bottom:12px;z-index:30;margin-top:14px}
  @media(min-width:1024px){.lp-mobilebar{display:none}}
  .lp-mobilebar-inner{background:#26190F;color:#fff;border-radius:16px;padding:10px;display:flex;align-items:center;justify-content:space-between;gap:10px;box-shadow:0 18px 50px rgba(0,0,0,.3)}
  @media print{
    body *{visibility:hidden !important}
    #struk-wrap, #struk-wrap *{visibility:visible !important}
    #struk-wrap{position:static !important;background:#fff !important;display:block !important}
  }
</style>
@endpush

@section('content')
@php
    $warung = $warung ?? config('warung');
    $menus = collect($products ?? [])->map(fn ($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'price' => (float) ($p->harga ?? 0),
        'category' => strtolower($p->category ?? 'mie'),
        'desc' => $p->description ?? 'Dimasak fresh, aroma smoky.',
        'stock' => (int) ($p->stock ?? 99),
        'available' => (bool) ($p->is_available ?? true),
        'rating' => (float) ($p->rating ?? 5.0),
        'spice' => (int) ($p->spice_level ?? 0),
        'best' => (bool) ($p->is_best_seller ?? false),
        'image' => $p->image ? asset($p->image) : null,
    ])->values();
    $pakets = collect($bundles ?? [])->map(fn ($b) => [
        'id' => $b->id,
        'name' => $b->name,
        'price' => (float) $b->price,
        'original' => $b->original_price !== null ? (float) $b->original_price : null,
        'desc' => $b->description ?? 'Paket hemat nongkrong.',
        'badge' => $b->badge ?? 'Hemat',
        'popular' => (bool) ($b->is_popular ?? false),
        'image' => $b->image ? asset($b->image) : null,
        'off' => ($b->original_price ?? 0) > ($b->price ?? 0) ? (int) round((1 - ((float) $b->price / (float) $b->original_price)) * 100) : 0,
    ])->values();
    $memberName = ($user->name ?? auth()->user()->name ?? 'Anak Smoky');
@endphp

<div class="wrap">
<div class="light-page">
<div class="lp-wrap">

    <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start">
        <div>
            <span class="lp-eyebrow"><i class="fa-solid fa-gauge-high"></i> Dashboard member</span>
            <h1 class="lp-h1">Halo, {{ $memberName }}!<br>Laper apa malam ini?</h1>
            <p class="lp-sub">Pesan dari HP, pantau antrian live, bayar QRIS / transfer / tunai. Struk digital keluar otomatis.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('home') }}" class="lp-btn lp-secondary"><i class="fa-solid fa-house"></i> Landing</a>
            <a href="{{ route('profile.edit') }}" class="lp-btn lp-secondary"><i class="fa-solid fa-user-gear"></i> Profil</a>
        </div>
    </div>

    {{-- QUEUE + HISTORY + WIFI --}}
    <div class="lp-grid-top">
        <div class="lp-card" aria-live="polite">
            <div style="display:flex;justify-content:space-between;gap:10px;align-items:center">
                <h2><i class="fa-solid fa-bell-concierge"></i> Live Queue Tracker</h2>
                <button id="btn-refresh" class="lp-btn lp-secondary" style="min-height:44px;padding:.55rem .9rem;font-size:13px" onclick="loadOrders()"><i class="fa-solid fa-rotate"></i> Refresh</button>
            </div>
            <div style="margin-top:12px;background:#FFFBF2;border:1px dashed #E0A83F;border-radius:16px;padding:16px;text-align:center">
                <p style="margin:0;font-size:11px;font-weight:800;letter-spacing:.16em;color:#8A735C">NOMOR ANTRIAN KAMU</p>
                <p id="queue-no" class="lp-queue-no">—</p>
                <p style="margin:0"><span id="queue-status" class="lp-pill dot">Memuat pesanan...</span></p>
                <div id="queue-steps" class="lp-steps" aria-label="Progres pesanan"></div>
                <p id="queue-items" style="margin:10px 0 0;font-size:12.5px;color:#7A6450"></p>
                <p id="queue-meta" style="margin:6px 0 0;font-size:12px;color:#8A735C"></p>
            </div>
            <div id="history" class="lp-history"></div>
        </div>

        <div class="lp-card">
            <h2><i class="fa-solid fa-clock"></i> Estimasi & Info</h2>
            <div style="margin-top:12px;display:grid;gap:10px;font-size:13.5px">
                <div style="display:flex;justify-content:space-between"><span>Jam buka</span><strong>{{ $warung['open_time'] ?? '19:00' }}–{{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}</strong></div>
                <div style="display:flex;justify-content:space-between"><span>Antrean dapur</span><strong id="queue-count">—</strong></div>
                <div style="display:flex;justify-content:space-between"><span>Estimasi masak</span><strong>±10–15 mnt</strong></div>
                <a class="lp-btn lp-secondary" style="font-size:13px" target="_blank" rel="noopener" href="{{ $warung['maps_link'] ?? route('home') }}"><i class="fa-solid fa-location-dot"></i> {{ Str::limit($warung['address'] ?? 'Bontang', 42) }}</a>
                <p style="margin:0;font-size:12px;color:#8A735C">Auto-refresh tiap 15 detik. Tunjukkan kode <strong>ORD-...</strong> ke kasir untuk bayar / ambil.</p>
            </div>
        </div>

        <aside class="lp-card" aria-label="WiFi member">
            <h2><i class="fa-solid fa-wifi"></i> WiFi Nongkrong</h2>
            <div class="lp-wifi-code" style="margin-top:12px">
                <p style="margin:0;font-size:11px;letter-spacing:.16em;color:#C9B79E">SSID</p>
                <p style="margin:2px 0 0;font-weight:800;font-size:1.1rem">{{ config('warung.wifi_ssid') }}</p>
                <p style="margin:10px 0 0;font-size:11px;letter-spacing:.16em;color:#C9B79E">PASSWORD</p>
                <p style="margin:4px 0 0;display:flex;align-items:center;justify-content:center;gap:8px;font-weight:800;font-size:1.05rem">
                    <span id="wifi-pw" data-pw="{{ config('warung.wifi_password') }}">••••••••</span>
                    <button onclick="toggleWifi(this)" aria-label="Lihat password WiFi" style="width:44px;height:44px;border-radius:11px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;cursor:pointer"><i class="fa-solid fa-eye"></i></button>
                    <button onclick="copyWifi()" aria-label="Salin password WiFi" style="width:44px;height:44px;border-radius:11px;border:0;background:linear-gradient(135deg,#ff6b00,#ffb700);cursor:pointer"><i class="fa-solid fa-copy"></i></button>
                </p>
                <p style="margin:10px 0 0;font-size:11.5px;color:#C9B79E">100 Mbps • ganti tiap minggu • tanya kasir kalau gagal</p>
            </div>
        </aside>
    </div>

    {{-- PAKET HEMAT --}}
    @if($pakets->count())
    <div class="lp-card" style="margin-top:16px">
        <div style="display:flex;justify-content:space-between;gap:10px;align-items:center;flex-wrap:wrap">
            <h2><i class="fa-solid fa-box-open"></i> Paket Nongkrong Hemat</h2>
            <span class="lp-pill">Hemat sampai {{ $pakets->max('off') }}%</span>
        </div>
        <div id="bundles-grid" style="margin-top:12px;display:grid;gap:10px">
            @foreach($pakets as $b)
            <div class="lp-bundle" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;{{ $b['popular'] ? 'border-style:solid;border-color:#ff6b00;box-shadow:0 10px 30px rgba(255,107,0,.18)' : '' }}">
                @if(!empty($b['image']))
                <img src="{{ $b['image'] }}" alt="{{ $b['name'] }}" loading="lazy" style="width:84px;height:84px;object-fit:cover;border-radius:14px;flex:none">
                @else
                <div style="width:84px;height:84px;flex:none;display:grid;place-items:center;text-align:center;font-size:11px;font-weight:700;color:#8A735C;background:#FFF1D6;border:1px dashed #E0A83F;border-radius:14px;padding:6px">Foto menyusul</div>
                @endif
                <div style="min-width:220px;flex:1">
                    <p style="margin:0;display:flex;gap:8px;align-items:center;flex-wrap:wrap"><strong>{{ $b['name'] }}</strong>
                    @if($b['popular'])<span class="lp-pill">Most Popular</span>@endif
                    @if($b['off'])<span class="lp-pill">-{{ $b['off'] }}%</span>@endif</p>
                    <p style="margin:4px 0 0;font-size:13px;color:#7A6450">{{ $b['desc'] }}</p>
                    <p style="margin:6px 0 0"><strong style="font-size:1.1rem">Rp {{ number_format($b['price'],0,',','.') }}</strong>
                    @if($b['original']) <s style="color:#A68F78;font-size:13px">Rp {{ number_format($b['original'],0,',','.') }}</s>@endif</p>
                </div>
                <button class="lp-btn lp-primary" onclick="addBundle({{ $b['id'] }})"><i class="fa-solid fa-plus"></i> Ambil Paket</button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- KATALOG + CHECKOUT --}}
    <div class="lp-main" id="menu">
        <div>
            <h2 style="margin:0;font-size:1.4rem;font-weight:800">Katalog & Checkout</h2>
            <p style="margin:4px 0 0;font-size:13px;color:#7A6450">{{ $menus->count() }} menu aktif • harga warung, bukan harga mall.</p>
            <div class="lp-toolbar">
                <label class="lp-search"><i class="fa-solid fa-magnifying-glass" style="color:#B89B7E"></i><input id="q" placeholder="Cari mie, nasi, kopi..." oninput="renderMenu()" aria-label="Cari menu"></label>
                <select id="sort" class="lp-chip" onchange="renderMenu()" aria-label="Urutkan" style="flex:none">
                    <option value="pop">Paling laris</option>
                    <option value="cheap">Termurah</option>
                    <option value="rate">Rating tertinggi</option>
                </select>
            </div>
            <div class="lp-chips" role="group" aria-label="Filter kategori">
                <button class="lp-chip" data-cat="all" aria-pressed="true" onclick="setCat('all',this)">Semua</button>
                <button class="lp-chip" data-cat="mie" aria-pressed="false" onclick="setCat('mie',this)">Mie & Indomie</button>
                <button class="lp-chip" data-cat="nasi" aria-pressed="false" onclick="setCat('nasi',this)">Nasi / Rice Bowl</button>
                <button class="lp-chip" data-cat="snack" aria-pressed="false" onclick="setCat('snack',this)">Snack</button>
                <button class="lp-chip" data-cat="minum" aria-pressed="false" onclick="setCat('minum',this)">Minuman</button>
            </div>
            <div id="grid" class="lp-menu-grid" aria-live="polite"></div>

            <div class="lp-mobilebar"><div class="lp-mobilebar-inner">
                <div><div id="m-total" style="font-weight:800">Rp 0</div><div id="m-count" style="font-size:12px;color:#FFD88A">0 item</div></div>
                <a href="#checkout-card" class="lp-btn lp-primary">Lihat Keranjang <i class="fa-solid fa-arrow-down"></i></a>
            </div></div>
        </div>

        <aside class="lp-card lp-cart" id="checkout-card" aria-label="Checkout">
            <h2><i class="fa-solid fa-cart-shopping"></i> Keranjang (<span id="cart-n">0</span>)</h2>
            <div id="cart-items" style="margin-top:8px"><p style="color:#8A735C;font-size:13.5px">Kosong. Tambah menu dulu, jangan cuma lihat.</p></div>
            <label style="display:block;margin-top:10px;font-size:13px;font-weight:800">Catatan dapur
                <input id="notes" placeholder="Sambal pisah, es sedikit..." style="margin-top:6px;width:100%;min-height:44px;border-radius:12px;border:1px solid #EAD3AF;padding:.7rem .9rem">
            </label>

            <h3 style="margin:14px 0 0;font-size:.95rem">Pembayaran</h3>
            <div id="pay-list" class="lp-pay" style="margin-top:8px;display:grid;gap:8px;font-size:13.5px">
                <label><input type="radio" name="pay" value="QRIS" checked><span><strong>QRIS</strong><br><span style="color:#7A6450">Scan di kasir • instan</span></span><i class="fa-solid fa-qrcode" style="margin-left:auto;color:#ff6b00;font-size:1.2rem"></i></label>
                <label><input type="radio" name="pay" value="Transfer Bank"><span><strong>Transfer Bank</strong><br><span style="color:#7A6450">BCA / BRI / Mandiri</span></span><i class="fa-solid fa-building-columns" style="margin-left:auto;font-size:1.2rem"></i></label>
                <label><input type="radio" name="pay" value="Tunai"><span><strong>Tunai di kasir</strong><br><span style="color:#7A6450">Bayar sambil tunjukkan kode</span></span><i class="fa-solid fa-money-bill-wave" style="margin-left:auto;font-size:1.2rem"></i></label>
            </div>
            <p id="pay-guide" style="margin:8px 0 0;background:#FFFBF2;border:1px solid #F0DCC0;border-radius:12px;padding:.7rem .9rem;font-size:12.5px;color:#7A6450">QRIS: checkout dulu, tampilkan kode pesanan ke kasir lalu scan untuk bayar.</p>

            <div class="lp-total"><span>Total</span><span id="cart-total">Rp 0</span></div>
            <div id="checkout-err" class="lp-err" role="alert"></div>
            <button id="btn-checkout" class="lp-btn lp-primary" style="width:100%;margin-top:10px" onclick="checkout()"><i class="fa-solid fa-receipt"></i> Buat Pesanan</button>
            <button class="lp-btn lp-secondary" style="width:100%;margin-top:8px;font-size:13px" onclick="clearCart()">Kosongkan</button>
            <p style="margin:8px 0 0;font-size:11.5px;color:#8A735C">Dengan checkout kamu setuju dimasakin dengan cinta + api besar.</p>
        </aside>
    </div>

</div>
</div>
</div>

{{-- STRUK THERMAL --}}
<div id="struk-wrap" style="position:fixed;inset:0;z-index:60;display:none;place-items:center;background:rgba(20,10,0,.65);padding:20px" role="dialog" aria-modal="true" aria-label="Struk digital">
    <div style="width:100%;max-width:320px;background:#fff;color:#111;padding:20px;text-align:center;font-family:ui-monospace,Menlo,monospace;font-size:12px;border-radius:6px">
        <p style="margin:0;font-weight:800;font-size:14px">WARMINDO SMOKY</p>
        <p style="margin:2px 0 0">{{ $warung['address'] ?? 'Bontang' }}</p>
        <p style="margin:0">{{ $warung['phone_display'] ?? '' }}</p>
        <p style="margin:8px 0">--------------------------------</p>
        <p id="s-code" style="margin:0;font-weight:800;font-size:15px">ORD-...</p>
        <p id="s-date" style="margin:2px 0 0"></p>
        <p style="margin:8px 0">--------------------------------</p>
        <div id="s-items" style="text-align:left"></div>
        <p style="margin:8px 0">--------------------------------</p>
        <p style="display:flex;justify-content:space-between;font-weight:800;font-size:14px;margin:0"><span>TOTAL</span><span id="s-total"></span></p>
        <p style="display:flex;justify-content:space-between;margin:4px 0 0"><span>Bayar</span><span id="s-pay"></span></p>
        <p id="s-note" style="margin:6px 0 0"></p>
        <p style="margin:8px 0">--------------------------------</p>
        <p style="margin:0">* Tunjukkan ke kasir *</p>
        <p style="margin:2px 0 0">WiFi: WMSMOKY-5G</p>
        <div style="margin-top:12px;display:grid;grid-template-columns:1fr 1fr;gap:8px;font-family:Poppins,sans-serif">
            <button class="lp-btn lp-secondary" style="font-size:12px" onclick="closeStruk()">Tutup</button>
            <button class="lp-btn lp-primary" style="font-size:12px" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak</button>
        </div>
    </div>
</div>

<div id="toast" class="lp-toast" role="status"></div>
@endsection

@push('scripts')
<script>
const MENUS = @json($menus);
const PAKETS = @json($pakets);
const rupiah = v => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v||0);
const esc = s => String(s??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[c]));
let cat = 'all', cart = [];
try{ cart = JSON.parse(localStorage.getItem('wms-cart')||'[]'); if(!Array.isArray(cart)) cart=[]; }catch(e){ cart = []; }

function toast(msg){ const t=document.getElementById('toast'); t.textContent=msg; t.classList.add('show'); clearTimeout(t._h); t._h=setTimeout(()=>t.classList.remove('show'),2200); }
function setCat(c,btn){ cat=c; document.querySelectorAll('[data-cat]').forEach(b=>b.setAttribute('aria-pressed',String(b===btn))); renderMenu(); }
function matchCat(m,c){
  if(c==='all') return true;
  const n=((m.name||'')+' '+(m.category||'')).toLowerCase();
  if(c==='minum') return /teh|kopi|minum|jeruk|es|susu|drink|red velvet|matcha/i.test(n);
  if(c==='nasi') return /nasi|ayam|rice|bowl/i.test(n);
  if(c==='snack') return /dimsum|fries|snack|sempol|cireng|kulit/i.test(n);
  if(c==='mie') return /mie|indomie|dok-dok|nyemek/i.test(n);
  return true;
}
function spiceIcon(n){ n=+n||0; if(!n) return 'Tidak pedas'; return '🌶'.repeat(Math.min(n,3))+' Lv.'+n; }
function renderMenu(){
    const q=(document.getElementById('q').value||'').toLowerCase();
    const sort=document.getElementById('sort').value;
    let list=MENUS.filter(m=>(!q||(m.name+' '+(m.desc||'')).toLowerCase().includes(q))&&matchCat(m,cat));
    if(sort==='cheap') list=[...list].sort((a,b)=>a.price-b.price);
    else if(sort==='rate') list=[...list].sort((a,b)=>b.rating-a.rating);
    else list=[...list].sort((a,b)=>(b.best-a.best)||(b.rating-a.rating));
    const grid=document.getElementById('grid');
    grid.innerHTML=list.length?list.map(m=>{
        const key='p'+m.id, line=cart.find(x=>x.key===key), qty=line?.qty||0;
        const sold=m.available===false||m.stock<=0;
        const img=m.image?`<div class="lp-menu-img" style="background-image:url('${esc(m.image)}')"><div class="lp-badge">${m.best?'<span class="b-best">★ Best Seller</span>':''}${sold?'<span class="b-habis">Habis</span>':`<span class="b-rate">★ ${Number(m.rating||5).toFixed(1)}</span>`}</div></div>`
          :`<div class="lp-menu-img noimg">🍜<div class="lp-badge">${m.best?'<span class="b-best">★ Best Seller</span>':''}${sold?'<span class="b-habis">Habis</span>':''}</div></div>`;
        return `<article class="lp-menu">${img}<div class="lp-menu-body">
          <h3>${esc(m.name)}</h3>
          <p style="margin:0;font-size:12.5px;color:#8A735C">${esc(m.desc||'')}</p>
          <p class="lp-meta"><span>★ ${Number(m.rating||5).toFixed(1)}</span><span>• ${esc(spiceIcon(m.spice))}</span></p>
          <div class="lp-price-row"><span class="lp-price">${rupiah(m.price)}</span>
          ${sold?'<span style="font-size:12px;font-weight:800;color:#B42318">Habis</span>':qty>0
            ?`<span class="lp-step"><button onclick="dec('${key}')" aria-label="Kurangi">−</button><b>${qty}</b><button class="add" onclick="inc('${key}')" aria-label="Tambah">+</button></span>`
            :`<button class="lp-btn lp-primary" style="min-height:44px;padding:.6rem 1rem;font-size:13px" onclick="inc('${key}')">+ Tambah</button>`}</div>
        </div></article>`;
    }).join(''):'<p class="lp-card" style="grid-column:1/-1;text-align:center;color:#8A735C">Menu tidak ketemu. Coba kata lain.</p>';
}
function save(){ localStorage.setItem('wms-cart',JSON.stringify(cart)); }
function findMenu(key){
  if(key[0]==='b'){ const b=PAKETS.find(x=>'b'+x.id===key); return b?{key,name:b.name,price:b.price}:null; }
  const m=MENUS.find(x=>'p'+x.id===key); return m?{key,name:m.name,price:m.price}:null;
}
function inc(key){ const m=findMenu(key); if(!m) return; const l=cart.find(x=>x.key===key); l?l.qty=Math.min(l.qty+1,20):cart.push({key: key, kind: key[0]==='b'?'bundle':'product', id: parseInt(key.slice(1)), name:m.name, price:m.price, qty:1}); save(); renderMenu(); renderCart(); }
function dec(key){ const l=cart.find(x=>x.key===key); if(!l)return; l.qty--; if(l.qty<=0) cart=cart.filter(x=>x.key!==key); save(); renderMenu(); renderCart(); }
function addBundle(id){ inc('b'+id); toast('Paket masuk keranjang!'); document.getElementById('checkout-card').scrollIntoView({behavior:'smooth',block:'nearest'}); }
function clearCart(){ cart=[]; save(); renderMenu(); renderCart(); }
function cartTotals(){ return { n: cart.reduce((s,x)=>s+x.qty,0), total: cart.reduce((s,x)=>s+x.price*x.qty,0) }; }
function renderCart(){
    const {n,total}=cartTotals();
    document.getElementById('cart-n').textContent=n;
    document.getElementById('cart-total').textContent=rupiah(total);
    document.getElementById('m-total').textContent=rupiah(total);
    document.getElementById('m-count').textContent=n+' item';
    document.getElementById('cart-items').innerHTML=cart.length?cart.map(x=>`<div class="lp-cart-item">
      <span><strong>${esc(x.name)}</strong><br><span style="color:#8A735C">${rupiah(x.price)} × ${x.qty}</span><br>
      <span style="display:inline-flex;gap:6px;margin-top:6px"><button onclick="dec('${x.key}')" aria-label="Kurangi" style="width:36px;height:36px;border-radius:10px;border:1px solid #EAD3AF;background:#fff;cursor:pointer">−</button><button onclick="inc('${x.key}')" aria-label="Tambah" style="width:36px;height:36px;border-radius:10px;border:0;background:#26190F;color:#FFC61A;cursor:pointer">+</button></span></span>
      <strong>${rupiah(x.price*x.qty)}</strong></div>`).join('')
      :'<p style="color:#8A735C;font-size:13.5px">Kosong. Tambah menu dulu, jangan cuma lihat.</p>';
}
document.querySelectorAll('input[name="pay"]').forEach(r=>r.addEventListener('change',e=>{
    const v=e.target.value.toLowerCase(), g=document.getElementById('pay-guide');
    g.textContent=v.includes('qris')?'QRIS: checkout dulu, tampilkan kode pesanan ke kasir lalu scan untuk bayar.':v.includes('transfer')||v.includes('bank')?'Transfer: ke rekening yang ditempel di kasir, tunjukkan bukti + kode pesanan.':'Tunai: bayar tunai di kasir sambil tunjukkan kode pesanan.';
}));
async function loadPay(){
    try{
        const r=await fetch('/api/payment-methods',{headers:{Accept:'application/json'}});
        if(!r.ok) return; const j=await r.json(), ms=j.data||[];
        if(ms.length){
            const icons={'qris':'fa-qrcode','transfer':'fa-building-columns','tunai':'fa-money-bill-wave','cash':'fa-money-bill-wave','bank':'fa-building-columns'};
            document.getElementById('pay-list').innerHTML=ms.map((m,i)=>{
              const k=Object.keys(icons).find(k=>m.name.toLowerCase().includes(k))||'tunai';
              return `<label><input type="radio" name="pay" value="${esc(m.name)}" ${i===0?'checked':''}><span><strong>${esc(m.name)}</strong><br><span style="color:#7A6450">${i===0?'Paling cepat':'Aktif'}</span></span><i class="fa-solid ${icons[k]}" style="margin-left:auto;color:#ff6b00;font-size:1.2rem"></i></label>`;
            }).join('');
        }
    }catch(e){}
}
const STEPS=['Menunggu','Diproses','Siap','Selesai'];
function normStatus(s){ if(!s) return 'Menunggu'; if(s==='Pending') return 'Menunggu'; if(s==='Dimasak') return 'Diproses'; return s; }
function stepsHTML(status){
    status=normStatus(status);
    if(['Dibatalkan','Batal'].includes(status)) return `<p style="font-size:12px;font-weight:800;color:#B42318">Dibatalkan — hubungi kasir.</p>`;
    let idx=STEPS.indexOf(status); if(idx<0) idx=0;
    return STEPS.map((s,i)=>`<span title="${s}" style="background:${i<idx?'#ff6b00':i===idx?'linear-gradient(135deg,#ff6b00,#ffb700)':'#F1E2CB'}"></span>`).join('');
}
async function loadOrders(){
    const btn=document.getElementById('btn-refresh'); if(btn) btn.disabled=true;
    try{
        const r=await fetch('/api/orders',{headers:{Accept:'application/json'}});
        if(!r.ok) throw 0; const j=await r.json(), items=j.data?.data||[];
        document.getElementById('queue-count').textContent=items.filter(x=>!['Selesai','Batal','Dibatalkan'].includes(x.status)).length+' aktif';
        if(items.length){
            const o=items[0], st=normStatus(o.status);
            document.getElementById('queue-no').textContent=o.order_code;
            document.getElementById('queue-status').textContent='Status: '+st+' • '+o.payment_method;
            document.getElementById('queue-steps').innerHTML=stepsHTML(st);
            document.getElementById('queue-items').textContent=(o.items||[]).map(i=>i.product_name+' ×'+i.quantity).join(', ');
            document.getElementById('queue-meta').textContent=rupiah(o.total)+(o.notes?' • Note: '+o.notes:'');
            document.getElementById('history').innerHTML=items.slice(0,4).map(x=>`<div class="lp-hist"><div style="display:flex;justify-content:space-between;gap:8px"><b>${esc(x.order_code)}</b><span>${esc(normStatus(x.status))}</span></div><p style="margin:4px 0 0;color:#8A735C">${rupiah(x.total)} • ${esc(x.payment_method||'')}</p></div>`).join('');
        } else {
            document.getElementById('queue-no').textContent='—';
            document.getElementById('queue-status').textContent='Belum ada pesanan. Yuk pesan!';
            document.getElementById('queue-steps').innerHTML='';
            document.getElementById('queue-items').textContent='';
            document.getElementById('queue-meta').textContent='';
            document.getElementById('queue-count').textContent='0 aktif';
            document.getElementById('history').innerHTML='<p style="font-size:13px;color:#8A735C">Riwayat muncul setelah checkout. <a href="#menu" style="color:#B45309;font-weight:800">Pesan sekarang</a></p>';
        }
    }catch(e){
        document.getElementById('queue-status').textContent='Gagal memuat. Klik Refresh.';
    }finally{ if(btn) btn.disabled=false; }
}
async function checkout(){
    const err=document.getElementById('checkout-err'); err.classList.remove('show'); err.textContent='';
    if(!cart.length){ err.textContent='Keranjang kosong. Tambah minimal 1 menu.'; err.classList.add('show'); return; }
    const pay=(document.querySelector('input[name="pay"]:checked')||{}).value||'Tunai';
    const btn=document.getElementById('btn-checkout'); btn.disabled=true;
    try{
        const r=await fetch('/api/orders',{method:'POST',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({payment_method:pay,notes:document.getElementById('notes').value,items:cart.map(x=>x.kind==='bundle'?{item_type:'bundle',bundle_id:x.id,quantity:x.qty}:{item_type:'product',product_id:x.id,quantity:x.qty})})});
        const j=await r.json(); if(!r.ok) throw new Error(j.message||Object.values(j.errors||{})[0]?.[0]||'Gagal membuat pesanan.');
        showStruk(j.data,pay); cart=[]; save(); renderMenu(); renderCart(); loadOrders(); toast('Pesanan '+j.data.order_code+' dibuat!');
    }catch(e){ err.textContent=e.message; err.classList.add('show'); }
    finally{ btn.disabled=false; }
}
function showStruk(o,pay){
    document.getElementById('s-code').textContent=o.order_code;
    document.getElementById('s-date').textContent=new Date().toLocaleString('id-ID');
    document.getElementById('s-items').innerHTML=(o.items||[]).map(i=>`<p style="display:flex;justify-content:space-between;gap:8px;margin:2px 0"><span>${esc(i.product_name)} x${i.quantity}</span><span>${rupiah(i.subtotal)}</span></p>`).join('');
    document.getElementById('s-total').textContent=rupiah(o.total);
    document.getElementById('s-pay').textContent=pay;
    document.getElementById('s-note').textContent=o.notes?('Note: '+o.notes):'';
    const w=document.getElementById('struk-wrap'); w.style.display='grid';
}
function closeStruk(){ document.getElementById('struk-wrap').style.display='none'; }
document.getElementById('struk-wrap').addEventListener('click',e=>{ if(e.target.id==='struk-wrap') closeStruk(); });
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeStruk(); });
function toggleWifi(btn){
    const el=document.getElementById('wifi-pw'), hidden=el.textContent.includes('•');
    el.textContent=hidden?el.dataset.pw:'••••••••';
    btn.innerHTML=hidden?'<i class="fa-solid fa-eye-slash"></i>':'<i class="fa-solid fa-eye"></i>';
}
function copyWifi(){ try{navigator.clipboard?.writeText(document.getElementById('wifi-pw').dataset.pw); toast('Password WiFi disalin!');}catch(e){ toast('Gagal menyalin'); } }
renderMenu(); renderCart(); loadPay(); loadOrders(); setInterval(loadOrders,15000);
</script>
@endpush
