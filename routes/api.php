<?php

use App\Models\Bundle;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/products', function () {
    return response()->json([
        'data' => Product::latest()->get()->map(fn (Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'harga' => (float) $product->harga,
            'description' => $product->description ?? 'Racikan hangat favorit yang dibuat fresh saat dipesan.',
            'category' => $product->category ?? 'mie',
            'image' => $product->image ? asset($product->image) : null,
            'image_width' => $product->image_width,
            'image_height' => $product->image_height,
            'image_fit' => $product->image_fit ?: 'cover',
            'stock' => (int) ($product->stock ?? 0),
            'is_available' => (bool) ($product->is_available ?? true),
            'available' => (bool) ($product->is_available ?? true) && (int) ($product->stock ?? 0) > 0,
            'rating' => (float) ($product->rating ?? 5.0),
            'spice_level' => (int) ($product->spice_level ?? 0),
            'is_best_seller' => (bool) ($product->is_best_seller ?? false),
        ])->values(),
    ]);
});

Route::get('/bundles', function () {
    return response()->json([
        'data' => Bundle::where('is_active', true)->orderBy('price')->get()->map(fn (Bundle $bundle) => [
            'id' => $bundle->id,
            'name' => $bundle->name,
            'description' => $bundle->description,
            'price' => (float) $bundle->price,
            'original_price' => $bundle->original_price !== null ? (float) $bundle->original_price : null,
            'badge' => $bundle->badge,
            'is_popular' => (bool) $bundle->is_popular,
            'image' => $bundle->image ? asset($bundle->image) : null,
            'image_width' => $bundle->image_width,
            'image_height' => $bundle->image_height,
            'image_fit' => $bundle->image_fit ?: 'cover',
            'discount_percent' => ($bundle->original_price ?? 0) > ($bundle->price ?? 0)
                ? (int) round((1 - ((float) $bundle->price / (float) $bundle->original_price)) * 100)
                : 0,
        ])->values(),
    ]);
});

Route::get('/warung-config', function () {
    $cfg = config('warung');

    return response()->json([
        'data' => [
            'name' => $cfg['name'] ?? 'WARMINDO SMOKY',
            'sub' => $cfg['sub'] ?? 'BONTANG HITZ',
            'address' => $cfg['address'] ?? '',
            'open_time' => $cfg['open_time'] ?? '19:00',
            'close_time' => $cfg['close_time'] ?? '00:00',
            'timezone_label' => $cfg['timezone_label'] ?? 'WITA',
            'phone_display' => $cfg['phone_display'] ?? '',
            'phone_wa' => $cfg['phone_wa'] ?? '',
            'maps_embed' => $cfg['maps_embed'] ?? '',
            'maps_link' => $cfg['maps_link'] ?? 'https://www.google.com/maps',
            'toppings' => $cfg['toppings'] ?? [],
            'spice_levels' => $cfg['spice_levels'] ?? [],
        ],
    ]);
});

// API untuk admin/kasir
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/products', function () {
        return response()->json([
            'data' => Product::latest()->get(),
        ]);
    });

    Route::post('/admin/products', function (Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'harga' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'in:mie,indomie,rice,snack,drink,nasi,minum'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_available' => ['sometimes', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'spice_level' => ['nullable', 'integer', 'min:0', 'max:5'],
            'is_best_seller' => ['sometimes', 'boolean'],
        ]);

        $product = Product::create($data);

        return response()->json(['message' => 'Produk berhasil ditambahkan.', 'data' => $product], 201);
    });

    Route::put('/admin/products/{product}', function (Request $request, Product $product) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name,'.$product->id],
            'harga' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'in:mie,indomie,rice,snack,drink,nasi,minum'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_available' => ['sometimes', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'spice_level' => ['nullable', 'integer', 'min:0', 'max:5'],
            'is_best_seller' => ['sometimes', 'boolean'],
        ]);

        $product->update($data);

        return response()->json(['message' => 'Produk berhasil diperbarui.', 'data' => $product]);
    });

    Route::delete('/admin/products/{product}', function (Product $product) {
        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus.']);
    });
});

// Pesanan dari halaman browser memakai session login Laravel.
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/payment-methods', function () {
        return response()->json([
            'data' => PaymentMethod::where('is_active', true)->orderBy('name')->get(['id', 'name']),
        ]);
    });

    Route::get('/orders', function (Request $request) {
        return response()->json([
            'data' => Order::with('items')->where('user_id', $request->user()->id)->latest()->paginate(10),
        ]);
    });

    Route::post('/orders', function (Request $request) {
        $payload = $request->validate([
            'payment_method' => ['required', 'string', 'max:50', Rule::exists('payment_methods', 'name')->where('is_active', true)],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_type' => ['sometimes', 'string', 'in:product,bundle'],
            'items.*.product_id' => ['nullable', 'integer', 'exists:products,id'],
            'items.*.bundle_id' => ['nullable', 'integer', 'exists:bundles,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'items.*.options' => ['nullable', 'array'],
            'items.*.options.spice' => ['nullable', 'string', 'max:50'],
            'items.*.options.note' => ['nullable', 'string', 'max:200'],
            'items.*.options.toppings' => ['nullable', 'array'],
            'items.*.options.toppings.*' => ['string', 'max:100'],
            // Harga selalu diambil dari database, abaikan unit_price dari klien.
        ]);

        $order = DB::transaction(function () use ($payload, $request) {
            $productIds = collect($payload['items'])->pluck('product_id')->filter()->unique()->values();
            $bundleIds = collect($payload['items'])->pluck('bundle_id')->filter()->unique()->values();
            $products = $productIds->isNotEmpty()
                ? Product::whereIn('id', $productIds)->get()->keyBy('id')
                : collect();
            $bundles = $bundleIds->isNotEmpty()
                ? Bundle::whereIn('id', $bundleIds)->get()->keyBy('id')
                : collect();
            $total = 0;

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_code' => 'ORD-'.now()->format('ymdHis').'-'.random_int(10, 99),
                'customer_name' => $request->user()->name,
                'total' => 0,
                'payment_method' => $payload['payment_method'],
                'status' => 'Menunggu',
                'notes' => $payload['notes'] ?? null,
            ]);

            foreach ($payload['items'] as $item) {
                $type = $item['item_type'] ?? (($item['bundle_id'] ?? null) ? 'bundle' : 'product');
                $quantity = (int) $item['quantity'];

                if ($type === 'bundle') {
                    abort_unless(isset($item['bundle_id']) && $bundles->has($item['bundle_id']), 422, 'Paket tidak valid.');
                    $bundle = $bundles[$item['bundle_id']];
                    $price = (float) $bundle->price;
                    $name = $bundle->name.' ('.($bundle->description ?? 'paket hemat').')';
                    $productId = null;
                } else {
                    abort_unless(isset($item['product_id']) && $products->has($item['product_id']), 422, 'Menu tidak valid.');
                    $product = $products[$item['product_id']];
                    $price = (float) $product->harga;
                    $name = $product->name;
                    $productId = $product->id;
                }

                $subtotal = $price * $quantity;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'item_type' => $type,
                    'product_name' => $name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'options' => isset($item['options']) ? json_encode($item['options']) : null,
                ]);
            }

            $order->update(['total' => $total]);

            return $order->load('items');
        });

        return response()->json(['message' => 'Pesanan berhasil dibuat.', 'data' => $order], 201);
    });
});
