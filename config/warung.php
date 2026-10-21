<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WM SMOKY — Satu konfigurasi warung
    |--------------------------------------------------------------------------
    | Alamat, jam buka, dan kontak diambil dari sini supaya konsisten
    | di hero, lokasi, dan footer. TODO: konfirmasi alamat + nomor WA
    | asli ke pemilik (saat ini masih contoh Bontang).
    |
    */
    'name' => 'WARMINDO SMOKY',
    'sub' => 'BONTANG HITZ',
    'address' => 'Warmindo Smokey, Jl. Jend. Achmad Yani, Api-Api, Kec. Bontang Utara, Kota Bontang, Kalimantan Timur 75313',
    // Alamat + link Maps terverifikasi dari pemilik.
    'open_time' => '19:00',
    'close_time' => '00:00',
    'timezone_label' => 'WITA',
    'phone_display' => '+62 812-3456-7890',
    'phone_wa' => '6281234567890', // TODO: ganti nomor WA asli warung
    'wa_greeting' => 'Halo WM SMOKY! Saya mau tanya menu.',
    'email' => 'halo@wmsmoky.id',
    // Embed tanpa API key (Google Maps query Warmindo Smokey). Fallback: tombol Google Maps.
    'maps_embed' => 'https://www.google.com/maps?q=Warmindo+Smokey,+Jl.+Jend.+Achmad+Yani,+Api-Api,+Bontang+Utara,+Kota+Bontang&output=embed',
    'maps_link' => 'https://maps.app.goo.gl/jR518yGKeXDjH32D6?g_st=aw',
    'instagram' => 'https://instagram.com/wmsmoky',
    'tiktok' => 'https://tiktok.com/@wmsmoky',

    // TODO: ganti dengan ulasan asli pelanggan. Ini contoh, jangan tampilkan sebagai nyata di produksi.
    'testimonials_sample' => true,
    'testimonials' => [
        ['name' => 'Contoh — Rara', 'text' => 'Mie dok-dok smoky-nya nagih, porsinya pas buat nongkrong.'],
        ['name' => 'Contoh — Dimas', 'text' => 'Rice bowl chicken-nya juicy, es red velvet-nya creamy.'],
        ['name' => 'Contoh — Salsa', 'text' => 'Tempatnya rame tapi pesanan cepat, WiFi kencang.'],
    ],

    'toppings' => [
        ['name' => 'Telur Ceplok / Dadar', 'price' => 4000],
        ['name' => 'Keju Parut', 'price' => 3000],
        ['name' => 'Kornet Sapi', 'price' => 5000],
        ['name' => 'Sosis Smoky', 'price' => 4000],
    ],

    // Kredensial WiFi member — ambil dari .env agar tidak hardcoded di view.
    // Pasang WIFI_SSID / WIFI_PASSWORD di .env produksi, ganti tiap minggu.
    'wifi_ssid' => env('WIFI_SSID', 'WMSMOKY-5G'),
    'wifi_password' => env('WIFI_PASSWORD', 'smokyhemat2026'),

    'spice_levels' => ['Lvl 0 Ori', 'Lvl 1 Sedang', 'Lvl 2 Pedas', 'Lvl 3 Nangis', 'Lvl 5 Smoky Hot'],
];
