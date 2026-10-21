@extends('layouts.warmindo')

@section('title', 'Warmindo Smoky — Buka 19.00-00.00, Nongkrong Hemat Bontang')
@section('meta_desc', 'Warmindo Smoky Bontang: menu foto asli, paket hemat, ulasan pelanggan, lokasi Bontang, buka 19.00-00.00.')

@section('content')
@php
    $warung = $warung ?? config('warung');
    $menus = collect($products ?? [])->map(fn ($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'price' => (float) ($p->harga ?? 0),
        'category' => strtolower($p->category ?? 'mie'),
        'desc' => $p->description ?? 'Dimasak fresh, aroma smoky.',
        'image' => $p->image ? asset($p->image) : null,
    ])->values();
    $pakets = collect($bundles ?? [])->map(fn ($b) => [
        'id' => $b->id,
        'name' => $b->name,
        'price' => (float) $b->price,
        'original' => $b->original_price !== null ? (float) $b->original_price : null,
        'desc' => $b->description,
        'badge' => $b->badge,
        'image' => $b->image ? asset($b->image) : null,
    ])->values();
    $reviewList = collect($reviews ?? [])->map(fn ($r) => [
        'name' => $r->name ?? 'Pelanggan',
        'text' => $r->text ?? '',
        'rating' => (int) ($r->rating ?? 5),
    ])->filter(fn ($r) => trim($r['text']) !== '')->values();
    if ($reviewList->isEmpty()) {
        $reviewList = collect($warung['testimonials'] ?? [])->map(fn ($t) => [
            'name' => $t['name'] ?? 'Pelanggan',
            'text' => $t['text'] ?? '',
            'rating' => 5,
        ])->values();
    }
@endphp

{{-- HERO --}}
<section class="wrap grid items-center gap-10 pt-10 lg:grid-cols-2 lg:pt-16">
    <div>
        <span class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-widest" style="border-color:rgba(255,107,0,.4);background:rgba(255,107,0,.1);color:var(--brand2)"><i class="fa-solid fa-fire"></i> Bontang • Buka 19.00 – 00.00</span>
        <h1 class="mt-5 text-4xl font-extrabold leading-[1.08] sm:text-6xl">Jam 7 Malam Laper?<br><span style="background:var(--grad);-webkit-background-clip:text;background-clip:text;color:transparent">Warmindo Smoky</span> Sudah Buka.</h1>
        <p class="mt-4 max-w-lg" style="color:var(--muted)">Buka tiap hari {{ $warung['open_time'] ?? '19:00' }} – {{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}. Indomie smoky, nasi hangat, es segar. Nongkrong hemat mulai Rp 8 ribuan, WiFi kencang.</p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="#menu" class="btn-grad"><i class="fa-solid fa-bowl-food"></i> Lihat Menu</a>
            <a href="{{ route('member.dashboard') }}" class="btn-ghost"><i class="fa-solid fa-bolt"></i> Pesan Sekarang</a>
        </div>
        <div class="mt-6 flex gap-6 text-sm">
            <div><strong class="text-xl">★ 4.9</strong><br><span style="color:var(--muted)">{{ $reviewList->count() }}+ ulasan pelanggan</span></div>
            <div><strong class="text-xl">15 mnt</strong><br><span style="color:var(--muted)">Rata-rata saji</span></div>
            <div><strong class="text-xl">{{ $menus->count() }}+</strong><br><span style="color:var(--muted)">Menu tersedia</span></div>
        </div>
    </div>
    <div class="card p-4">
        <p class="text-xs font-bold uppercase tracking-widest" style="color:var(--muted)">Menu favorit malam ini</p>
        <div class="mt-3 grid grid-cols-2 gap-3">
            @forelse(collect($products ?? [])->take(4) as $p)
            <div class="overflow-hidden rounded-xl border" style="border-color:var(--line)">
                @if(!empty($p->image))
                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" loading="lazy" class="aspect-square w-full object-cover">
                @else
                <div class="grid aspect-square w-full place-items-center p-3 text-center text-xs" style="background:rgba(255,255,255,.04);color:var(--muted)">Foto menyusul<br>admin bisa upload</div>
                @endif
                <p class="p-2 text-xs font-bold leading-tight">{{ Str::limit($p->name, 32) }}</p>
            </div>
            @empty
            <p class="text-sm" style="color:var(--muted)">Menu segera diisi admin.</p>
            @endforelse
        </div>
        <a href="#menu" class="btn-grad mt-4 w-full text-sm">Lihat Semua Menu <i class="fa-solid fa-arrow-right"></i></a>
    </div>
</section>

{{-- KATALOG --}}
<section id="menu" class="wrap pt-16">
    <p class="text-xs font-bold uppercase tracking-[.2em]" style="color:var(--brand2)">{{ $catalog['label'] ?? 'Katalog Menu' }}</p>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><h2 class="text-3xl font-extrabold">{{ $catalog['title'] ?? 'Pilih jagoanmu malam ini' }}</h2><p class="mt-1 text-sm" style="color:var(--muted)">{{ $catalog['subtitle'] ?? '' }}</p></div>
        <input id="q" class="field max-w-xs" placeholder="Cari: indomie, nasi, es..." oninput="renderMenu()" aria-label="Cari menu">
    </div>
    <div class="mt-4 flex gap-2 overflow-x-auto pb-2" role="group" aria-label="Filter kategori">
        <button class="chip" data-cat="all" aria-pressed="true" onclick="setCat('all',this)">Semua</button>
        <button class="chip" data-cat="mie" aria-pressed="false" onclick="setCat('mie',this)">Mie</button>
        <button class="chip" data-cat="nasi" aria-pressed="false" onclick="setCat('nasi',this)">Nasi</button>
        <button class="chip" data-cat="minum" aria-pressed="false" onclick="setCat('minum',this)">Minuman</button>
    </div>
    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_320px]">
        <div id="grid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3"></div>
        <aside class="card h-fit p-5 lg:sticky lg:top-20" aria-label="Keranjang simulasi">
            <h3 class="font-bold"><i class="fa-solid fa-cart-shopping"></i> Keranjang <span class="text-xs font-normal" style="color:var(--muted)">(simulasi)</span></h3>
            <div id="sim-items" class="mt-3 space-y-2 text-sm"><p style="color:var(--muted)">Belum ada item. Klik + Tambah.</p></div>
            <div class="mt-4 flex justify-between border-t pt-3" style="border-color:var(--line)"><span>Total</span><strong id="sim-total">Rp 0</strong></div>
            <a href="{{ route('member.dashboard') }}" class="btn-grad mt-4 w-full">Checkout di Dashboard <i class="fa-solid fa-arrow-right"></i></a>
            <button class="btn-ghost mt-2 w-full text-sm" onclick="clearSim()">Kosongkan</button>
        </aside>
    </div>
</section>

{{-- PAKET HEMAT --}}
<section id="paket" class="wrap pt-16">
    <p class="text-xs font-bold uppercase tracking-[.2em]" style="color:var(--brand2)">Paket Hemat</p>
    <h2 class="mt-2 text-3xl font-extrabold">Paket Nongkrong Hemat</h2>
    <p class="mt-1 text-sm" style="color:var(--muted)">Geser jumlah orang, kami hitungkan paket termurah otomatis. Foto asli, tanpa animasi.</p>
    <div class="card mt-5 grid gap-6 p-6 lg:grid-cols-2">
        <div>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <label for="orang" class="font-bold">Jumlah orang: <span id="orang-val">2</span></label>
                <div class="flex items-center gap-2" role="group" aria-label="Ubah jumlah orang">
                    <button type="button" id="orang-minus" class="btn-ghost !min-h-11 !min-w-11 !px-3 text-xl font-extrabold" onclick="stepOrang(-1)" aria-label="Kurangi jumlah orang">−</button>
                    <button type="button" id="orang-plus" class="btn-ghost !min-h-11 !min-w-11 !px-3 text-xl font-extrabold" onclick="stepOrang(1)" aria-label="Tambah jumlah orang">+</button>
                </div>
            </div>
            <input id="orang" type="range" min="1" max="10" value="2" class="mt-3 w-full" oninput="calcPaket()" aria-label="Jumlah orang">
            <div class="mt-4 space-y-3 text-sm" id="paket-list">
                @forelse($pakets as $b)
                <div class="flex gap-3 rounded-xl border p-3" style="border-color:var(--line)">
                    @if(!empty($b['image']))
                    <img src="{{ $b['image'] }}" alt="{{ $b['name'] }}" loading="lazy" class="h-20 w-20 shrink-0 rounded-lg object-cover">
                    @else
                    <div class="grid h-20 w-20 shrink-0 place-items-center rounded-lg p-1 text-center text-[11px]" style="background:rgba(255,255,255,.05);color:var(--muted)">Foto menyusul</div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <label class="flex cursor-pointer items-start justify-between gap-3">
                            <span><input type="radio" name="paket" value="{{ $b['price'] }}" data-name="{{ $b['name'] }}" onchange="calcPaket()"> <strong>{{ $b['name'] }}</strong><br><span style="color:var(--muted)">{{ $b['desc'] }} @if($b['original']) <s>Rp {{ number_format($b['original'],0,',','.') }}</s>@endif</span></span>
                            <strong class="shrink-0" style="color:var(--brand2)">Rp {{ number_format($b['price'],0,',','.') }}</strong>
                        </label>
                    </div>
                </div>
                @empty
                <p style="color:var(--muted)">Paket bundling belum diatur admin.</p>
                @endforelse
            </div>
        </div>
        <div class="rounded-2xl p-6 text-center" style="background:var(--grad);color:#1a1000">
            <p class="text-sm font-bold uppercase">Estimasi per orang</p>
            <p id="per-orang" class="text-4xl font-extrabold">Rp 17.500</p>
            <p id="paket-name" class="mt-1 text-sm font-semibold">Pilih paket dulu</p>
            <p class="mt-2 text-xs">* Simulasi di landing. Harga final ikut kasir / dashboard.</p>
            <a href="{{ route('member.dashboard') }}" class="btn-ghost mt-4 w-full !border-black/20 !bg-black/10 !text-black">Ambil Paket Ini</a>
        </div>
    </div>
</section>

{{-- ULASAN --}}
<section id="ulasan" class="wrap pt-16">
    <p class="text-xs font-bold uppercase tracking-[.2em]" style="color:var(--brand2)">Ulasan</p>
    <h2 class="mt-2 text-3xl font-extrabold">Kata anak nongkrong</h2>
    <div class="mt-5 grid gap-6 lg:grid-cols-[1fr_340px]">
        <div id="review-grid" class="grid gap-4 md:grid-cols-2">
            @forelse($reviewList as $t)
            <figure class="card p-5"><div class="text-sm" style="color:var(--brand2)">{{ str_repeat('★', max(1,min(5,$t['rating']))) }}</div><blockquote class="mt-2 text-sm">“{{ $t['text'] }}”</blockquote><figcaption class="mt-3 text-sm font-bold">— {{ $t['name'] }}</figcaption></figure>
            @empty
            <p class="card p-6 text-sm" style="color:var(--muted)">Belum ada ulasan. Jadilah yang pertama!</p>
            @endforelse
        </div>
        <div class="card h-fit p-5 lg:sticky lg:top-20">
            <h3 class="font-bold"><i class="fa-solid fa-pen"></i> Tulis ulasanmu</h3>
            @auth
            <form id="review-form" class="mt-3 space-y-3" onsubmit="return submitReview(event)">
                <div>
                    <label for="rv-rating" class="mb-1 block text-sm font-bold">Rating</label>
                    <select id="rv-rating" class="field" required>
                        <option value="5">★★★★★ — Mantap banget</option>
                        <option value="4">★★★★ — Enak</option>
                        <option value="3">★★★ — Lumayan</option>
                        <option value="2">★★ — Kurang</option>
                        <option value="1">★ — Kecewa</option>
                    </select>
                </div>
                <div>
                    <label for="rv-text" class="mb-1 block text-sm font-bold">Ceritamu (maks 500 huruf)</label>
                    <textarea id="rv-text" class="field" rows="4" maxlength="500" minlength="4" required placeholder="Contoh: Mie smoky-nya nagih, porsi pas buat nongkrong..."></textarea>
                </div>
                <p id="rv-msg" class="hidden text-sm font-bold"></p>
                <button id="rv-btn" class="btn-grad w-full" type="submit"><i class="fa-solid fa-paper-plane"></i> Kirim Ulasan</button>
            </form>
            @else
            <p class="mt-3 text-sm" style="color:var(--muted)">Login dulu buat tulis ulasan, biar tidak spam.</p>
            <a href="{{ route('login') }}" class="btn-grad mt-3 w-full"><i class="fa-solid fa-right-to-bracket"></i> Login / Daftar</a>
            @endauth
        </div>
    </div>
</section>

{{-- LOKASI BONTANG --}}
<section id="lokasi" class="wrap pt-16">
    <div class="card grid gap-6 p-6 lg:grid-cols-2 lg:p-10">
        <div>
            <p class="text-xs font-bold uppercase" style="color:var(--brand2)">Lokasi • Bontang Utara</p>
            <h2 class="mt-2 text-3xl font-extrabold">Mampir, jangan cuma ngiler</h2>
            <p class="mt-3 text-sm" style="color:var(--muted)">{{ $warung['address'] ?? 'Bontang, Kalimantan Timur' }}<br>Buka: {{ $warung['open_time'] ?? '19:00' }} – {{ $warung['close_time'] ?? '00:00' }} {{ $warung['timezone_label'] ?? 'WITA' }}<br>{{ $warung['phone_display'] ?? '' }}</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a class="btn-grad" target="_blank" rel="noopener" href="{{ $warung['maps_link'] ?? 'https://maps.app.goo.gl/jR518yGKeXDjH32D6?g_st=aw' }}"><i class="fa-solid fa-location-dot"></i> Buka Google Maps</a>
                <a class="btn-ghost" href="{{ route('login') }}"><i class="fa-solid fa-user-plus"></i> Jadi Member</a>
            </div>
        </div>
        <iframe title="Peta Warmindo Smokey — Jl. Jend. Achmad Yani, Bontang" src="{{ $warung['maps_embed'] ?? '' }}" class="h-64 w-full rounded-2xl border-0 lg:h-80" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
</section>
@endsection

@push('scripts')
<script>
const MENUS = @json($menus);
const rupiah = v => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v||0);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
let cat = 'all', sim = [];
function setCat(c, btn){ cat = c; document.querySelectorAll('[data-cat]').forEach(b=>b.setAttribute('aria-pressed', String(b===btn))); renderMenu(); }
function matchCat(name, c){ name = (name||'').toLowerCase(); if(c==='all') return true; if(c==='minum') return /teh|kopi|minum|jeruk|es|susu/i.test(name); if(c==='nasi') return /nasi|ayam|rice/i.test(name); return /mie|indomie|dok/i.test(name) || !/nasi|teh|kopi|es|jeruk|minum/i.test(name); }
function renderMenu(){
    const q = (document.getElementById('q').value||'').toLowerCase();
    const list = MENUS.filter(m => matchCat(m.name, cat) && (!q || m.name.toLowerCase().includes(q)));
    document.getElementById('grid').innerHTML = list.length ? list.map(m => `
        <article class="card flex flex-col overflow-hidden">
            ${m.image ? `<img src="${esc(m.image)}" alt="${esc(m.name)}" loading="lazy" class="aspect-[4/3] w-full object-cover">` : `<div class="grid aspect-[4/3] w-full place-items-center p-3 text-center text-xs" style="background:rgba(255,255,255,.04);color:var(--muted)">Foto menyusul<br>admin bisa upload</div>`}
            <div class="flex flex-1 flex-col p-4">
                <h3 class="font-bold leading-tight">${esc(m.name)}</h3>
                <p class="mt-1 line-clamp-3 min-h-12 text-xs" style="color:var(--muted)">${esc(m.desc||'')}</p>
                <div class="mt-auto flex items-center justify-between gap-2 pt-3"><strong style="color:var(--brand2)">${rupiah(m.price)}</strong>
                <button class="btn-grad !min-h-11 !px-3 !py-2 text-sm" onclick="addSim('${esc(m.name).replace(/'/g,"\\'")}',${m.price})" aria-label="Tambah ${esc(m.name)}">+ Tambah</button></div>
            </div>
        </article>`).join('') : '<p class="card p-6 text-center" style="color:var(--muted)">Menu tidak ketemu. Coba kata kunci lain.</p>';
}
function addSim(name, price){ const f = sim.find(x=>x.name===name); f ? f.qty++ : sim.push({name, price, qty:1}); renderSim(); }
function clearSim(){ sim = []; renderSim(); }
function renderSim(){
    const box = document.getElementById('sim-items');
    const total = sim.reduce((s,x)=>s+x.price*x.qty,0);
    box.innerHTML = sim.length ? sim.map((x,i)=>`<div class="flex items-center justify-between gap-2"><span>${esc(x.name)} ×${x.qty}</span><span>${rupiah(x.price*x.qty)} <button class="btn-ghost !min-h-0 !p-1 !px-2 text-xs" onclick="sim[${i}].qty>1?sim[${i}].qty--:sim.splice(${i},1);renderSim()" aria-label="Kurangi">−</button></span></div>`).join('') : '<p style="color:var(--muted)">Belum ada item. Klik + Tambah.</p>';
    document.getElementById('sim-total').textContent = rupiah(total);
}
function calcPaket(){
    const slider = document.getElementById('orang');
    const n = Math.max(1, Math.min(10, Number(slider.value||2)));
    slider.value = n;
    document.getElementById('orang-val').textContent = n;
    document.getElementById('orang-minus').disabled = n <= 1;
    document.getElementById('orang-plus').disabled = n >= 10;
    const sel = document.querySelector('input[name="paket"]:checked');
    const price = sel ? Number(sel.value) : 0;
    const name = sel ? sel.dataset.name : 'Pilih paket dulu';
    document.getElementById('per-orang').textContent = price ? rupiah(Math.round(price/n)) : 'Rp 0';
    document.getElementById('paket-name').textContent = name + (price ? ' • ' + n + ' orang' : '');
}
function stepOrang(d){
    const slider = document.getElementById('orang');
    slider.value = Math.max(1, Math.min(10, Number(slider.value||2) + d));
    calcPaket();
}
function reviewCard(t){
    const stars = '★'.repeat(Math.max(1, Math.min(5, Number(t.rating) || 5)));
    return `<figure class="card p-5"><div class="text-sm" style="color:var(--brand2)">${stars}</div>
    <blockquote class="mt-2 text-sm">“${esc(t.text)}”</blockquote>
    <figcaption class="mt-3 text-sm font-bold">— ${esc(t.name)}</figcaption></figure>`;
}
async function loadReviews(){
    try{
        const r = await fetch('{{ route('reviews.index') }}', {headers:{Accept:'application/json'}});
        if(!r.ok) return;
        const j = await r.json(), data = j.data || [];
        if(!data.length) return;
        document.getElementById('review-grid').innerHTML = data.slice(0,6).map(reviewCard).join('');
    }catch(e){}
}
async function submitReview(e){
    e.preventDefault();
    const msg = document.getElementById('rv-msg'), btn = document.getElementById('rv-btn');
    msg.classList.add('hidden');
    const rating = Number(document.getElementById('rv-rating').value);
    const text = document.getElementById('rv-text').value.trim();
    if(text.length < 4){ msg.textContent = 'Tulis minimal 4 huruf ya.'; msg.style.color = '#B42318'; msg.classList.remove('hidden'); return false; }
    btn.disabled = true;
    try{
        const r = await fetch('{{ route('reviews.store') }}', {
            method:'POST',
            headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
            body: JSON.stringify({rating, text})
        });
        const j = await r.json();
        if(!r.ok) throw new Error(j.message || Object.values(j.errors||{})[0]?.[0] || 'Gagal kirim ulasan.');
        msg.textContent = 'Ulasan terkirim, terima kasih!';
        msg.style.color = '#027A48';
        msg.classList.remove('hidden');
        document.getElementById('rv-text').value = '';
        const grid = document.getElementById('review-grid');
        if(grid && j.data){
            const empty = grid.querySelector('p');
            if(empty) grid.innerHTML = '';
            grid.insertAdjacentHTML('afterbegin', reviewCard(j.data));
        }
        loadReviews();
    }catch(err){
        msg.textContent = err.message;
        msg.style.color = '#B42318';
        msg.classList.remove('hidden');
    }finally{ btn.disabled = false; }
    return false;
}
renderMenu(); calcPaket(); renderSim(); loadReviews();
</script>
@endpush
