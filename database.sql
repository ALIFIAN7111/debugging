-- File: database.sql
-- Tujuan: Membuat struktur database MySQL untuk Web Jualan Makanan WarungKu.
-- Author: Siswa SMK RPL
-- Tanggal: 18 Oktober 2026
-- Catatan: Jalankan file ini melalui phpMyAdmin atau MySQL setelah XAMPP MySQL aktif.

CREATE DATABASE IF NOT EXISTS warungku_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE warungku_db;

-- Tabel makanan: menyimpan katalog makanan dan minuman.
CREATE TABLE IF NOT EXISTS makanan (
    id_makanan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_makanan VARCHAR(100) NOT NULL UNIQUE,
    harga DECIMAL(12,2) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    gambar VARCHAR(255) NULL,
    deskripsi TEXT NULL,
    dibuat_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    diubah_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_makanan_harga CHECK (harga > 0)
) ENGINE=InnoDB;

-- Tabel pembeli: menyimpan data pembeli saat checkout.
CREATE TABLE IF NOT EXISTS pembeli (
    id_pembeli INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_pembeli VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    telepon VARCHAR(20) NOT NULL,
    dibuat_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel pesanan: menyimpan data utama setiap transaksi checkout.
CREATE TABLE IF NOT EXISTS pesanan (
    id_pesanan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pembeli INT UNSIGNED NOT NULL,
    tanggal_pesanan DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(20) NOT NULL DEFAULT 'Menunggu',
    catatan TEXT NULL,
    CONSTRAINT chk_pesanan_total CHECK (total >= 0),
    CONSTRAINT chk_pesanan_status CHECK (status IN ('Menunggu', 'Diproses', 'Selesai', 'Dibatalkan')),
    CONSTRAINT fk_pesanan_pembeli
        FOREIGN KEY (id_pembeli) REFERENCES pembeli(id_pembeli)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_pesanan_pembeli (id_pembeli),
    INDEX idx_pesanan_tanggal (tanggal_pesanan),
    INDEX idx_pesanan_status (status)
) ENGINE=InnoDB;

-- Tabel detail_pesanan: menyimpan setiap item makanan pada pesanan.
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id_detail_pesanan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT UNSIGNED NOT NULL,
    id_makanan INT UNSIGNED NOT NULL,
    jumlah INT UNSIGNED NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    CONSTRAINT chk_detail_jumlah CHECK (jumlah > 0),
    CONSTRAINT chk_detail_harga_satuan CHECK (harga_satuan > 0),
    CONSTRAINT chk_detail_subtotal CHECK (subtotal >= 0),
    CONSTRAINT fk_detail_pesanan
        FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_detail_makanan
        FOREIGN KEY (id_makanan) REFERENCES makanan(id_makanan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_detail_pesanan (id_pesanan),
    INDEX idx_detail_makanan (id_makanan)
) ENGINE=InnoDB;

-- Contoh akses tabel dengan prepared statement PDO.
-- SELECT makanan: ambil menu aktif, dibatasi untuk pagination.
-- SELECT id_makanan, nama_makanan, harga, kategori, stok, gambar, deskripsi
-- FROM makanan WHERE stok > 0 ORDER BY nama_makanan ASC LIMIT :limit OFFSET :offset;

-- INSERT makanan: dipakai admin setelah validasi input dan upload gambar berhasil.
-- INSERT INTO makanan (nama_makanan, harga, kategori, stok, gambar, deskripsi)
-- VALUES (:nama_makanan, :harga, :kategori, :stok, :gambar, :deskripsi);

-- UPDATE makanan: ubah data menu berdasarkan ID.
-- UPDATE makanan SET nama_makanan = :nama_makanan, harga = :harga,
-- kategori = :kategori, stok = :stok, gambar = :gambar, deskripsi = :deskripsi
-- WHERE id_makanan = :id_makanan;

-- DELETE makanan: hanya dilakukan jika makanan belum terkait detail pesanan.
-- DELETE FROM makanan WHERE id_makanan = :id_makanan;

-- SELECT pembeli: ambil data satu pembeli.
-- SELECT id_pembeli, nama_pembeli, alamat, telepon FROM pembeli WHERE id_pembeli = :id_pembeli;

-- INSERT pembeli: simpan data dari checkout tervalidasi.
-- INSERT INTO pembeli (nama_pembeli, alamat, telepon)
-- VALUES (:nama_pembeli, :alamat, :telepon);

-- UPDATE pembeli: perbarui data pembeli bila diperlukan.
-- UPDATE pembeli SET nama_pembeli = :nama_pembeli, alamat = :alamat, telepon = :telepon
-- WHERE id_pembeli = :id_pembeli;

-- DELETE pembeli: hanya jika belum memiliki pesanan karena foreign key RESTRICT.
-- DELETE FROM pembeli WHERE id_pembeli = :id_pembeli;

-- SELECT pesanan: ambil riwayat pesanan pembeli tanpa query berulang.
-- SELECT p.id_pesanan, p.tanggal_pesanan, p.total, p.status, p.catatan,
--        b.nama_pembeli, b.alamat, b.telepon
-- FROM pesanan AS p
-- INNER JOIN pembeli AS b ON b.id_pembeli = p.id_pembeli
-- WHERE p.id_pembeli = :id_pembeli
-- ORDER BY p.tanggal_pesanan DESC;

-- INSERT pesanan: dijalankan dalam transaksi setelah data pembeli tersimpan.
-- INSERT INTO pesanan (id_pembeli, total, status, catatan)
-- VALUES (:id_pembeli, :total, :status, :catatan);

-- UPDATE pesanan: admin mengubah status pesanan.
-- UPDATE pesanan SET status = :status WHERE id_pesanan = :id_pesanan;

-- DELETE pesanan: detail pesanan terhapus otomatis oleh ON DELETE CASCADE.
-- DELETE FROM pesanan WHERE id_pesanan = :id_pesanan;

-- SELECT detail_pesanan: ambil item pesanan beserta nama makanan.
-- SELECT dp.id_detail_pesanan, m.nama_makanan, dp.jumlah,
--        dp.harga_satuan, dp.subtotal
-- FROM detail_pesanan AS dp
-- INNER JOIN makanan AS m ON m.id_makanan = dp.id_makanan
-- WHERE dp.id_pesanan = :id_pesanan;

-- INSERT detail_pesanan: simpan setiap item keranjang dalam transaksi checkout.
-- INSERT INTO detail_pesanan (id_pesanan, id_makanan, jumlah, harga_satuan, subtotal)
-- VALUES (:id_pesanan, :id_makanan, :jumlah, :harga_satuan, :subtotal);

-- UPDATE detail_pesanan: dipakai bila pesanan belum diproses dan jumlah item perlu diubah.
-- UPDATE detail_pesanan SET jumlah = :jumlah, subtotal = :subtotal
-- WHERE id_detail_pesanan = :id_detail_pesanan;

-- DELETE detail_pesanan: hapus satu item dari pesanan yang belum diproses.
-- DELETE FROM detail_pesanan WHERE id_detail_pesanan = :id_detail_pesanan;
