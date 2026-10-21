# SPEC Warmindo Smoky

## 1. Ringkasan
Warmindo Smoky: landing katalog gelap, dashboard member terang, kasir Alpine, admin Blade, API JSON session-auth. Stack: Laravel 13.8, PHP ^8.3, MySQL `lara`, Blade + Alpine 3.4 + Tailwind 3.1 + Vite 8. Folder `warmindo-smoky/` React 18 + Vite 5 tidak terhubung backend, bukan build utama.

## 2. Peran dan akses
- Publik: `/`, `/api/products`, `/api/bundles`, `/api/warung-config`, `GET /ulasan`, `/login`, `/register`, `/admin/login`.
- Member (`role:user`): `/user`, `/member`, `GET|POST /api/orders`, `GET /api/payment-methods`, `POST /ulasan`, `/profile`.
- Kasir (`role:kasir,admin`): `/kasir`, `POST /kasir/pesanan`.
- Admin (`role:admin`): `/admin`, `/admin/{module}`, CRUD menu/bahan/produksi/pesanan/pengeluaran/pembayaran/bundling/catatan, `/admin-dashboard/*`, `/order-management/*`, `/api/admin/products*`.

Middleware: `role` = `EnsureUserHasRole`. Tanpa user redirect `login`. Role salah redirect: admin ke `dashboard.index`, kasir ke `kasir`, lain ke `user`.

Login member tolak admin/kasir: `AuthenticatedSessionController@store` logout lalu 422 `Akun admin/kasir wajib masuk lewat Login Admin.` Register selalu buat `role=user`.

## 3. Data
- `users`: name, email unik, role default `user`, password hash.
- `products`: name, harga decimal, description, category (`mie,indomie,rice,snack,drink,nasi,minum`), image `assets/menu/...`, stock, is_available, rating default 5.0, spice_level 0-5, is_best_seller.
- `bundles`: name, price, original_price nullable, badge, description, image, is_active, is_popular.
- `orders`: user_id nullable nullOnDelete, cashier_id, order_code `ORD-ymdHis-random`, customer_name, total decimal, payment_method string, status (`Menunggu,Pending,Diproses,Siap,Selesai,Batal`), notes max 500.
- `order_items`: order_id cascade, product_id nullable nullOnDelete (baris bundle boleh null), item_type default `product`, product_name, quantity, price, subtotal, options JSON string nullable.
- `payment_methods`: name, is_active.
- `reviews`: user_id, name, rating 1-5, text 4-500, is_approved.
- `ingredients`: name unik, unit, stock, minimum_stock, unit_cost.
- `production_stocks`, `expenses` (title, category, amount, spent_at), `admin_notes` (title, content, note_date), `system_settings` (key, value).
- Config `config/warung.php`: nama, alamat Bontang contoh, jam 19:00-00:00 WITA, WA contoh, maps OSM + Google link, testimonials contoh flag `testimonials_sample=true`, toppings, spice_levels, wifi dari env `WIFI_SSID` / `WIFI_PASSWORD`.

## 4. Aturan bisnis
- Harga order selalu dari DB (`products.harga`, `bundles.price`). `unit_price` klien diabaikan.
- Order member status awal `Menunggu`, total dihitung server dalam transaksi.
- Order kasir status langsung `Selesai`.
- Hapus order hanya bila `Menunggu`/`Pending`.
- Pembayaran order member harus aktif di `payment_methods`.
- Kasir validasi `items.*.product_id` distinct + exists, qty 1-99.
- Review auto `is_approved=true`, nama dari user login, HTML di-strip.
- Upload menu/bundling: jpg/jpeg/png/webp max 2MB ke `public/assets/menu`, nama file sanitize.
- Duplicate product dari guard `abort_unless products->has()` 422, bukan error 500.

## 5. Frontend
- `layouts.warmindo`: dark `#0d0d0d`, font Poppins + FontAwesome CDN, Vite CSS/JS, focus-visible kuning, reduced-motion, topbar sticky, nav Menu/Paket/Ulasan/Lokasi.
- `landing`: hero, katalog dari `$products`, paket dari `$bundles`, ulasan DB atau fallback config contoh bila kosong.
- `user.dashboard`: light `#FFF6E9`, antrian, WiFi dari config (SSID + password via `data-pw`), paket hemat, katalog + checkout JS `localStorage wms-cart`, pembayaran radio QRIS/Transfer/Tunai, struk thermal modal, tombol 44px.
- `kasir`: Alpine `cashier()`, klik menu tambah keranjang, hidden `items[index][product_id|quantity]`, total Intl IDR, transaksi terbaru 10.
- `admin`, `admin.module`, `admin.dashboard|settings|analytics|inventory`, `admin.order-management.*`: CRUD Blade, session status/error.
- `warmindo.blade.php` dan `warmindo.html` / `warmindo-smoky-single.html`: prototipe statis Tailwind CDN, bukan render route utama.

## 6. Batas dan TODO pemilik
- Alamat, nomor WA, ulasan config masih contoh Bontang. Konfirmasi asli sebelum produksi.
- `warmindo-smoky/` React tidak dipakai backend. Putuskan: hapus atau integrasi API token.
- Export PDF order masih return view print, belum DOMPDF.
- Tidak ada API token / rate-limit publik. Cocok warung kecil, bukan marketplace.
