# API Warmindo Smoky

Basis: `http://127.0.0.1:8001`. Semua response JSON. Error validasi 422, tanpa auth 401, tidak ketemu 404, CSRF web 419.

## Publik (tanpa login)

### GET /api/products
Ambil katalog menu terbaru.

Contoh response 200:
```json
{
  "data": [
    {
      "id": 10,
      "name": "Mie Dok-Dok Kuah Smoky",
      "harga": 18000,
      "description": "Kuah kental gurih beraroma smoky khas wajan panas.",
      "category": "mie",
      "image": "http://127.0.0.1:8001/assets/menu/mie.jpg",
      "stock": 20,
      "is_available": true,
      "available": true,
      "rating": 5,
      "spice_level": 2,
      "is_best_seller": true
    }
  ]
}
```

### GET /api/bundles
Ambil paket aktif urut harga termurah.

Contoh response 200:
```json
{
  "data": [
    {
      "id": 1,
      "name": "Paket Nongkrong Berdua",
      "description": "2 mie + 2 minum",
      "price": 40000,
      "original_price": 50000,
      "badge": "Hemat",
      "is_popular": true,
      "image": null,
      "discount_percent": 20
    }
  ]
}
```

### GET /api/warung-config
Ambil config warung dari `config/warung.php`.

Contoh response 200:
```json
{
  "data": {
    "name": "WARMINDO SMOKY",
    "address": "Jl. Ahmad Yani No. 88, Bontang, Kalimantan Timur",
    "open_time": "19:00",
    "close_time": "00:00",
    "phone_wa": "6281234567890",
    "maps_link": "https://www.google.com/maps/search/?api=1&query=Bontang+Kalimantan+Timur"
  }
}
```

### GET /ulasan
Ambil 20 ulasan disetujui. Route name `reviews.index`.

## Butuh login session (web auth)

Kirim cookie session Laravel + header `X-CSRF-TOKEN` atau `X-XSRF-TOKEN`. Tanpa login: 401. Tanpa token CSRF valid: 419.

### GET /api/payment-methods
Butuh `auth`. Ambil metode aktif: `id`, `name`.

### GET /api/orders
Butuh `auth`. Ambil pesanan milik user login, paginasi 10.

### POST /api/orders
Butuh `auth`. Buat pesanan. Harga selalu dari database, field `unit_price` dari klien diabaikan.

Body:
```json
{
  "payment_method": "QRIS",
  "notes": "Sambal pisah",
  "items": [
    {
      "item_type": "product",
      "product_id": 10,
      "quantity": 2,
      "options": {
        "spice": "Lvl 2 Pedas",
        "note": "Mie setengah matang",
        "toppings": ["Telur Ceplok / Dadar"]
      }
    },
    {
      "item_type": "bundle",
      "bundle_id": 1,
      "quantity": 1
    }
  ]
}
```

Aturan:
- `payment_method` wajib, harus ada di `payment_methods.name` dan aktif.
- `items` wajib array minimal 1.
- `item_type` opsional: `product` atau `bundle`. Default ikut `bundle_id` bila ada.
- `product_id` nullable, harus ada di `products.id` bila tipe product.
- `bundle_id` nullable, harus ada di `bundles.id` bila tipe bundle.
- `quantity` wajib integer 1-20.
- `options.spice` max 50, `options.note` max 200, tiap topping max 100.

Contoh sukses 201:
```json
{
  "message": "Pesanan berhasil dibuat.",
  "data": {
    "id": 5,
    "order_code": "ORD-261007120000-42",
    "customer_name": "Budi",
    "total": 76000,
    "payment_method": "QRIS",
    "status": "Menunggu",
    "items": []
  }
}
```

Contoh gagal:
- 401 tanpa login.
- 419 tanpa CSRF.
- 422 item tidak valid: `Paket tidak valid.` atau `Menu tidak valid.`

### POST /ulasan
Butuh `web` + `auth`. Route name `reviews.store`.

Body:
```json
{
  "rating": 5,
  "text": "Mie smoky nagih, WiFi kencang."
}
```

Aturan: `rating` integer 1-5, `text` 4-500 karakter, tag HTML dibuang. Sukses 201.

## Admin (session + role admin)

Header auth sama seperti member. Tanpa login 401, role salah redirect sesuai `EnsureUserHasRole`.

### GET /api/admin/products
List semua produk mentah.

### POST /api/admin/products
Body: `name` required unik max 255, `harga` required numeric min 0. Sukses 201.

### PUT /api/admin/products/{product}
Body sama, `name` unik kecuali ID ini. Sukses 200.

### DELETE /api/admin/products/{product}
Hapus produk. Sukses 200: `{"message":"Produk berhasil dihapus."}`.

## Web penting (Blade, bukan JSON)

- `GET /` landing katalog + paket + ulasan (`WarmindoController@index`).
- `GET /user` member butuh `auth` + `role:user`.
- `GET /member` dashboard member butuh `auth`, admin redirect ke dashboard admin.
- `GET /kasir` butuh `auth` + `role:admin,kasir`.
- `POST /kasir/pesanan` butuh `auth` + `role:admin,kasir`, harga dari DB, status `Selesai`.
- `GET /admin` dan `GET /admin/{module}` butuh `auth` + `role:admin`.
- `POST /admin/menu|stok-bahan|stok-produksi|pesanan|pengeluaran|pembayaran|bundling|catatan`.
- `DELETE /admin/menu/{product}`.
- `GET /admin-dashboard`, `/settings`, `/analytics`, `/inventory` via `DashboardController`.
- `GET|POST|PATCH|DELETE /order-management` via `OrderManagementController`.
- Auth Breeze: `/register`, `/login`, `/admin/login`, `/logout`, reset password, verify email.
