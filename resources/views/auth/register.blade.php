<x-guest-layout>
    <div>
        <div class="mb-8">
            <p class="inline-flex rounded-full bg-[#F7C843]/25 px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#B07A00]">✦ First time here?</p>
            <h2 class="mt-4 text-4xl font-black tracking-[-0.04em] text-[#17202D]">Bikin akun<span class="text-[#F2674A]">.</span></h2>
            <p class="mt-2 text-sm leading-6 text-[#69717D]">Gabung ke circle WM SMOKY dan mulai cari makanan favoritmu.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-black text-[#17202D]">Nama kamu</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Misalnya: Anak WM SMOKY" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#F2674A] focus:ring-4 focus:ring-[#F2674A]/10 focus:outline-none">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-black text-[#17202D]">Email kamu</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#F2674A] focus:ring-4 focus:ring-[#F2674A]/10 focus:outline-none">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-black text-[#17202D]">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#F2674A] focus:ring-4 focus:ring-[#F2674A]/10 focus:outline-none">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-black text-[#17202D]">Ulangi password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik lagi" class="w-full rounded-2xl border-2 border-[#E6DED1] bg-white px-4 py-3.5 text-[#17202D] placeholder-[#A9AEB6] transition focus:border-[#F2674A] focus:ring-4 focus:ring-[#F2674A]/10 focus:outline-none">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-[#17202D] py-4 font-black text-white shadow-[0_5px_0_#F2674A] transition duration-200 hover:-translate-y-0.5 hover:bg-[#2B3544] focus:outline-none focus:ring-4 focus:ring-[#F7C843]/50">Buat akun sekarang <span class="ml-1 text-[#F7C843]">→</span></button>
        </form>

        <p class="mt-7 text-center text-sm text-[#69717D]">Sudah punya akun? <a href="{{ route('login') }}" class="font-black text-[#F2674A] hover:text-[#D84C35] hover:underline">Masuk di sini</a></p>
    </div>
</x-guest-layout>
