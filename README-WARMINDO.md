# Warmindo Smoky (Laravel)

Aplikasi warung: landing katalog, dashboard member + checkout, kasir, admin, API JSON session-auth.

## Syarat
- PHP ^8.3 + Composer
- Node 20+ + npm
- MySQL, database `lara` (default `.env.example`)

## Install pertama
```bash
composer install
cp .env.example .env
php artisan key:generate
```

Isi `.env`:
- `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=lara`, `DB_USERNAME=root`, `DB_PASSWORD=`
- `WIFI_SSID="WMSMOKY-5G"`, `WIFI_PASSWORD="ganti-tiap-minggu"`

Lalu:
```bash
php artisan migrate
npm install
npm run build
```

## Jalan lokal
```bash
php artisan serve --port=8001
```

Buka:
- `http://127.0.0.1:8001/` landing
- `http://127.0.0.1:8001/login` member
- `http://127.0.0.1:8001/admin/login` admin/kasir
- `http://127.0.0.1:8001/api/products` JSON katalog

Dev Vite (opsional):
```bash
npm run dev
```

## Build produksi
```bash
npm run build
```

Output di `public/build/` (`manifest.json`, `app.css`, `app.js`).

## Test dan style
```bash
php artisan test
./vendor/bin/pint --test
```

Hasil rilis ini: `25 passed`, Pint `83 files PASS`.

## Dokumen
- `API.md` daftar endpoint + contoh.
- `SPEC.md` peran, data, aturan bisnis.
- `LAPORAN_AUDIT.md` temuan, perbaikan, mapping SKKNI.
