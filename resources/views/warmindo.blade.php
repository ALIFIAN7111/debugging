<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WM SMOKY - Tempat Nongkrong Hits Bontang</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            red: '#FF2A55',
                            orange: '#FF5E00',
                            yellow: '#FFB800',
                            dark: '#0D0E15',
                            card: '#161824',
                            border: '#2A2D3D'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(22, 24, 36, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .text-gradient {
            background: linear-gradient(135deg, #FF2A55 0%, #FF5E00 50%, #FFB800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #FF2A55 0%, #FF5E00 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #FF5E00 0%, #FF2A55 100%);
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0D0E15;
        }
        ::-webkit-scrollbar-thumb {
            background: #2A2D3D;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #FF5E00;
        }
    </style>
</head>
<body class="bg-[#0D0E15] text-slate-100 font-sans min-h-screen selection:bg-brand-orange selection:text-white pb-24 md:pb-0">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-40 glass border-b border-brand-border/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl btn-gradient flex items-center justify-center text-white shadow-lg shadow-brand-red/30 group-hover:scale-105 transition">
                        <i data-lucide="flame" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="font-display text-2xl font-bold tracking-wider text-white">WM<span class="text-brand-orange"> SMOKY</span></span>
                        <span class="block text-[10px] text-brand-yellow font-semibold tracking-widest uppercase">Bontang Street Food</span>
                    </div>
                </a>

                <!-- Nav Menu Desktop -->
                <nav class="hidden md:flex items-center gap-8 font-semibold text-sm text-slate-300">
                    <a href="#hero" class="hover:text-brand-orange transition">Home</a>
                    <a href="#menu" class="hover:text-brand-orange transition">Menu Hits</a>
                    <a href="#paket" class="hover:text-brand-orange transition">Paket Hemat</a>
                    <a href="#vibe" class="hover:text-brand-orange transition">Vibe Check</a>
                    <a href="#lokasi" class="hover:text-brand-orange transition">Lokasi</a>
                </nav>

                <!-- Cart Button -->
                <button onclick="toggleCart()" class="relative flex items-center gap-2 bg-brand-card hover:bg-brand-border text-white px-4 py-2.5 rounded-full border border-brand-border transition group">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-brand-orange group-hover:scale-110 transition"></i>
                    <span class="font-semibold text-sm hidden sm:inline">Pesanan</span>
                    <span id="cart-badge" class="bg-brand-red text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="relative overflow-hidden py-16 lg:py-24">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-96 h-96 bg-brand-red/20 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-red/10 border border-brand-red/30 text-brand-red text-xs font-bold uppercase tracking-wider mb-6">
                        <i data-lucide="sparkles" class="w-4 h-4"></i> WM SMOKY No. 1 Paling Hits di Bontang!
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold font-display leading-tight mb-6">
                        Sensasi Mie <span class="text-gradient">Smoky & Pedas</span> Khas Gen Z!
                    </h1>
                    <p class="text-slate-400 text-lg mb-8 leading-relaxed">
                        Nongkrong asik, tempat strategis di tengah kota Bontang, WiFi kencang, dan harga dompet-friendly! Buka sampai malam buat nemenin tugas & ngobrol kamu.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#menu" class="btn-gradient text-white px-8 py-4 rounded-2xl font-bold text-base shadow-lg shadow-brand-red/25 hover:shadow-brand-orange/40 hover:-translate-y-0.5 transition flex items-center gap-2">
                            <i data-lucide="utensils"></i> Pesan Sekarang
                        </a>
                        <a href="#lokasi" class="bg-brand-card hover:bg-brand-border text-white px-6 py-4 rounded-2xl font-semibold border border-brand-border transition flex items-center gap-2">
                            <i data-lucide="map-pin" class="text-brand-orange"></i> Cek Rute Lokasi
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden border border-brand-border glass p-3">
                        <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=800&q=80" alt="WM SMOKY" class="w-full h-[400px] object-cover rounded-2xl">
                        <div class="absolute bottom-6 left-6 right-6 glass p-4 rounded-2xl flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400">Rasa Otentik</p>
                                <p class="font-bold text-white text-base">Spesialis Indomie Dok-Dok Smoky</p>
                            </div>
                            <span class="bg-brand-yellow text-black font-extrabold text-xs px-3 py-1.5 rounded-lg">Mulai Rp 10k</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MENU SECTION -->
    <section id="menu" class="py-16 bg-brand-card/30 border-y border-brand-border/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-bold font-display text-white">Katalog Menu Populer</h2>
                    <p class="text-slate-400 text-sm mt-1">Pilih favoritmu, atur level pedas, dan pesan via WhatsApp!</p>
                </div>
                <!-- Search & Category Filter -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <input type="text" id="search-input" oninput="renderMenu()" placeholder="Cari menu..." class="bg-brand-card border border-brand-border text-white text-sm rounded-xl px-4 py-2.5 pl-10 focus:outline-none focus:border-brand-orange w-full sm:w-48">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-2 sm:pb-0" id="category-buttons">
                        <!-- Dynamic Buttons -->
                    </div>
                </div>
            </div>

            <!-- Menu Grid -->
            <div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Menu Items Rendered Here -->
            </div>
        </div>
    </section>

    <!-- PAKET HEMAT SECTION -->
    <section id="paket" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-brand-yellow text-xs font-extrabold uppercase tracking-widest bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">Hemat Banget</span>
                <h2 class="text-3xl font-bold font-display text-white mt-3">Bundling Kombo Gen Z</h2>
                <p class="text-slate-400 text-sm mt-2">Makan wareg, dompet tenang. Solusi tanggal tua anak muda Bontang!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Paket 1 -->
                <div class="glass p-6 rounded-3xl relative overflow-hidden border border-brand-border hover:border-brand-orange transition">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-brand-red/20 text-brand-red text-xs font-bold px-3 py-1 rounded-full">Paket Solo</span>
                        <span class="text-2xl font-bold text-brand-yellow">Rp 22.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Paket Nongkrong Sendiri</h3>
                    <p class="text-xs text-slate-400 mb-4">Indomie Smoky Spesial + Telur Kornet + Es Teh Manis Jumbo</p>
                    <button onclick="addBundleToCart('Paket Nongkrong Sendiri', 22000)" class="w-full py-3 bg-brand-card hover:bg-brand-orange hover:text-white text-slate-200 font-bold rounded-xl border border-brand-border transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Ke Keranjang
                    </button>
                </div>

                <!-- Paket 2 -->
                <div class="glass p-6 rounded-3xl relative overflow-hidden border-2 border-brand-orange shadow-lg shadow-brand-orange/10">
                    <div class="absolute top-0 right-0 bg-brand-orange text-white text-[10px] font-extrabold px-3 py-1 rounded-bl-xl uppercase">Best Seller</div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-brand-orange/20 text-brand-orange text-xs font-bold px-3 py-1 rounded-full">Paket Berdua</span>
                        <span class="text-2xl font-bold text-brand-yellow">Rp 42.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Paket Buat Mabar / Date</h3>
                    <p class="text-xs text-slate-400 mb-4">2x Indomie Double Smoky + French Fries + 2x Es Nutrisari</p>
                    <button onclick="addBundleToCart('Paket Buat Mabar / Date', 42000)" class="w-full py-3 btn-gradient text-white font-bold rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Ke Keranjang
                    </button>
                </div>

                <!-- Paket 3 -->
                <div class="glass p-6 rounded-3xl relative overflow-hidden border border-brand-border hover:border-brand-orange transition">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-brand-yellow/20 text-brand-yellow text-xs font-bold px-3 py-1 rounded-full">Paket Rombongan</span>
                        <span class="text-2xl font-bold text-brand-yellow">Rp 75.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Paket Skuad Ambis</h3>
                    <p class="text-xs text-slate-400 mb-4">4x Indomie Smoky + Dimsum Mix (6pcs) + 1 Pitcher Es Teh</p>
                    <button onclick="addBundleToCart('Paket Skuad Ambis', 75000)" class="w-full py-3 bg-brand-card hover:bg-brand-orange hover:text-white text-slate-200 font-bold rounded-xl border border-brand-border transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- VIBE CHECK SECTION -->
    <section id="vibe" class="py-16 bg-brand-card/30 border-y border-brand-border/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-3xl font-bold font-display text-white">Kenapa WM SMOKY Rame Terus?</h2>
                <p class="text-slate-400 text-sm mt-2">Fasilitas komplit buat kamu yang pengen nugas, mabar, atau sekadar chilling.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl text-center">
                    <div class="w-12 h-12 rounded-xl bg-brand-red/20 text-brand-red flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="wifi" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-white mb-1">Free WiFi Kencang</h4>
                    <p class="text-xs text-slate-400">Up to 100 Mbps anti lag buat mabar ML/Pubg</p>
                </div>

                <div class="glass p-6 rounded-2xl text-center">
                    <div class="w-12 h-12 rounded-xl bg-brand-orange/20 text-brand-orange flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-white mb-1">Stopkontak Tiap Meja</h4>
                    <p class="text-xs text-slate-400">Laptop & HP aman dari batre drop</p>
                </div>

                <div class="glass p-6 rounded-2xl text-center">
                    <div class="w-12 h-12 rounded-xl bg-brand-yellow/20 text-brand-yellow flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="music" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-white mb-1">Playlist Aesthetic</h4>
                    <p class="text-xs text-slate-400">Lagu-lagu TikTok & Indie hits kekinian</p>
                </div>

                <div class="glass p-6 rounded-2xl text-center">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 text-green-400 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-white mb-1">Buka Sampai Malam</h4>
                    <p class="text-xs text-slate-400">19:00 - 00:00 WITA</p>
                </div>
            </div>
        </div>
    </section>

    <!-- LOCATION SECTION -->
    <section id="lokasi" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-6 lg:p-10 border border-brand-border">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="text-brand-orange text-xs font-bold uppercase tracking-wider">Spot Strategis</span>
                        <h2 class="text-3xl font-bold font-display text-white mt-2 mb-4">Lokasi WM SMOKY</h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6">
                            Terletak di pusat keramaian kota Bontang. Tempat pas buat kumpul sepulang sekolah, kuliah, atau kerja shift.
                        </p>
                        
                        <div class="space-y-4 text-sm text-slate-300 mb-8">
                            <div class="flex items-start gap-3">
                                <i data-lucide="map-pin" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                                <span>Warmindo Smokey, Jl. Jend. Achmad Yani, Api-Api, Bontang Utara</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="clock" class="w-5 h-5 text-brand-orange flex-shrink-0"></i>
                                <span>Setiap Hari: 19:00 - 00:00 WITA</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="phone" class="w-5 h-5 text-brand-yellow flex-shrink-0"></i>
                                <span>WhatsApp: +62 812-3456-7890</span>
                            </div>
                        </div>

                        <a href="https://maps.app.goo.gl/jR518yGKeXDjH32D6?g_st=aw" target="_blank" rel="noopener" class="inline-flex items-center gap-2 btn-gradient text-white font-bold px-6 py-3 rounded-xl shadow-md text-sm">
                            <i data-lucide="navigation"></i> Buka Google Maps
                        </a>
                    </div>

                    <div class="h-64 lg:h-80 rounded-2xl overflow-hidden border border-brand-border">
                        <iframe src="https://www.google.com/maps?q=Warmindo+Smokey,+Jl.+Jend.+Achmad+Yani,+Api-Api,+Bontang+Utara,+Kota+Bontang&output=embed" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Warmindo Smokey"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-8 border-t border-brand-border/40 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4">
            <p>© 2026 WM SMOKY. Built for Gen Z Vibe.</p>
        </div>
    </footer>

    <!-- MODAL CUSTOMIZATION MENU -->
    <div id="custom-modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="glass w-full max-w-lg rounded-3xl p-6 border border-brand-border relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 mb-6">
                <img id="modal-img" src="" alt="Menu" class="w-20 h-20 object-cover rounded-2xl">
                <div>
                    <h3 id="modal-title" class="text-xl font-bold text-white"></h3>
                    <p id="modal-price" class="text-brand-yellow font-bold text-lg"></p>
                </div>
            </div>

            <!-- Level Pedas -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-300 mb-2">Level Pedas (Smoky Chili):</label>
                <div class="grid grid-cols-5 gap-2" id="spicy-levels">
                    <button onclick="selectSpicy(0)" class="spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card hover:border-brand-orange" data-level="0">Lvl 0<br><span class="text-[10px] font-normal">Ori</span></button>
                    <button onclick="selectSpicy(1)" class="spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card hover:border-brand-orange" data-level="1">Lvl 1<br><span class="text-[10px] font-normal">Sedang</span></button>
                    <button onclick="selectSpicy(2)" class="spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card hover:border-brand-orange" data-level="2">Lvl 2<br><span class="text-[10px] font-normal">Pedas</span></button>
                    <button onclick="selectSpicy(3)" class="spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card hover:border-brand-orange" data-level="3">Lvl 3<br><span class="text-[10px] font-normal">Nangis</span></button>
                    <button onclick="selectSpicy(4)" class="spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card hover:border-brand-orange" data-level="4">Lvl 5<br><span class="text-[10px] font-normal">Smoky Hot</span></button>
                </div>
            </div>

            <!-- Topping Options -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-300 mb-2">Tambah Topping (Opsional):</label>
                <div class="space-y-2" id="topping-list">
                    <!-- Dynamic Toppings -->
                </div>
            </div>

            <!-- Total Modal & Add Button -->
            <div class="flex items-center justify-between pt-4 border-t border-brand-border">
                <div>
                    <span class="text-xs text-slate-400">Subtotal:</span>
                    <p id="modal-subtotal" class="text-xl font-extrabold text-white">Rp 0</p>
                </div>
                <button onclick="confirmAddToCart()" class="btn-gradient text-white font-bold px-6 py-3 rounded-xl text-sm shadow-md flex items-center gap-2">
                    <i data-lucide="plus"></i> Tambahkan
                </button>
            </div>
        </div>
    </div>

    <!-- CART DRAWER -->
    <div id="cart-drawer" class="fixed inset-y-0 right-0 w-full sm:w-96 bg-[#0D0E15] border-l border-brand-border z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6 border-b border-brand-border flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="shopping-bag" class="text-brand-orange"></i>
                <h3 class="font-bold text-lg text-white">Keranjang Kamu</h3>
            </div>
            <button onclick="toggleCart()" class="text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <div id="cart-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <!-- Cart Items Rendered Here -->
        </div>

        <!-- Checkout Form -->
        <div class="p-6 border-t border-brand-border bg-brand-card/50 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Pemesan</label>
                <input type="text" id="customer-name" placeholder="misal: Alifian" class="w-full bg-brand-card border border-brand-border rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-orange">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Tipe Pesanan</label>
                <select id="order-type" class="w-full bg-brand-card border border-brand-border rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-orange">
                    <option value="Dine-In">Makan di Tempat (Dine-In)</option>
                    <option value="Takeaway">Bungkus (Takeaway)</option>
                    <option value="Delivery">Delivery Bontang Area</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor Meja / Catatan</label>
                <input type="text" id="table-note" placeholder="Meja 05 / Jangan pake daun bawang" class="w-full bg-brand-card border border-brand-border rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-brand-orange">
            </div>

            <div class="pt-2 border-t border-brand-border flex justify-between items-center">
                <span class="text-sm font-semibold text-slate-400">Total Pembayaran:</span>
                <span id="cart-total" class="text-xl font-bold text-brand-yellow">Rp 0</span>
            </div>

            <button onclick="checkoutWhatsApp()" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-3.5 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-green-600/20">
                <i data-lucide="message-square" class="w-4 h-4"></i> Pesan via WhatsApp
            </button>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // DATA MENU
        const menuData = [
            { id: 1, name: "Indomie Dok-Dok Smoky", category: "mie", price: 15000, img: "https://images.unsplash.com/photo-1612927601601-6638404737ce?auto=format&fit=crop&w=500&q=80", desc: "Mie dengan kuah kental gurih beraroma smoky khas wajan panas." },
            { id: 2, name: "Indomie Goreng Double Kornet", category: "mie", price: 18000, img: "https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=500&q=80", desc: "Porsi double dengan topping kornet sapi melimpah & telur dadar." },
            { id: 3, name: "Ricebowl Ayam Smoky BBQ", category: "rice", price: 20000, img: "https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&w=500&q=80", desc: "Nasi hangat + Ayam fillet goreng tepung disiram saus BBQ smoky." },
            { id: 4, name: "Dimsum Mix Smoky (4pcs)", category: "snack", price: 15000, img: "https://images.unsplash.com/photo-1496116218417-1a781b1c416c?auto=format&fit=crop&w=500&q=80", desc: "Dimsum ayam, udang, dan nori disajikan hangat dengan chili oil." },
            { id: 5, name: "Kentang Goreng Smoky Seasoning", category: "snack", price: 12000, img: "https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&w=500&q=80", desc: "French fries renyah tabur bumbu smoky balado / keju." },
            { id: 6, name: "Es Teh Manis Smoky Jumbo", category: "drink", price: 6000, img: "https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=500&q=80", desc: "Penyegar dahaga porsi jumbo khas anak nongkrong." },
            { id: 7, name: "Nutrisari Bledek Fresh", category: "drink", price: 7000, img: "https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=500&q=80", desc: "Nutrisari rasa jeruk/mangga dingin segar." }
        ];

        const toppingsData = [
            { name: "Telur Ceplok / Dadar", price: 4000 },
            { name: "Keju Parut", price: 3000 },
            { name: "Kornet Sapi", price: 5000 },
            { name: "Sosis Smoky", price: 4000 }
        ];

        const categories = [
            { id: "all", label: "Semua" },
            { id: "mie", label: "Mie Smoky" },
            { id: "rice", label: "Ricebowl" },
            { id: "snack", label: "Snack" },
            { id: "drink", label: "Minuman" }
        ];

        let selectedCategory = "all";
        let cart = [];
        let currentModalItem = null;
        let selectedLevel = 0;
        let selectedToppings = [];

        // INITIALIZE
        document.addEventListener("DOMContentLoaded", () => {
            renderCategories();
            renderMenu();
            lucide.createIcons();
        });

        // RENDER CATEGORIES
        function renderCategories() {
            const container = document.getElementById("category-buttons");
            container.innerHTML = categories.map(cat => `
                <button onclick="setCategory('${cat.id}')" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap ${selectedCategory === cat.id ? 'btn-gradient text-white' : 'bg-brand-card text-slate-400 hover:text-white border border-brand-border'}">
                    ${cat.label}
                </button>
            `).join('');
        }

        function setCategory(id) {
            selectedCategory = id;
            renderCategories();
            renderMenu();
        }

        // RENDER MENU
        function renderMenu() {
            const grid = document.getElementById("menu-grid");
            const search = document.getElementById("search-input").value.toLowerCase();

            const filtered = menuData.filter(item => {
                const matchCategory = selectedCategory === "all" || item.category === selectedCategory;
                const matchSearch = item.name.toLowerCase().includes(search) || item.desc.toLowerCase().includes(search);
                return matchCategory && matchSearch;
            });

            if (filtered.length === 0) {
                grid.innerHTML = `<p class="col-span-full text-center text-slate-500 py-12">Menu tidak ditemukan...</p>`;
                return;
            }

            grid.innerHTML = filtered.map(item => `
                <div class="glass rounded-2xl overflow-hidden border border-brand-border flex flex-col justify-between hover:border-brand-orange/50 transition group">
                    <div>
                        <div class="relative overflow-hidden h-44">
                            <img src="${item.img}" alt="${item.name}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-white text-base mb-1">${item.name}</h3>
                            <p class="text-xs text-slate-400 mb-3 line-clamp-2">${item.desc}</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex items-center justify-between">
                        <span class="font-bold text-brand-yellow text-sm">Rp ${item.price.toLocaleString('id-ID')}</span>
                        <button onclick="openModal(${item.id})" class="bg-brand-card hover:bg-brand-orange text-white p-2.5 rounded-xl border border-brand-border transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            lucide.createIcons();
        }

        // MODAL CUSTOMIZATION
        function openModal(itemId) {
            currentModalItem = menuData.find(i => i.id === itemId);
            selectedLevel = 0;
            selectedToppings = [];

            document.getElementById("modal-img").src = currentModalItem.img;
            document.getElementById("modal-title").innerText = currentModalItem.name;
            document.getElementById("modal-price").innerText = `Rp ${currentModalItem.price.toLocaleString('id-ID')}`;

            // Render Toppings
            const toppingContainer = document.getElementById("topping-list");
            toppingContainer.innerHTML = toppingsData.map((t, idx) => `
                <label class="flex items-center justify-between bg-brand-card p-2.5 rounded-xl border border-brand-border cursor-pointer hover:border-brand-orange/40">
                    <span class="text-xs text-slate-300 font-semibold">${t.name} (+Rp ${t.price.toLocaleString('id-ID')})</span>
                    <input type="checkbox" onchange="toggleTopping(${idx})" class="accent-brand-orange w-4 h-4">
                </label>
            `).join('');

            updateSpicyButtons();
            updateModalSubtotal();
            document.getElementById("custom-modal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("custom-modal").classList.add("hidden");
        }

        function selectSpicy(lvl) {
            selectedLevel = lvl;
            updateSpicyButtons();
        }

        function updateSpicyButtons() {
            const btns = document.querySelectorAll(".spicy-btn");
            btns.forEach((btn, idx) => {
                if (idx === selectedLevel) {
                    btn.className = "spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-orange bg-brand-orange text-white";
                } else {
                    btn.className = "spicy-btn py-2 text-xs font-bold rounded-xl border border-brand-border bg-brand-card text-slate-400 hover:border-brand-orange";
                }
            });
        }

        function toggleTopping(idx) {
            const topping = toppingsData[idx];
            const existIndex = selectedToppings.findIndex(t => t.name === topping.name);
            if (existIndex > -1) {
                selectedToppings.splice(existIndex, 1);
            } else {
                selectedToppings.push(topping);
            }
            updateModalSubtotal();
        }

        function updateModalSubtotal() {
            const toppingTotal = selectedToppings.reduce((sum, t) => sum + t.price, 0);
            const total = currentModalItem.price + toppingTotal;
            document.getElementById("modal-subtotal").innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function confirmAddToCart() {
            const toppingTotal = selectedToppings.reduce((sum, t) => sum + t.price, 0);
            const itemPrice = currentModalItem.price + toppingTotal;
            const levelNames = ["Level 0 (Ori)", "Level 1 (Sedang)", "Level 2 (Pedas)", "Level 3 (Nangis)", "Level 5 (Smoky Hot)"];

            const cartItem = {
                id: Date.now(),
                name: currentModalItem.name,
                level: levelNames[selectedLevel],
                toppings: selectedToppings.map(t => t.name),
                price: itemPrice,
                qty: 1
            };

            cart.push(cartItem);
            closeModal();
            updateCart();
            toggleCart();
        }

        // BUNDLE ADD TO CART
        function addBundleToCart(bundleName, bundlePrice) {
            cart.push({
                id: Date.now(),
                name: bundleName,
                level: "Standard",
                toppings: [],
                price: bundlePrice,
                qty: 1
            });
            updateCart();
            toggleCart();
        }

        // CART MANAGEMENT
        function toggleCart() {
            const drawer = document.getElementById("cart-drawer");
            drawer.classList.toggle("translate-x-full");
        }

        function updateCart() {
            const cartItemsContainer = document.getElementById("cart-items");
            const badge = document.getElementById("cart-badge");
            
            // Badge Count
            const totalQty = cart.reduce((sum, i) => sum + i.qty, 0);
            if (totalQty > 0) {
                badge.innerText = totalQty;
                badge.classList.remove("hidden");
            } else {
                badge.classList.add("hidden");
            }

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `<p class="text-center text-slate-500 text-sm py-12">Keranjang masih kosong nih.</p>`;
                document.getElementById("cart-total").innerText = "Rp 0";
                return;
            }

            let total = 0;
            cartItemsContainer.innerHTML = cart.map((item, idx) => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;
                return `
                    <div class="glass p-3 rounded-xl border border-brand-border flex items-center justify-between">
                        <div class="flex-1 pr-2">
                            <h4 class="text-xs font-bold text-white">${item.name}</h4>
                            <p class="text-[10px] text-brand-orange font-semibold">${item.level}</p>
                            ${item.toppings.length > 0 ? `<p class="text-[10px] text-slate-400">+ ${item.toppings.join(', ')}</p>` : ''}
                            <p class="text-xs font-bold text-brand-yellow mt-1">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="changeQty(${idx}, -1)" class="w-6 h-6 rounded-lg bg-brand-card hover:bg-brand-border text-white text-xs flex items-center justify-center border border-brand-border">-</button>
                            <span class="text-xs font-bold text-white">${item.qty}</span>
                            <button onclick="changeQty(${idx}, 1)" class="w-6 h-6 rounded-lg bg-brand-card hover:bg-brand-border text-white text-xs flex items-center justify-center border border-brand-border">+</button>
                        </div>
                    </div>
                `;
            }).join('');

            document.getElementById("cart-total").innerText = `Rp ${total.toLocaleString('id-ID')}`;
            lucide.createIcons();
        }

        function changeQty(idx, delta) {
            cart[idx].qty += delta;
            if (cart[idx].qty <= 0) {
                cart.splice(idx, 1);
            }
            updateCart();
        }

        // CHECKOUT WHATSAPP
        function checkoutWhatsApp() {
            if (cart.length === 0) {
                alert("Keranjang kamu masih kosong!");
                return;
            }

            const name = document.getElementById("customer-name").value.trim();
            const orderType = document.getElementById("order-type").value;
            const tableNote = document.getElementById("table-note").value.trim();

            if (!name) {
                alert("Tolong isi nama kamu ya!");
                return;
            }

            let text = `*HALO WM SMOKY BONTANG!* 🔥\nSaya mau pesan makanan:\n\n`;
            text += `👤 *Nama Pemesan:* ${name}\n`;
            text += `📌 *Tipe Pesanan:* ${orderType}\n`;
            if (tableNote) text += `📝 *Meja / Catatan:* ${tableNote}\n`;
            text += `\n*DETAIL PESANAN:*\n--------------------\n`;

            let grandTotal = 0;
            cart.forEach((item, i) => {
                const subtotal = item.price * item.qty;
                grandTotal += subtotal;
                text += `${i+1}. *${item.name}* (x${item.qty})\n`;
                text += `   • Level: ${item.level}\n`;
                if (item.toppings.length > 0) text += `   • Topping: ${item.toppings.join(', ')}\n`;
                text += `   • Subtotal: Rp ${subtotal.toLocaleString('id-ID')}\n\n`;
            });

            text += `--------------------\n`;
            text += `💰 *TOTAL PEMBAYARAN: Rp ${grandTotal.toLocaleString('id-ID')}*\n\n`;
            text += `Mohon segera diproses ya kak, terima kasih! 🔥`;

            const phone = "6281234567890"; // Ganti dengan nomor WhatsApp Warung
            const encodedText = encodeURIComponent(text);
            window.open(`https://wa.me/${phone}?text=${encodedText}`, '_blank');
        }
    </script>
</body>
</html>