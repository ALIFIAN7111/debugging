# LAPORAN AUDIT Warmindo Smoky

Tanggal: 7 Oktober 2026. Bahasa Indonesia. Hanya hasil yang benar-benar dijalankan.

## Tahap 1 — Pemetaan (selesai)
- Stack: Laravel 13.8, PHP 8.5.9 CLI, MySQL `lara`, Blade + Alpine 3.4 + Tailwind 3.1 + Vite 8. Folder `warmindo-smoky/` React 18 + Vite 5 tidak terhubung backend.
- Route: `routes/web.php` 75+ route (landing, member, kasir, admin CRUD, dashboard, order-management, ulasan, profile, auth Breeze). `routes/api.php` publik + session-auth + admin.
- Fitur jalan: katalog, paket, ulasan, checkout member, kasir, admin menu/bahan/produksi/pesanan/pengeluaran/pembayaran/bundling/catatan, analitik, inventori, settings.
- File kunci: `routes/web.php`, `routes/api.php`, `WarmindoController`, `DashboardController`, `OrderManagementController`, `landing.blade.php`, `user/dashboard.blade.php`, `kasir.blade.php`, `config/warung.php`.

## Tahap 2 — Cek error (dijalankan)
- `npm run build` sukses: Vite 8.2.1, `manifest.json 0.33 kB`, `app.css 71.30 kB`, `app.js 46.30 kB`.
- `php artisan migrate:status`: 16 Ran.
- `php artisan test` awal: Feature FAIL semua karena `ALTER TABLE order_items MODIFY ...` syntax error di SQLite memory. Setelah fix: `25 passed (61 assertions)`.
- `./vendor/bin/pint --test` awal: FAIL 85 files, 10 style issues. Setelah `./vendor/bin/pint`: `83 files PASS`.
- HTTP `http://127.0.0.1:8001/`: `/` 200, `/login` 200, `/api/products` 200 (9 item), `/api/bundles` 200, `/api/warung-config` 200, `/ulasan` 200, `/up` 200, `/not-found-xyz` 404 tepat, `/api/orders` 401 tepat, `/api/payment-methods` 401 tepat, `/api/admin/products` 401 tepat, `POST /ulasan` tanpa CSRF 419 tepat, `POST /api/orders` tanpa auth 401 tepat.
- `php artisan db:show` error `1146 Table 'performance_schema.session_status' doesn't exist` — issue hak akses MySQL, bukan kode aplikasi.

## Tahap 3 — Uji API per skenario (dijalankan)
- Sukses publik: products/bundles/warung-config/ulasan 200 + isi valid (harga float, discount_percent hitung server).
- Tanpa auth: orders/payment-methods/admin-products 401 tepat.
- Tidak ketemu: 404 tepat. Health `/up` 200.
- Invalid/CSRF: POST ulasan tanpa token 419 tepat (anti-spam web). POST orders tanpa auth 401 sebelum validasi.
- Skenario login + checkout auth penuh belum dijalankan via HTTP otomatis karena butuh session + CSRF browser. Test Pest auth (login/register/logout) PASS sebagai pengganti.
- Dokumen: `API.md` berisi method, URL, body, aturan, contoh sukses/gagal.

## Tahap 4 — Standar kompetensi SKKNI J.620100 (mapping jujur)
- J.620100.004 Kualifikasi kerja: peran admin/kasir/member jelas, middleware role, register kunci `user`.
- J.620100.009 Desain program: SPEC peran-data-aturan-frontend-batas ditulis `SPEC.md`.
- J.620100.011/012/013/014 Implementasi dan testing: Pint PASS, Pest 25 passed, build sukses, HTTP skenario diuji.
- J.620100.017 Dokumentasi: `API.md`, `SPEC.md`, `README-WARMINDO.md`, laporan ini.
- J.620100.023 Keamanan: harga server-side, validasi ketat, CSRF, role redirect, WiFi pindah env. Sisa: tanpa rate-limit API, tanpa API token, data contoh belum verifikasi pemilik.
- Tidak klaim sertifikasi resmi. Mapping ini klaim kesesuaian praktik, bukan lulus uji asesor.

## Tahap 5 — Perbaikan minimal yang dilakukan
1. `database/migrations/2026_09_10_120000_create_order_items_table.php`: `product_id` nullable + `nullOnDelete` sejak awal. Alasan: baris bundle butuh null lintas MySQL/SQLite. Risiko: DB lama yang sudah migrate tetap NOT NULL sampai `MODIFY` MySQL jalan. Tidak ubah data.
2. `database/migrations/2026_10_06_140000_add_dark_landing_fields.php`: `MODIFY` hanya bila driver `mysql`, `down()` sama. Alasan: perbaiki `php artisan test` SQLite. Tidak ubah skema MySQL.
3. `routes/api.php`: hapus `items.*.unit_price` dari validasi, harga product selalu `(float) $product->harga`. Alasan: cegah manipulasi harga dari klien. Kontrak API berubah kecil aman (field diabaikan sebelumnya pun rawan). Bundle tetap harga DB.
4. `routes/web.php` kasir: tambah `abort_unless products->has() 422`. Alasan: cegah error 500 bila ID hilang balapan. Perilaku valid berubah 500 ke 422 tepat.
5. `OrderManagementController@store`: guard sama 422. Alasan sama.
6. `DashboardController@analytics`: `MONTH()` ganti ekspresi lintas DB (`strftime` SQLite, `MONTH` MySQL). Alasan: analitik jalan di test SQLite. Output bulan SQLite string `01`-`12` vs MySQL int, chart Blade tetap tampil angka.
7. `database/factories/UserFactory.php`: tambah `'role' => 'user'`. Alasan: test factory sebelum ini role null / default DB. Tidak ubah produksi.
8. `config/warung.php` + `.env` + `.env.example` + `user/dashboard.blade.php`: WiFi SSID/password pindah env `WIFI_SSID`/`WIFI_PASSWORD`. Alasan: password `smokyhemat2026` tadinya hardcoded di `data-pw`. Nilai default masih sama sampai pemilik ganti env. Perlu `php artisan config:clear` bila cache.
9. `resources/views/kasir.blade.php`: hapus hidden `items` disabled mati. Alasan: input disabled tidak terkirim, hanya noise. Form asli pakai `items[index]` template.
10. Hapus kode mati (disetujui user hapus aman): `app/Http/Controllers/tesController.php`, `resources/views/TES2.blade.php`, `app/Http/Middleware/AdminMiddleware.php` (pass-through tak dipakai, grep hanya autoload). `composer dump-autoload` timeout 120 detik saat verifikasi, autoload lama masih referensi class hapus sampai dump ulang sukses.
11. `./vendor/bin/pint`: 9 style issues fixed (concat space, unused import, braces, dst). Tidak ubah logika.
12. Dokumen baru: `API.md`, `SPEC.md`, `README-WARMINDO.md`, `LAPORAN_AUDIT.md`. `README.md` bawaan Laravel tidak diubah.

Tidak dilakukan (butuh izin / risiko besar):
- Tidak hapus `warmindo-smoky/` React, `warmindo.html`, `warmindo-smoky-single.html`, `warmindo.blade.php` prototipe.
- Tidak ubah struktur DB selain nullable di atas.
- Tidak tambah rate-limit / API token / DOMPDF.
- Tidak ganti alamat/WA/ulasan contoh. Konfirmasi pemilik dulu.

## Tahap 6 — Verifikasi akhir (dijalankan)
- `php artisan test`: 25 passed.
- `./vendor/bin/pint --test`: 83 files PASS.
- `npm run build`: sukses 8.34 detik.
- HTTP ulang 11 URL: 7×200, 3×401 tepat, 1×404 tepat.
- Sisa warning: `composer dump-autoload` timeout (autoload class mati masih cache), `db:show` performance_schema 1146 (hak DB), WiFi default masih password lama di env lokal sampai diganti produksi.

## Cara run/build (singkat)
`composer install`, copy `.env.example` ke `.env`, `php artisan key:generate`, isi DB + WIFI, `php artisan migrate`, `npm install`, `npm run build`, `php artisan serve --port=8001`. Detail di `README-WARMINDO.md`.
