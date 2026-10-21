<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'WM SMOKY') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#17202D]">
        <div class="min-h-screen bg-[#17202D] px-3 py-3 sm:px-6 sm:py-6 lg:px-10 lg:py-8">
            <div class="mx-auto grid min-h-[calc(100vh-1.5rem)] max-w-6xl overflow-hidden rounded-[2rem] bg-[#FFF9EF] shadow-[0_28px_90px_rgba(0,0,0,0.35)] sm:min-h-[calc(100vh-3rem)] lg:grid-cols-[1.05fr_0.95fr]">
                <aside class="relative hidden overflow-hidden bg-[#F7C843] px-10 py-12 lg:flex lg:flex-col lg:justify-between">
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border-[28px] border-[#F2674A]/30"></div>
                    <div class="absolute -bottom-28 -left-20 h-72 w-72 rounded-full bg-[#F2674A]/20"></div>
                    <div class="absolute right-12 top-32 h-3 w-3 rounded-full bg-[#17202D]"></div>
                    <div class="absolute bottom-28 right-24 h-5 w-5 rounded-full border-4 border-[#17202D]"></div>
                    <div class="relative z-10 flex items-center justify-between text-xs font-black uppercase tracking-[0.18em] text-[#17202D]">
                        <span class="rounded-full border-2 border-[#17202D] px-3 py-1">WM SMOKY</span>
                        <span class="rotate-[-5deg]">EST. 2024 ✦</span>
                    </div>
                    <div class="relative z-10 my-auto max-w-md">
                        <div class="mb-6 inline-flex -rotate-2 items-center rounded-lg bg-[#F2674A] px-4 py-2 text-sm font-black uppercase tracking-[0.16em] text-white shadow-[4px_4px_0_#17202D]">Tempatnya anak nongki</div>
                        <h1 class="max-w-sm text-6xl font-black leading-[0.95] tracking-[-0.06em] text-[#17202D]">Laper?<br><span class="text-[#F2674A]">Gas.</span></h1>
                        <p class="mt-6 max-w-sm text-lg font-semibold leading-7 text-[#3C4350]">Menu comfort food, vibes hangat, dan teman ngobrol selalu siap nemenin malam kamu.</p>
                        <div class="relative mx-auto mt-8 h-64 w-full max-w-[22rem]"><div class="absolute inset-4 rounded-full border-2 border-[#F2674A]/40"></div><div class="absolute inset-9 rounded-full bg-[#FFF1A9]"></div><img src="{{ asset('images/mie-ilustrasi.svg') }}" alt="Ilustrasi semangkuk mie hangat WM SMOKY" class="relative z-10 h-full w-full drop-shadow-[10px_14px_0_rgba(23,32,45,0.18)]"><span class="absolute bottom-2 left-2 z-20 rounded-full bg-[#F2674A] px-3 py-1 text-xs font-black text-white shadow-[3px_3px_0_#17202D]">MIE DULU 🍜</span></div>
                    </div>
                    <div class="relative z-10 flex items-end justify-between text-sm font-bold text-[#3C4350]">
                        <span>mie • kopi • cerita</span>
                        <span class="text-2xl">☻</span>
                    </div>
                </aside>
                <main class="flex items-center justify-center px-5 py-8 sm:px-12 sm:py-12 lg:px-14">
                    <div class="w-full max-w-md">
                        <div class="mb-8 lg:hidden">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-[#F7C843] px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#17202D]">WM SMOKY</span>
                                <span class="text-xl">✦</span>
                            </div>
                            <div class="relative mx-auto mt-4 h-28 w-40"><div class="absolute inset-3 rounded-full bg-[#FFF1A9]"></div><img src="{{ asset('images/mie-ilustrasi.svg') }}" alt="Ilustrasi semangkuk mie hangat WM SMOKY" class="relative z-10 h-full w-full drop-shadow-[4px_6px_0_rgba(23,32,45,0.15)]"></div>
                        </div>
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
