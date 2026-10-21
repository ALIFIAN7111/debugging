# Dokumentasi Fungsi dan Prosedur — Warmindo Smoky

**Fase:** 2 — Persiapan Lingkungan Pengembangan  
**Tanggal:** 18 Oktober 2026

Project Warmindo Smoky memakai Laravel. Karena itu, fungsi PHP native dari instruksi tugas dipetakan ke method Laravel, model Eloquent, request validation, dan relasi model. Dokumentasi ini berdasarkan route yang sudah diaudit secara baca-saja.

## 1. Prosedur Menampilkan Daftar Menu

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `Product::latest()->get()` atau `Product::latest()->take(6)->get()` |
| Tujuan/Fungsi | Mengambil data produk/menu dari database untuk ditampilkan. |
| Parameter (input) | Tidak ada pada contoh dasar; `take(6)` membatasi jumlah data. |
| Return value (output) | Collection berisi object `Product`. |
| Contoh penggunaan | `Product::latest()->take(6)->get();` |

## 2. Prosedur Mengambil Produk Berdasarkan ID

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `Product::whereIn('id', ...)->get()->keyBy('id')` |
| Tujuan/Fungsi | Mengambil semua produk pada item transaksi dengan satu query lalu membuat key berdasarkan ID produk. |
| Parameter (input) | Array ID produk dari `collect($data['items'])->pluck('product_id')`. |
| Return value (output) | Collection produk dengan key ID. |
| Contoh penggunaan | `Product::whereIn('id', $productIds)->get()->keyBy('id');` |

## 3. Prosedur Validasi Pesanan Kasir

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `$request->validate([...])` |
| Tujuan/Fungsi | Memastikan data transaksi sesuai aturan sebelum database diubah. |
| Parameter (input) | Objek `Request` dan array aturan validasi. |
| Return value (output) | Array `$data` yang sudah tervalidasi; Laravel mengembalikan error validasi bila data tidak sesuai. |
| Contoh penggunaan | `$data = $request->validate(['items' => ['required', 'array', 'min:1']]);` |

## 4. Prosedur Membuat Pesanan

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `Order::create([...])` |
| Tujuan/Fungsi | Membuat data utama transaksi pesanan. |
| Parameter (input) | Array data order: kasir, kode pesanan, pelanggan, total, pembayaran, status, catatan. |
| Return value (output) | Object model `Order` yang baru disimpan. |
| Contoh penggunaan | `$order = Order::create(['total' => 0, 'status' => 'Selesai']);` |

## 5. Prosedur Menambah Item Pesanan

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `$order->items()->create([...])` |
| Tujuan/Fungsi | Menyimpan satu produk sebagai detail dari pesanan. |
| Parameter (input) | Array item: `product_id`, `product_name`, `quantity`, `price`, `subtotal`. |
| Return value (output) | Object item pesanan yang baru disimpan. |
| Contoh penggunaan | `$order->items()->create(['product_id' => $product->id, 'quantity' => 2, 'price' => $product->harga, 'subtotal' => 30000]);` |

## 6. Prosedur Menghitung Total Pesanan

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | Perhitungan `foreach` pada proses pesanan |
| Tujuan/Fungsi | Menghitung subtotal tiap item dan akumulasi total dari harga produk database. |
| Parameter (input) | Data item tervalidasi dan collection produk. |
| Return value (output) | Nilai total numerik yang kemudian disimpan ke order. |
| Contoh penggunaan | `$subtotal = (float) $product->harga * $item['quantity']; $total += $subtotal;` |

## 7. Prosedur Menyimpan Transaksi Secara Aman

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `DB::transaction(function () { ... })` |
| Tujuan/Fungsi | Menjadikan pembuatan pesanan, item, dan total sebagai satu transaksi database. |
| Parameter (input) | Closure/function berisi operasi database. |
| Return value (output) | Nilai dari closure bila berhasil; seluruh query dibatalkan bila terjadi exception. |
| Contoh penggunaan | `DB::transaction(function () use ($data) { /* simpan order dan item */ });` |

## 8. Prosedur Menambah Menu Admin

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `Product::create($data)` |
| Tujuan/Fungsi | Menyimpan menu baru dari form admin setelah validasi selesai. |
| Parameter (input) | Array data menu tervalidasi. |
| Return value (output) | Object model `Product` baru. |
| Contoh penggunaan | `Product::create($data);` |

## 9. Prosedur Upload Gambar Menu

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | `$request->file('image')->move(...)` |
| Tujuan/Fungsi | Memindahkan file gambar menu tervalidasi ke folder publik aplikasi. |
| Parameter (input) | File `image`, lokasi `public_path('assets/menu')`, nama file aman. |
| Return value (output) | File tersimpan di `public/assets/menu/`; path disimpan pada `$data['image']`. |
| Contoh penggunaan | `$request->file('image')->move(public_path('assets/menu'), $filename);` |

## 10. Prosedur Format Rupiah

| Bagian | Keterangan |
|---|---|
| Nama fungsi/prosedur | Rencana helper `formatRupiah($angka)` bila tampilan membutuhkannya |
| Tujuan/Fungsi | Mengubah angka harga menjadi format mata uang Rupiah. |
| Parameter (input) | `$angka` bertipe integer/float. |
| Return value (output) | String, contoh `Rp15.000`. |
| Contoh penggunaan | `formatRupiah(15000);` menghasilkan `Rp15.000`. |
| Status | Rancangan dokumentasi; tidak ditambahkan ke kode pada fase ini. |

## Pemetaan Fungsi Wajib PHP Native

| Fungsi pada instruksi | Padanan Laravel saat ini | Status |
|---|---|---|
| `koneksiDB()` | Konfigurasi `.env`, `config/database.php`, Eloquent/`DB` | Ada sebagai mekanisme framework |
| `getDaftarMenu($kategori = null)` | Query `Product` | Ada, filter kategori perlu audit lanjutan |
| `getDetailMenu($id)` | Query `Product` berdasarkan ID | Perlu audit lanjutan |
| `tambahKeranjang($id_makanan, $jumlah)` | Interaksi kasir/keranjang | Perlu audit view/JavaScript lanjutan |
| `hitungTotal($id_keranjang)` | Perhitungan total transaksi pada `foreach` | Ada |
| `simpanPesanan($data_pembeli, $data_pesanan)` | `Order::create`, relasi `items`, `DB::transaction` | Ada |
| `validasiInput($data)` | `$request->validate([...])` | Ada |
| `formatRupiah($angka)` | Helper tampilan | Belum diverifikasi |

## Catatan Coding Guidelines

1. Laravel memakai camelCase untuk variabel lokal seperti `$paymentMethods`, `$recentOrders`, dan `$productIds`.
2. Validasi memakai `$request->validate(...)` sebelum penyimpanan data.
3. Akses database memakai Eloquent dan Query Builder, bukan query SQL string mentah.
4. Operasi pesanan memakai transaksi database.
5. Dokumentasi fungsi ini tidak mengubah sumber kode project.
