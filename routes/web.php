<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarmindoController;
use App\Models\AdminNote;
use App\Models\Bundle;
use App\Models\Expense;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductionStock;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [WarmindoController::class, 'index'])->name('home');
Route::get('/landing', function () {
    return redirect()->route('home');
})->name('landing');

Route::get('/welcome', function () {
    return view('welcome', [
        'products' => Product::latest()->take(6)->get(),
        'bundles' => Bundle::latest()->take(3)->get(),
    ]);
})->name('welcome');

Route::get('/warmindo-smoky', function () {
    return view('warmindo');
});

Route::get('/user', function () {
    return view('user', [
        'products' => Product::latest()->get(),
        'bundles' => Bundle::where('is_active', true)->orderBy('price')->get(),
        'warung' => config('warung'),
        'catalog' => [
            'label' => App\Models\SystemSetting::get('catalog_label', 'Katalog Menu'),
            'title' => App\Models\SystemSetting::get('catalog_title', 'Pilih jagoanmu malam ini'),
            'subtitle' => App\Models\SystemSetting::get('catalog_subtitle', 'Dimasak fresh setelah kamu pesan.'),
        ],
    ]);
})->middleware(['auth', 'role:user'])->name('user');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('dashboard.index');
    }

    return redirect()->route('user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/kasir', function () {
    return view('kasir', [
        'products' => Product::latest()->get(),
        'paymentMethods' => PaymentMethod::where('is_active', true)->orderBy('name')->get(),
        'recentOrders' => Order::with('items')->latest()->take(10)->get(),
    ]);
})->middleware(['auth', 'role:admin,kasir'])->name('kasir');

Route::post('/kasir/pesanan', function (Request $request) {
    $data = $request->validate([
        'customer_name' => ['nullable', 'string', 'max:255'],
        'payment_method' => ['required', 'exists:payment_methods,name'],
        'notes' => ['nullable', 'string', 'max:500'],
        'items' => ['required', 'array', 'min:1'],
        'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
        'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
    ]);

    abort_unless(PaymentMethod::where('name', $data['payment_method'])->where('is_active', true)->exists(), 422);

    DB::transaction(function () use ($data, $request) {
        $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');
        $order = Order::create([
            'cashier_id' => $request->user()->id,
            'order_code' => 'ORD-'.now()->format('ymdHis').'-'.random_int(100, 999),
            'customer_name' => $data['customer_name'] ?? null,
            'total' => 0,
            'payment_method' => $data['payment_method'],
            'status' => 'Selesai',
            'notes' => $data['notes'] ?? null,
        ]);

        $total = 0;
        foreach ($data['items'] as $item) {
            abort_unless(isset($products[$item['product_id']]), 422, 'Menu tidak valid.');
            $product = $products[$item['product_id']];
            $subtotal = (float) $product->harga * $item['quantity'];
            $total += $subtotal;

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $item['quantity'],
                'price' => $product->harga,
                'subtotal' => $subtotal,
            ]);
        }

        $order->update(['total' => $total]);
    });

    return redirect()->route('kasir')->with('status', 'Transaksi berhasil disimpan.');
})->middleware(['auth', 'role:admin,kasir'])->name('kasir.order.store');

Route::get('/admin', function () {
    return view('admin', [
        'stats' => [
            'users' => User::count(),
            'products' => Product::count(),
            'ingredients' => Ingredient::count(),
            'low_stock' => Ingredient::whereColumn('stock', '<=', 'minimum_stock')->count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'revenue_today' => Order::whereDate('created_at', today())->where('status', 'Selesai')->sum('total'),
            'expenses_month' => Expense::whereMonth('spent_at', now()->month)->whereYear('spent_at', now()->year)->sum('amount'),
        ],
        'products' => Product::latest()->take(5)->get(),
        'recentOrders' => Order::latest()->take(5)->get(),
        'modules' => [
            ['slug' => 'menu', 'icon' => '🍜', 'title' => 'Menu & Harga', 'description' => 'Kelola daftar menu, harga, dan ketersediaan.'],
            ['slug' => 'stok-bahan', 'icon' => '📦', 'title' => 'Stok Bahan', 'description' => 'Pantau bahan baku dan batas minimum stok.'],
            ['slug' => 'stok-produksi', 'icon' => '🏷️', 'title' => 'Stok Produksi', 'description' => 'Catat hasil produksi harian warmindo.'],
            ['slug' => 'pesanan', 'icon' => '🧾', 'title' => 'Pesanan Masuk', 'description' => 'Kelola pesanan dan status pembayaran.'],
            ['slug' => 'pengeluaran', 'icon' => '💸', 'title' => 'Pengeluaran', 'description' => 'Catat biaya operasional dan belanja.'],
            ['slug' => 'kasir', 'icon' => '🛒', 'title' => 'Aplikasi Kasir', 'description' => 'Buat transaksi langsung dari kasir.'],
            ['slug' => 'pembayaran', 'icon' => '💳', 'title' => 'Metode Pembayaran', 'description' => 'Atur tunai, QRIS, transfer, dan e-wallet.'],
            ['slug' => 'catatan', 'icon' => '📒', 'title' => 'Buku Catatan', 'description' => 'Simpan catatan manual operasional.'],
            ['slug' => 'bundling', 'icon' => '🎁', 'title' => 'Format Bundling', 'description' => 'Buat paket hemat untuk pelanggan.'],
            ['slug' => 'analitik', 'icon' => '📈', 'title' => 'Analisis Pembeli', 'description' => 'Lihat omzet, biaya, dan estimasi keuntungan.'],
        ],
    ]);
})->middleware(['auth', 'role:admin'])->name('admin');

Route::get('/admin/{module}', function (string $module) {
    $modules = [
        'menu' => ['icon' => '🍜', 'title' => 'Menu & Harga', 'description' => 'Kelola daftar menu, harga, dan ketersediaan warmindo.'],
        'stok-bahan' => ['icon' => '📦', 'title' => 'Stok Bahan', 'description' => 'Pantau bahan baku, satuan, dan batas minimum stok.'],
        'stok-produksi' => ['icon' => '🏷️', 'title' => 'Stok Produksi', 'description' => 'Catat hasil produksi dan pemakaian bahan harian.'],
        'pesanan' => ['icon' => '🧾', 'title' => 'Pesanan Masuk', 'description' => 'Kelola pesanan, status pengerjaan, dan pembayaran.'],
        'pengeluaran' => ['icon' => '💸', 'title' => 'Pengeluaran', 'description' => 'Catat pengeluaran bahan dan biaya operasional.'],
        'kasir' => ['icon' => '🛒', 'title' => 'Aplikasi Kasir', 'description' => 'Buat transaksi baru dan cetak ringkasan pembayaran.'],
        'pembayaran' => ['icon' => '💳', 'title' => 'Metode Pembayaran', 'description' => 'Atur opsi pembayaran yang diterima di warmindo.'],
        'catatan' => ['icon' => '📒', 'title' => 'Buku Catatan Manual', 'description' => 'Simpan catatan operasional yang fleksibel.'],
        'bundling' => ['icon' => '🎁', 'title' => 'Format Bundling', 'description' => 'Buat paket menu hemat untuk meningkatkan penjualan.'],
        'analitik' => ['icon' => '📈', 'title' => 'Analisis Data Pembeli', 'description' => 'Pantau omzet, biaya, dan estimasi keuntungan dari pembeli.'],
    ];

    abort_unless(isset($modules[$module]), 404);

    $data = match ($module) {
        'analitik' => [
            'analytics' => [
                'revenue' => Order::where('status', 'Selesai')->sum('total'),
                'expenses' => Expense::sum('amount'),
                'orders' => Order::count(),
                'topProducts' => DB::table('order_items')->select('product_name', DB::raw('SUM(quantity) as quantity'))->groupBy('product_name')->orderByDesc('quantity')->limit(5)->get(),
            ],
        ],
        'stok-bahan' => ['ingredients' => Ingredient::latest()->get()],
        'stok-produksi' => ['productionStocks' => ProductionStock::latest()->get()],
        'pesanan' => ['orders' => Order::latest()->get()],
        'pengeluaran' => ['expenses' => Expense::latest()->get()],
        'pembayaran' => ['paymentMethods' => PaymentMethod::latest()->get()],
        'bundling' => ['bundles' => Bundle::latest()->get()],
        'catatan' => ['notes' => AdminNote::latest()->get()],
        default => [],
    };

    return view('admin.module', array_merge([
        'module' => $modules[$module],
        'slug' => $module,
        'products' => Product::latest()->get(),
    ], $data));
})->middleware(['auth', 'role:admin'])->name('admin.module');

Route::post('/admin/menu', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'harga' => ['required', 'numeric', 'min:0'],
        'description' => ['nullable', 'string', 'max:500'],
        'category' => ['required', 'string', 'in:mie,indomie,rice,snack,drink,nasi,minum'],
        'stock' => ['required', 'integer', 'min:0', 'max:9999'],
        'is_available' => ['sometimes', 'boolean'],
        'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
        'spice_level' => ['nullable', 'integer', 'min:0', 'max:5'],
        'is_best_seller' => ['sometimes', 'boolean'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_width' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_height' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_fit' => ['nullable', 'string', 'in:cover,contain,fill,none,scale-down'],
    ]);

    if ($request->hasFile('image')) {
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->move(public_path('assets/menu'), $filename);
        $data['image'] = 'assets/menu/'.$filename;
    }

    $data['is_available'] = $request->boolean('is_available', true);
    $data['is_best_seller'] = $request->boolean('is_best_seller', false);
    $data['rating'] = $data['rating'] ?? 5.0;
    $data['spice_level'] = $data['spice_level'] ?? 0;

    Product::create($data);

    return back()->with('status', 'Menu berhasil ditambahkan.');
})->middleware(['auth', 'role:admin'])->name('admin.menu.store');

Route::post('/admin/stok-bahan', function (Request $request) {
    Ingredient::create($request->validate(['name' => 'required|string|max:255', 'unit' => 'required|string|max:30', 'stock' => 'required|numeric|min:0', 'minimum_stock' => 'required|numeric|min:0', 'unit_cost' => 'required|numeric|min:0']));

    return back()->with('status', 'Stok bahan berhasil ditambahkan.');
})->middleware(['auth', 'role:admin'])->name('admin.ingredient.store');

Route::post('/admin/stok-produksi', function (Request $request) {
    ProductionStock::create($request->validate(['name' => 'required|string|max:255', 'quantity' => 'required|numeric|min:0', 'unit' => 'required|string|max:30', 'production_date' => 'required|date']));

    return back()->with('status', 'Stok produksi berhasil dicatat.');
})->middleware(['auth', 'role:admin'])->name('admin.production.store');

Route::post('/admin/pesanan', function (Request $request) {
    $data = $request->validate(['customer_name' => 'nullable|string|max:255', 'total' => 'required|numeric|min:0', 'payment_method' => 'required|string|max:50']);
    $data['order_code'] = 'ORD-'.now()->format('ymdHis');
    Order::create($data);

    return back()->with('status', 'Pesanan berhasil dibuat.');
})->middleware(['auth', 'role:admin'])->name('admin.order.store');

Route::post('/admin/pengeluaran', function (Request $request) {
    Expense::create($request->validate(['title' => 'required|string|max:255', 'category' => 'required|string|max:50', 'amount' => 'required|numeric|min:0', 'spent_at' => 'required|date']));

    return back()->with('status', 'Pengeluaran berhasil dicatat.');
})->middleware(['auth', 'role:admin'])->name('admin.expense.store');

Route::post('/admin/pembayaran', function (Request $request) {
    PaymentMethod::create($request->validate(['name' => 'required|string|max:255']));

    return back()->with('status', 'Metode pembayaran berhasil ditambahkan.');
})->middleware(['auth', 'role:admin'])->name('admin.payment.store');

Route::post('/admin/bundling', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'original_price' => 'nullable|numeric|min:0',
        'badge' => 'nullable|string|max:50',
        'description' => 'nullable|string',
        'is_popular' => 'sometimes|boolean',
        'is_active' => 'sometimes|boolean',
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_width' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_height' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_fit' => ['nullable', 'string', 'in:cover,contain,fill,none,scale-down'],
    ]);
    if ($request->hasFile('image')) {
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->move(public_path('assets/menu'), $filename);
        $validated['image'] = 'assets/menu/'.$filename;
    }
    $validated['is_popular'] = $request->boolean('is_popular', false);
    $validated['is_active'] = $request->boolean('is_active', true);
    Bundle::create($validated);

    return back()->with('status', 'Bundling berhasil ditambahkan.');
})->middleware(['auth', 'role:admin'])->name('admin.bundle.store');

Route::put('/admin/bundling/{bundle}', function (Request $request, Bundle $bundle) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'original_price' => 'nullable|numeric|min:0',
        'badge' => 'nullable|string|max:50',
        'description' => 'nullable|string',
        'is_popular' => 'sometimes|boolean',
        'is_active' => 'sometimes|boolean',
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_width' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_height' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_fit' => ['nullable', 'string', 'in:cover,contain,fill,none,scale-down'],
    ]);

    if ($request->hasFile('image')) {
        if ($bundle->image && file_exists(public_path($bundle->image))) {
            @unlink(public_path($bundle->image));
        }
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->move(public_path('assets/menu'), $filename);
        $data['image'] = 'assets/menu/'.$filename;
    }

    $data['is_popular'] = $request->boolean('is_popular', false);
    $data['is_active'] = $request->boolean('is_active', true);

    $bundle->update($data);

    return back()->with('status', 'Paket berhasil diperbarui. Foto, harga, dan deskripsi langsung tampil di user.');
})->middleware(['auth', 'role:admin'])->name('admin.bundle.update');

Route::delete('/admin/bundling/{bundle}', function (Bundle $bundle) {
    if ($bundle->image && file_exists(public_path($bundle->image))) {
        @unlink(public_path($bundle->image));
    }
    $bundle->delete();

    return back()->with('status', 'Paket berhasil dihapus.');
})->middleware(['auth', 'role:admin'])->name('admin.bundle.destroy');

Route::post('/admin/catatan', function (Request $request) {
    AdminNote::create($request->validate(['title' => 'required|string|max:255', 'content' => 'required|string', 'note_date' => 'required|date']));

    return back()->with('status', 'Catatan berhasil disimpan.');
})->middleware(['auth', 'role:admin'])->name('admin.note.store');

Route::put('/admin/menu/{product}', function (Request $request, Product $product) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'harga' => ['required', 'numeric', 'min:0'],
        'description' => ['nullable', 'string', 'max:500'],
        'category' => ['required', 'string', 'in:mie,indomie,rice,snack,drink,nasi,minum'],
        'stock' => ['required', 'integer', 'min:0', 'max:9999'],
        'is_available' => ['sometimes', 'boolean'],
        'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
        'spice_level' => ['nullable', 'integer', 'min:0', 'max:5'],
        'is_best_seller' => ['sometimes', 'boolean'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_width' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_height' => ['nullable', 'integer', 'min:20', 'max:2000'],
        'image_fit' => ['nullable', 'string', 'in:cover,contain,fill,none,scale-down'],
    ]);

    if ($request->hasFile('image')) {
        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->move(public_path('assets/menu'), $filename);
        $data['image'] = 'assets/menu/'.$filename;
    }

    $data['is_available'] = $request->boolean('is_available', true);
    $data['is_best_seller'] = $request->boolean('is_best_seller', false);
    $data['rating'] = $data['rating'] ?? $product->rating ?? 5.0;
    $data['spice_level'] = $data['spice_level'] ?? $product->spice_level ?? 0;

    $product->update($data);

    return back()->with('status', 'Menu berhasil diperbarui. Langsung tampil di landing + dashboard member.');
})->middleware(['auth', 'role:admin'])->name('admin.menu.update');

Route::delete('/admin/menu/{product}', function (Product $product) {
    if ($product->image && file_exists(public_path($product->image))) {
        @unlink(public_path($product->image));
    }
    $product->delete();

    return back()->with('status', 'Menu berhasil dihapus.');
})->middleware(['auth', 'role:admin'])->name('admin.menu.destroy');

// Dashboard Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin-dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings.update');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/inventory', [DashboardController::class, 'inventory'])->name('dashboard.inventory');
    Route::post('/inventory/ingredient', [DashboardController::class, 'addIngredient'])->name('dashboard.ingredient.store');
    Route::patch('/inventory/ingredient/{id}', [DashboardController::class, 'updateIngredient'])->name('dashboard.ingredient.update');
    Route::delete('/inventory/ingredient/{id}', [DashboardController::class, 'deleteIngredient'])->name('dashboard.ingredient.destroy');
});

// Order Management Routes
use App\Http\Controllers\OrderManagementController;

Route::middleware(['auth', 'role:admin'])->prefix('order-management')->group(function () {
    Route::get('/', [OrderManagementController::class, 'index'])->name('order-management.index');
    Route::get('/filter', [OrderManagementController::class, 'filter'])->name('order-management.filter');
    Route::get('/create', [OrderManagementController::class, 'create'])->name('order-management.create');
    Route::post('/', [OrderManagementController::class, 'store'])->name('order-management.store');
    Route::get('/{id}', [OrderManagementController::class, 'show'])->name('order-management.show');
    Route::patch('/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('order-management.update-status');
    Route::patch('/{id}/notes', [OrderManagementController::class, 'updateNotes'])->name('order-management.update-notes');
    Route::delete('/{id}', [OrderManagementController::class, 'destroy'])->name('order-management.destroy');
    Route::get('/{id}/print', [OrderManagementController::class, 'print'])->name('order-management.print');
    Route::get('/{id}/export-pdf', [OrderManagementController::class, 'exportPdf'])->name('order-management.export-pdf');
});

// Ulasan publik: tampil + kirim (login wajib agar tidak spam)
Route::get('/ulasan', function () {
    return response()->json([
        'data' => Review::where('is_approved', true)->latest()->take(20)->get(['id', 'name', 'rating', 'text', 'created_at']),
    ]);
})->name('reviews.index');

Route::post('/ulasan', function (Request $request) {
    $data = $request->validate([
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'text' => ['required', 'string', 'min:4', 'max:500'],
    ]);

    $review = Review::create([
        'user_id' => $request->user()->id,
        'name' => $request->user()->name,
        'rating' => $data['rating'],
        'text' => trim(strip_tags($data['text'])),
        'is_approved' => true,
    ]);

    return response()->json(['message' => 'Ulasan terkirim, terima kasih!', 'data' => $review], 201);
})->middleware(['web', 'auth'])->name('reviews.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard member Warmindo Smoky (user biasa). Admin diarahkan ke dashboard admin.
    Route::get('/member', [WarmindoController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/member-dashboard', function () {
        return redirect()->route('member.dashboard');
    });
});
