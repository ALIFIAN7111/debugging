# Metode Pengembangan — Warmindo Smoky

**Fase:** 2 — Persiapan Lingkungan Pengembangan  
**Metode:** Waterfall  
**Tanggal:** 18 Oktober 2026

## Alasan Memakai Waterfall

Project Warmindo Smoky memakai metode Waterfall karena kebutuhan utama sudah jelas: katalog menu, pesanan, kasir, admin, pembayaran, dan laporan. Setiap tahap diselesaikan serta didokumentasikan sebelum tahap berikutnya dimulai. Cara ini memudahkan bukti penilaian kompetensi Junior Coder.

## Tahap 1 — Requirements (Analisis Kebutuhan)

Tujuan: menentukan kebutuhan aplikasi dan data yang diproses.

Kegiatan:

1. Menentukan pengguna: pelanggan, kasir, dan admin.
2. Menentukan fitur: katalog menu, pesanan, kasir, pengelolaan menu, stok, dan riwayat pesanan.
3. Menentukan data: produk/menu, pelanggan, pesanan, item pesanan, metode pembayaran, dan stok.
4. Menentukan kebutuhan keamanan: login, pembatasan peran pengguna, validasi input, dan query database aman.

Output:

- `struktur_data.md`
- `database.sql` sebagai rancangan awal data
- Daftar fitur project

## Tahap 2 — Design (Perancangan)

Tujuan: membuat rancangan alur program, halaman, modul, serta fungsi sebelum perubahan kode dilakukan.

Kegiatan:

1. Membuat diagram alur pelanggan dari halaman menu sampai pesanan tersimpan.
2. Membuat diagram alur kasir dan admin.
3. Mendeskripsikan halaman serta modul yang ada.
4. Menentukan fungsi Laravel yang menangani menu, pesanan, validasi, upload gambar, dan akses database.

Output:

- `diagram_program.md`
- `dokumentasi_modul.md`
- `dokumentasi_fungsi.md`

## Tahap 3 — Implementation (Implementasi)

Tujuan: menerapkan rancangan ke kode Laravel Warmindo Smoky secara bertahap.

Kegiatan:

1. Memeriksa kode yang sudah ada sebelum mengubah apa pun.
2. Mengubah hanya file yang diperlukan setelah persetujuan.
3. Menjaga nama folder dan nama project tetap sama.
4. Menerapkan validasi request, Eloquent/Query Builder, transaksi database, dan pembatasan akses peran.
5. Melakukan pengecekan sintaks serta uji fitur sesudah setiap perubahan.

Output:

- Fitur berjalan sesuai rancangan
- Catatan perubahan dan perbaikan

## Tahap 4 — Testing (Pengujian)

Tujuan: memastikan fitur berjalan, input tidak merusak aplikasi, dan hasil sesuai kebutuhan.

Kegiatan:

1. Menulis rencana pengujian dan data uji.
2. Menguji menu, kategori, pesanan, validasi, hak akses, SQL injection, dan XSS.
3. Mencatat hasil PASS/FAIL serta bug yang ditemukan.
4. Memperbaiki bug hanya setelah penyebab diketahui.

Output:

- `test_plan.md`
- `data_uji.sql` atau data uji sesuai database aktif
- `hasil_testing.md`
- `evaluasi_testing.md`

## Tahap 5 — Maintenance (Pemeliharaan)

Tujuan: menjaga aplikasi tetap stabil setelah pengujian.

Kegiatan:

1. Memantau error dan masukan pengguna.
2. Mencadangkan database sebelum perubahan berisiko.
3. Memperbaiki bug satu per satu.
4. Mendokumentasikan perubahan pada `changelog.md`.
5. Menguji ulang fitur terkait setelah perbaikan.

Output:

- `changelog.md`
- Catatan hasil pengujian ulang

## Aturan Aman Tiap Tahap

1. Tidak menghapus atau mengganti file berjalan tanpa persetujuan eksplisit.
2. Tidak menjalankan migration, SQL, atau perintah database tanpa konfirmasi.
3. Tidak mengubah nama folder `warmindo smoky` dan nama project Warmindo Smoky.
4. Setiap perubahan kode harus menyebutkan file, alasan, dampak, serta cara pengujian.
