<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodMart — Preview Template</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #fcd34d; }
        ::selection { background-color: #fef3c7; color: #92400e; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-100 flex flex-col">
            <div class="h-16 flex items-center px-5 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center shadow-sm shadow-amber-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-base font-bold text-gray-900 leading-none">FoodMart</span>
                        <span class="block text-[10px] text-amber-500 font-medium tracking-wider uppercase mt-0.5">Admin Panel</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-amber-50 text-amber-700">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Menu Makanan
                    <span class="ml-auto text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">128</span>
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Pesanan
                    <span class="ml-auto text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">12</span>
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pelanggan
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Restoran
                </a>

                <p class="px-3 mt-6 mb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Analitik</p>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Laporan
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    Statistik
                </a>

                <p class="px-3 mt-6 mb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Sistem</p>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </a>
                <a href="#" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bantuan
                </a>
            </nav>

            <div class="px-3 pb-3">
                <div class="rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 p-4 text-white relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white/10"></div>
                    <div class="absolute -right-6 -bottom-6 w-20 h-20 rounded-full bg-white/10"></div>
                    <div class="relative">
                        <p class="text-sm font-semibold">Upgrade ke Pro</p>
                        <p class="text-xs text-amber-50/90 mt-1 mb-3">Buka fitur premium untuk bisnis Anda</p>
                        <button class="w-full bg-white text-amber-600 text-xs font-semibold py-2 rounded-lg hover:bg-amber-50 transition-colors">Upgrade Sekarang</button>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 p-3">
                <div class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
<div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center text-white text-sm font-semibold">
    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
</div>
<div class="flex-1 min-w-0">
    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin FoodMart' }}</p>
    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'admin@foodmart.id' }}</p>
</div>
                        <p class="text-xs text-gray-500 truncate">admin@foodmart.id</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-gray-100">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="relative max-w-md w-full">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" placeholder="Cari menu, pesanan, pelanggan..." class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-transparent rounded-lg focus:bg-white focus:border-amber-300 focus:ring-2 focus:ring-amber-100 outline-none transition-all">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="hidden sm:flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm shadow-amber-500/30">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Pesanan Baru
                            </button>
                            <button class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-amber-500 rounded-full ring-2 ring-white"></span>
                            </button>
                            <button class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                            </button>
                            <div class="hidden sm:block w-px h-6 bg-gray-200 mx-1"></div>

<!-- Dropdown Profile dengan Alpine.js -->
<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <!-- Tombol Pemicu -->
    <button @click="open = !open" class="flex items-center gap-2 p-1 pr-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center text-white text-xs font-semibold">
            {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
        </div>
        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Isi Dropdown (Menu) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
         style="display: none;">
        
        <!-- Link Profile -->
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
            Profile
        </a>
        
        <!-- Form Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                Log Out
            </button>
        </form>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                <!-- Heading -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Selamat datang kembali, Admin! 👋</h1>
                        <p class="text-sm text-gray-500 mt-1">Berikut ringkasan aktivitas FoodMart hari ini.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            7 Hari Terakhir
                        </button>
                        <button class="inline-flex items-center gap-2 px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm shadow-amber-500/30">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Export Laporan
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-11 h-11 rounded-lg bg-amber-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12.5%</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900">Rp 24.580.000</p>
                        <p class="text-xs text-gray-400 mt-2">dari Rp 21.850.000 bulan lalu</p>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-11 h-11 rounded-lg bg-orange-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">+8.2%</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">1.248</p>
                        <p class="text-xs text-gray-400 mt-2">94 pesanan hari ini</p>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-11 h-11 rounded-lg bg-yellow-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">+5.1%</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Pelanggan Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">3.642</p>
                        <p class="text-xs text-gray-400 mt-2">186 pelanggan baru bulan ini</p>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-11 h-11 rounded-lg bg-amber-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">-2.4%</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Rata-rata Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">Rp 19.700</p>
                        <p class="text-xs text-gray-400 mt-2">dari Rp 20.180 bulan lalu</p>
                    </div>
                </div>

                <!-- Chart + Popular Menu -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Penjualan Mingguan</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Tren pendapatan 7 hari terakhir</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="flex items-center gap-1.5 text-gray-600"><span class="w-2.5 h-2.5 rounded-sm bg-amber-500"></span> Pendapatan</span>
                                <span class="flex items-center gap-1.5 text-gray-600"><span class="w-2.5 h-2.5 rounded-sm bg-gray-200"></span> Target</span>
                            </div>
                        </div>
                        <div class="flex items-end justify-between gap-2 h-48 pt-4">
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 65%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Sen</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 78%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Sel</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 52%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Rab</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 88%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Kam</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 95%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Jum</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 72%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Sab</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full flex items-end justify-center gap-1 h-full">
                                    <div class="flex-1 bg-amber-500 rounded-t-md" style="height: 84%"></div>
                                    <div class="flex-1 bg-gray-200 rounded-t-md" style="height: 70%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Min</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Menu Terlaris</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Top 5 minggu ini</p>
                            </div>
                            <button class="text-xs font-medium text-amber-600 hover:text-amber-700">Lihat semua</button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">Nasi Goreng Spesial</p>
                                        <p class="text-xs font-semibold text-gray-600 ml-2">328</p>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">Ayam Geprek Sambal Matah</p>
                                        <p class="text-xs font-semibold text-gray-600 ml-2">285</p>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full" style="width: 70%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">Mie Ayam Bakso</p>
                                        <p class="text-xs font-semibold text-gray-600 ml-2">214</p>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full" style="width: 55%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">Sate Ayam Madura</p>
                                        <p class="text-xs font-semibold text-gray-600 ml-2">178</p>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">Gado-gado Jakarta</p>
                                        <p class="text-xs font-semibold text-gray-600 ml-2">142</p>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full" style="width: 35%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Pesanan Terbaru</h3>
                            <p class="text-xs text-gray-500 mt-0.5">5 pesanan terakhir yang masuk</p>
                        </div>
                        <button class="text-xs font-medium text-amber-600 hover:text-amber-700">Lihat semua</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5 text-sm font-medium text-amber-600">#ORD-0842</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-900">Budi Santoso</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">Nasi Goreng Spesial + Es Teh</td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">Rp 32.000</td>
                                    <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>Selesai</span></td>
                                    <td class="px-5 py-3.5 text-sm text-gray-500">5 menit lalu</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5 text-sm font-medium text-amber-600">#ORD-0841</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-900">Siti Nurhaliza</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">Ayam Geprek Sambal Matah</td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">Rp 28.000</td>
                                    <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>Diproses</span></td>
                                    <td class="px-5 py-3.5 text-sm text-gray-500">12 menit lalu</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5 text-sm font-medium text-amber-600">#ORD-0840</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-900">Andi Wijaya</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">Mie Ayam Bakso + Es Jeruk</td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">Rp 25.000</td>
                                    <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>Dikirim</span></td>
                                    <td class="px-5 py-3.5 text-sm text-gray-500">18 menit lalu</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5 text-sm font-medium text-amber-600">#ORD-0839</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-900">Dewi Lestari</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">Sate Ayam Madura (10 tusuk)</td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">Rp 35.000</td>
                                    <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>Selesai</span></td>
                                    <td class="px-5 py-3.5 text-sm text-gray-500">32 menit lalu</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3.5 text-sm font-medium text-amber-600">#ORD-0838</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-900">Rudi Hartono</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">Gado-gado + Lontong</td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">Rp 22.000</td>
                                    <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>Dibatalkan</span></td>
                                    <td class="px-5 py-3.5 text-sm text-gray-500">45 menit lalu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <footer class="border-t border-gray-100 bg-white px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-gray-500">
                    <p>&copy; 2026 FoodMart. All rights reserved.</p>
                    <p>Dibuat dengan <span class="text-amber-500">♥</span> untuk pecinta kuliner</p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
