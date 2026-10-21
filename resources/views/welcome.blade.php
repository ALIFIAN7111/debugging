<?php

use Illuminate\Support\Str;

$products = [];

// Simulasi data produk dari database
$productNames = [
    'Indomie Original', 'Indomie Telur', 'Indomie Nyemek Spesial',
    'Nasi Goreng Original', 'Nasi Goreng Telur',
    'Es Teh Manis', 'Kopi Susu', 'Lemon Tea'
];

foreach ($productNames as $index => $name) {
    $products[] = (object)[
        'id' => $index + 1,
        'name' => $name,
        'harga' => 10000 + ($index * 2000),
    ];
}

function getProductType($name) {
    $name = strtolower($name);
    
    if (Str::contains($name, 'kopi')) {
        return ['☕', 'from-[#6D4029] to-[#B96B3A]', 'Kopi hangat'];
    }
    if (Str::contains($name, ['teh', 'jeruk', 'susu', 'lemon'])) {
        return ['🥤', 'from-[#64BBD5] to-[#B8EAF5]', 'Minuman segar'];
    }
    if (Str::contains($name, 'nasi')) {
        return ['🍳', 'from-[#F28B52] to-[#F7C843]', 'Nasi hangat'];
    }
    if (Str::contains($name, ['telur', 'sosis', 'kornet'])) {
        return ['🍳', 'from-[#F2674A] to-[#F7C843]', 'Lauk pilihan'];
    }
    return ['🍜', 'from-[#D95B32] to-[#F7C843]', 'Mie hangat'];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WM SMOKY — Pesan makan favoritmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#fffaf3]">
    <main class="mx-auto max-w-7xl px-5 pb-20 pt-8 sm:px-8 lg:px-10">
        <section id="menu" class="scroll-mt-8">
            <div class="mb-6">
                <h2 class="text-3xl font-black tracking-tight sm:text-4xl">Menu WM SMOKY</h2>
            </div>
            
            @if (count($products) === 0)
                <div class="rounded-3xl border border-dashed border-[#17202d]/15 bg-white/60 px-6 py-16 text-center">
                    <p class="font-black">Menu belum tersedia</p>
                </div>
            @else
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $index => $product)
                        @php
                            $type = getProductType($product->name);
                        @endphp
                        <article class="group overflow-hidden rounded-3xl border border-white/10 bg-white/[.08] backdrop-blur-sm transition hover:-translate-y-2">
                            <div class="relative grid h-48 place-items-center overflow-hidden bg-gradient-to-br {{ $type[1] }}">
                                <span class="relative z-10 text-8xl">{{ $type[0] }}</span>
                                <span class="absolute left-4 top-4 rounded-full bg-[#17202D] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-white">
                                    {{ $index === 0 ? 'Best seller' : $type[2] }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-black">{{ $product->name }}</h3>
                                <div class="mt-5 flex items-center justify-between">
                                    <strong class="text-xl text-[#f7c843]">Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>
