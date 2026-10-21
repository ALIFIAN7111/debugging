# Diagram Program — Warmindo Smoky

**Fase:** 2 — Persiapan Lingkungan Pengembangan  
**Tanggal:** 18 Oktober 2026

Dokumen ini adalah rancangan alur. Dokumen tidak menjalankan kode, tidak mengubah route, dan tidak mengubah database.

## 1. Alur Pelanggan Memilih Menu

```mermaid
flowchart TD
    A[Pengunjung membuka halaman utama] --> B[Melihat katalog menu]
    B --> C{Pilih kategori atau menu}
    C -->|Kategori| D[Filter daftar menu]
    D --> B
    C -->|Menu| E[Melihat detail menu]
    E --> F{Menu tersedia?}
    F -->|Tidak| G[Tampilkan informasi stok habis]
    G --> B
    F -->|Ya| H[Tambahkan menu ke keranjang]
    H --> I[Keranjang diperbarui]
    I --> J{Lanjut belanja?}
    J -->|Ya| B
    J -->|Tidak| K[Masuk halaman checkout]
    K --> L[Isi data pembeli dan catatan]
    L --> M{Data valid dan keranjang tidak kosong?}
    M -->|Tidak| N[Tampilkan pesan validasi]
    N --> L
    M -->|Ya| O[Simpan pesanan]
    O --> P[Kurangi stok bila fitur stok produk diterapkan]
    P --> Q[Tampilkan konfirmasi pesanan]
```

## 2. Alur Kasir Membuat Pesanan

```mermaid
flowchart TD
    A[Kasir login] --> B[Buka halaman kasir]
    B --> C[Pilih menu dan jumlah]
    C --> D[Masukkan nama pelanggan opsional]
    D --> E[Pilih metode pembayaran]
    E --> F{Input valid?}
    F -->|Tidak| G[Tampilkan pesan kesalahan]
    G --> C
    F -->|Ya| H[Ambil produk dengan satu query]
    H --> I[Buat pesanan dalam transaksi database]
    I --> J[Simpan item pesanan]
    J --> K[Hitung dan simpan total]
    K --> L[Tampilkan status transaksi berhasil]
```

## 3. Alur Admin Mengelola Menu

```mermaid
flowchart TD
    A[Admin login] --> B[Buka dashboard admin]
    B --> C[Pilih modul Menu dan Harga]
    C --> D{Aksi admin}
    D -->|Tambah| E[Isi data menu dan gambar]
    D -->|Ubah| F[Pilih menu lalu ubah data]
    D -->|Hapus| G[Pilih menu untuk dihapus]
    E --> H{Data dan file gambar valid?}
    F --> H
    H -->|Tidak| I[Tampilkan pesan validasi]
    I --> E
    H -->|Ya| J[Simpan data menu]
    G --> K{Menu aman dihapus?}
    K -->|Tidak| L[Tolak atau tampilkan alasan]
    K -->|Ya| M[Hapus data menu]
    J --> N[Tampilkan pesan berhasil]
    M --> N
    N --> C
```

## 4. Deskripsi Halaman Utama

| Halaman/route Laravel | Tujuan | Pengguna | Data utama |
|---|---|---|---|
| `/` | Beranda Warmindo Smoky dan akses awal katalog. | Pengunjung | Produk dan bundling dari aplikasi. |
| `/user` | Halaman pelanggan setelah login. Menampilkan katalog produk dan bundling. | User | `products`, `bundles`, pengaturan katalog. |
| `/kasir` | Membuat transaksi menu dan melihat pesanan terbaru. | Admin, kasir | Produk, metode pembayaran, pesanan terbaru. |
| `/admin` | Dashboard ringkasan operasional. | Admin | Statistik produk, stok, pesanan, pendapatan, pengeluaran. |
| `/admin/menu` | Proses simpan menu baru dari form admin. | Admin | Nama, harga, kategori, stok, gambar, deskripsi. |
| `/admin/pesanan` | Modul melihat data pesanan. | Admin | Data pesanan. |

## 5. Pemetaan Nama Halaman Tugas ke Project Laravel

Instruksi tugas awal menyebut `index.php`, `menu.php`, `keranjang.php`, dan `checkout.php`. Project Warmindo Smoky memakai Laravel, sehingga fungsi sepadan dipetakan sebagai berikut.

| Nama halaman tugas | Padanan pada Warmindo Smoky | Keterangan |
|---|---|---|
| `index.php` | Route `/` dan controller `WarmindoController` | Halaman awal aplikasi. |
| `menu.php` | Route `/user`, view katalog, model `Product` | Katalog menu pelanggan. |
| `keranjang.php` | Interaksi keranjang pada halaman kasir/pelanggan | Perlu verifikasi view spesifik saat audit fitur penuh. |
| `checkout.php` | `POST /kasir/pesanan` | Validasi lalu simpan order dan item order. |
| `admin.php` | Route `/admin` dan `/admin/{module}` | Dashboard serta modul admin. |
