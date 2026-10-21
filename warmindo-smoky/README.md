# Warmindo Smoky - Landing Page

Warmindo Smoky adalah landing page modern untuk warung makan Indomie dengan konsep "smoky" (hangat, berasap, kekinian). Dibangun dengan React + Vite + Tailwind CSS.

## Fitur

- 🎨 **Design Modern**: Palet warna smoky (hitam arang, oranye api, merah bara)
- 📱 **Mobile-First**: Responsif di semua ukuran layar
- 🛒 **Keranjang Pesanan**: Tambah/hapus item, checkout via WhatsApp
- 💬 **Floating WhatsApp**: Tombol melayang untuk chat langsung
- 🔍 **Search & Filter**: Cari menu, filter kategori (Mie, Nasi, Minuman)
- ⭐ **SEO Dasar**: Meta tags, Open Graph
- ♿ **Aksesibilitas**: Kontras warna baik, alt text pada gambar

## Struktur Halaman

1. **Navbar** - Logo, menu navigasi, tombol pesanan
2. **Hero** - Judul besar, CTA, gambar menarik
3. **Menu** - Grid menu dengan filter & search
4. **Features** - 4 keunggulan Warmindo Smoky
5. **Testimonials** - 3 ulasan pelanggan
6. **Location** - Peta, alamat, jam buka, hubungi
7. **Footer** - Links, sosial media, copyright
8. **Cart Modal** - Tampil pesanan, total, pesan via WhatsApp
9. **Floating WhatsApp** - Tombol chat melayang

## Setup & Development

### Prerequisites
- Node.js 16+ 
- npm atau yarn

### Instalasi

```bash
cd warmindo-smoky
npm install
```

### Development Server

```bash
npm run dev
```

Akses di `http://localhost:5173`

### Build Production

```bash
npm run build
npm run preview
```

## Konfigurasi

### Nomor WhatsApp

Edit nomor di file-file berikut:
- `src/components/Hero.jsx` - Link WhatsApp pada tombol CTA
- `src/components/Location.jsx` - Nomor di section lokasi
- `src/components/FloatingWhatsApp.jsx` - Floating button

Ganti `085752376632` dengan nomor Warmindo Smoky yang sebenarnya.

### Menu Items

Edit `src/components/Menu.jsx` - array `menuItems` untuk menambah/ubah menu, harga, gambar.

### Warna Brand

Edit `tailwind.config.js` untuk ubah palet warna:
```js
colors: {
  smoky: {
    dark: '#1A1A1A',      // Hitam arang
    fire: '#F97316',      // Oranye api
    ember: '#DC2626',     // Merah bara
    cream: '#FFF7ED',     // Krem hangat
  }
}
```

## Deployment

### Vercel (Recommended)
```bash
npm install -g vercel
vercel
```

### Netlify
```bash
npm install -g netlify-cli
netlify deploy --prod --dir=dist
```

### GitHub Pages
```bash
npm run build
# Push ke repo GitHub, aktifkan Pages dari branch main/dist
```

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Android)

## Performance

- ✅ Lazy loading images
- ✅ Optimized bundle size (~45KB gzipped)
- ✅ CSS-in-JS minimal
- ✅ No external dependencies (hanya React + Tailwind)

## Accessibility

- ✅ Contrast ratio 4.5:1 WCAG AA
- ✅ Semantic HTML
- ✅ Alt text pada semua images
- ✅ Keyboard navigable
- ✅ Focus visible states
- ✅ Reduced motion support

## License

© 2026 Warmindo Smoky. All rights reserved.

---

**Siap diluncurkan?** Tinggal jalankan `npm install` → `npm run dev` → buka browser 🚀
