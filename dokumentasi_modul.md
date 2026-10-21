# Dokumentasi Modul — Warmindo Smoky

**Fase:** 2 — Persiapan Lingkungan Pengembangan  
**Tanggal:** 18 Oktober 2026

Project memakai Laravel. Nama modul pada instruksi PHP native dipetakan ke struktur Laravel yang sudah ada. Dokumen ini tidak mengubah kode.

## 1. Modul Koneksi Database

| Bagian | Keterangan |
|---|---|
| Nama modul | Koneksi Database Laravel |
| Padanan file PHP native | `includes/koneksi.php` |
| Implementasi project | Konfigurasi Laravel melalui `.env` dan `config/database.php`; akses data memakai Eloquent serta `DB` facade. |
| Tujuan | Menghubungkan aplikasi dengan database aktif tanpa menulis koneksi PDO manual di setiap halaman. |
| Keamanan | Kredensial disimpan pada `.env`; query Eloquent/Query Builder memakai parameter binding. |
| Catatan aman | File `.env` tidak diubah tanpa persetujuan karena dapat memutus koneksi database. |

## 2. Modul Menu

| Bagian | Keterangan |
|---|---|
| Nama modul | Menu dan Harga |
| Padanan file PHP native | `menu.php` |
| Implementasi project | Model `Product`, route `/user`, route dan modul admin menu. |
| Tujuan | Menampilkan katalog menu serta mengelola nama, harga, kategori, stok, gambar, dan deskripsi menu. |
| Input utama | `name`, `harga`, `category`, `stock`, `description`, `image`. |
| Validasi teramati | Nama wajib, harga numerik, kategori dibatasi, stok bilangan bulat, gambar bertipe JPG/JPEG/PNG/WebP maksimal 2 MB. |
| Output | Daftar menu pada katalog atau pesan berhasil/gagal saat admin menyimpan menu. |

## 3. Modul Keranjang dan Kasir

| Bagian | Keterangan |
|---|---|
| Nama modul | Keranjang/Kasir |
| Padanan file PHP native | `keranjang.php` |
| Implementasi project | Route `/kasir` dan `POST /kasir/pesanan`. |
| Tujuan | Memilih produk, menentukan jumlah, memilih pembayaran, lalu membuat transaksi. |
| Input utama | `items`, `items.*.product_id`, `items.*.quantity`, `customer_name`, `payment_method`, `notes`. |
| Validasi teramati | Minimal satu item, ID produk harus ada, jumlah minimal 1 maksimal 99, metode pembayaran harus aktif. |
| Output | Pesanan dan detail item disimpan; kasir menerima pesan status transaksi. |
| Optimasi | Produk item diambil sekali dengan `whereIn`, bukan query berulang di dalam loop. |

## 4. Modul Checkout/Pesanan

| Bagian | Keterangan |
|---|---|
| Nama modul | Checkout dan Pesanan |
| Padanan file PHP native | `checkout.php` |
| Implementasi project | Route `POST /kasir/pesanan`, model `Order`, dan relasi item pesanan. |
| Tujuan | Memvalidasi input lalu menyimpan pesanan utama, item pesanan, dan total transaksi. |
| Proses | Buat order awal, hitung subtotal tiap item, simpan item, hitung total, kemudian perbarui total order. |
| Keamanan | Menggunakan `DB::transaction()` agar seluruh proses gagal bersama bila ada langkah yang error. |
| Output | Pesan `Transaksi berhasil disimpan.` bila transaksi selesai. |

## 5. Modul Admin

| Bagian | Keterangan |
|---|---|
| Nama modul | Dashboard dan Administrasi |
| Padanan file PHP native | `admin.php` |
| Implementasi project | Route `/admin` dan `/admin/{module}`. |
| Tujuan | Melihat statistik serta mengelola menu, stok bahan, stok produksi, pesanan, pengeluaran, pembayaran, catatan, bundling, dan analitik. |
| Akses | Hanya akun dengan role `admin`. |
| Data ringkasan | Jumlah user, produk, bahan, stok rendah, pesanan hari ini, pendapatan, dan pengeluaran. |
| Keamanan | Middleware `auth` dan `role:admin` membatasi halaman admin. |

## 6. Modul Upload Gambar

| Bagian | Keterangan |
|---|---|
| Implementasi project | Proses tambah menu melalui route `POST /admin/menu`. |
| Tujuan | Menyimpan gambar menu yang diunggah admin. |
| Lokasi simpan saat ini | `public/assets/menu/`. |
| Validasi | File wajib berupa gambar; ekstensi diizinkan: JPG, JPEG, PNG, WebP; ukuran maksimum 2 MB. |
| Nama file | Nama asli dibersihkan lalu diberi prefix waktu untuk mengurangi konflik nama. |
| Catatan | Folder dan mekanisme upload tidak diubah dalam fase dokumentasi. |

## 7. Modul Riwayat dan Analitik Pesanan

| Bagian | Keterangan |
|---|---|
| Implementasi project | Pesanan terbaru pada kasir/admin dan modul admin `pesanan` serta `analitik`. |
| Tujuan | Meninjau pesanan, omzet, produk terlaris, dan data operasional. |
| Optimasi | Pesanan terbaru dibatasi dengan `take(10)`/`take(5)`; produk terlaris memakai agregasi database dengan `limit(5)`. |
| Pengguna | Kasir melihat pesanan terbaru; admin melihat seluruh data sesuai hak akses. |
