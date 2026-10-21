<x-guest-layout>
    <div>
        <div class="mb-8">
            <p class="inline-flex rounded-full bg-[#17202D] px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#F7C843]">✦ WM SMOKY Admin</p>
            <h2 class="mt-4 text-4xl font-black tracking-[-0.04em] text-[#17202D]">Login Admin<span class="text-[#F2674A]">.</span></h2>
            <p class="mt-2 text-sm leading-6 text-[#69717D]">Khusus admin &amp; kasir untuk kelola menu, pesanan, dan laporan.</p>
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-black text-[#17202D]">Email atau username admin</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@wmsmoky.id" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#17202D] focus:ring-4 focus:ring-[#F7C843]/30 focus:outline-none">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-black text-[#17202D]">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password admin" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#17202D] focus:ring-4 focus:ring-[#F7C843]/30 focus:outline-none">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between text-sm text-[#69717D]">
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="remember" id="remember_me" class="rounded border-[#D9C4AE] text-[#17202D] focus:ring-[#F7C843]"><span>Ingat saya</span></label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-bold text-[#17202D] hover:underline">Lupa password?</a>
                @endif
            </div>
            <button type="submit" class="w-full rounded-2xl bg-[#17202D] py-4 font-black text-white shadow-[0_5px_0_#F7C843] transition duration-200 hover:-translate-y-0.5 hover:bg-[#2B3544] focus:outline-none focus:ring-4 focus:ring-[#F7C843]/50">Masuk dashboard <span class="ml-1 text-[#F7C843]">→</span></button>
        </form>
        <p class="mt-7 text-center text-sm text-[#69717D]">Bukan admin? <a href="{{ route('login') }}" class="font-black text-[#F2674A] hover:text-[#D84C35] hover:underline">Login sebagai user</a></p>
    </div>
</x-guest-layout>
