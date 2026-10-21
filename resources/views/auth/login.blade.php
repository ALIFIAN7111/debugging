@extends('layouts.warmindo')

@section('title', 'Masuk / Daftar — Warmindo Smoky')

@section('content')
<section class="wrap grid gap-8 py-10 lg:grid-cols-2 lg:py-16">
    <div>
        <p class="text-xs font-bold uppercase tracking-[.2em]" style="color:var(--brand2)"><i class="fa-solid fa-ticket"></i> Member Warmindo Smoky</p>
        <h1 class="mt-3 text-4xl font-extrabold leading-tight">Satu akun,<br>semua promo &amp; antrian.</h1>
        <ul class="mt-5 space-y-3 text-sm" style="color:var(--muted)">
            <li><i class="fa-solid fa-check" style="color:var(--brand2)"></i> Pantau nomor antrian live dari HP</li>
            <li><i class="fa-solid fa-check" style="color:var(--brand2)"></i> Checkout 1 klik + struk digital</li>
            <li><i class="fa-solid fa-check" style="color:var(--brand2)"></i> Password WiFi member di dashboard</li>
        </ul>
        <div class="card mt-6 flex items-center gap-4 p-4">
            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl text-xl" style="background:var(--grad)"><i class="fa-solid fa-wifi text-white"></i></span>
            <p class="text-sm">WiFi member <strong>WMSMOKY-5G</strong> • kecepatan 100 Mbps buat mabar &amp; nugas.</p>
        </div>
    </div>

    <div class="card p-6 sm:p-8" x-data="{ tab: 'login' }">
        <div class="grid grid-cols-2 gap-2 rounded-xl p-1" style="background:rgba(255,255,255,.05)" role="tablist" aria-label="Pilih masuk atau daftar">
            <button type="button" role="tab" :aria-selected="tab==='login'" @click="tab='login'" :style="tab==='login' ? 'background:var(--grad);color:#1a1000' : ''" class="rounded-lg py-3 font-bold" style="color:var(--muted)">Masuk</button>
            <button type="button" role="tab" :aria-selected="tab==='register'" @click="tab='register'" :style="tab==='register' ? 'background:var(--grad);color:#1a1000' : ''" class="rounded-lg py-3 font-bold" style="color:var(--muted)">Daftar</button>
        </div>

        <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />

        {{-- LOGIN --}}
        <form x-show="tab==='login'" method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-bold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com" class="field">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-bold">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••" class="field pr-14">
                    <button type="button" class="absolute right-2 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-lg" style="color:var(--muted)" onclick="togglePw('password',this)" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-solid fa-eye"></i></button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2"><input type="checkbox" name="remember"> Ingat saya</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-bold" style="color:var(--brand2)">Lupa password?</a>
                @endif
            </div>
            <button class="btn-grad w-full" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Masuk</button>
            <div class="flex items-center gap-3 text-xs" style="color:var(--muted)"><span class="h-px flex-1" style="background:var(--line)"></span>atau<span class="h-px flex-1" style="background:var(--line)"></span></div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" class="btn-ghost text-sm" onclick="alert('Login Google demo — hubungkan OAuth untuk produksi.')"><i class="fa-brands fa-google"></i> Google</button>
                <button type="button" class="btn-ghost text-sm" onclick="alert('Login Facebook demo — hubungkan OAuth untuk produksi.')"><i class="fa-brands fa-facebook"></i> Facebook</button>
            </div>
        </form>

        {{-- REGISTER --}}
        <form x-show="tab==='register'" method="POST" action="{{ route('register') }}" class="mt-5 space-y-4" style="display:none">
            @csrf
            <div>
                <label for="name" class="mb-1 block text-sm font-bold">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama kamu" class="field">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <label for="email_reg" class="mb-1 block text-sm font-bold">Email</label>
                <input id="email_reg" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="field">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password_reg" class="mb-1 block text-sm font-bold">Password</label>
                    <div class="relative">
                        <input id="password_reg" name="password" type="password" required autocomplete="new-password" placeholder="Min. 8 karakter" class="field pr-14">
                        <button type="button" class="absolute right-2 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-lg" style="color:var(--muted)" onclick="togglePw('password_reg',this)" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-solid fa-eye"></i></button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-bold">Ulangi</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ketik lagi" class="field pr-14">
                        <button type="button" class="absolute right-2 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-lg" style="color:var(--muted)" onclick="togglePw('password_confirmation',this)" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
            </div>
            <button class="btn-grad w-full" type="submit"><i class="fa-solid fa-user-plus"></i> Buat akun</button>
        </form>

        <p class="mt-5 text-center text-xs" style="color:var(--muted)">Satu pintu login: admin, kasir, dan user masuk di sini. Sistem mengarahkan otomatis sesuai peran — user tidak bisa membuka dashboard admin.</p>
    </div>
</section>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function togglePw(id, btn){
    const el = document.getElementById(id);
    if(!el || !btn) return;
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.setAttribute('aria-pressed', String(show));
    btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    btn.innerHTML = show ? '<i class="fa-solid fa-eye-slash"></i>' : '<i class="fa-solid fa-eye"></i>';
    el.focus({preventScroll:true});
}
</script>
@endpush
