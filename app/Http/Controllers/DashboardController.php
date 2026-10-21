<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\ProductionStock;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Stats Utama
        $stats = [
            'sales_today' => Order::whereDate('created_at', $today)->where('status', 'Selesai')->sum('total'),
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'sales_month' => Order::whereBetween('created_at', [$thisMonth, now()])->where('status', 'Selesai')->sum('total'),
            'orders_month' => Order::whereBetween('created_at', [$thisMonth, now()])->count(),
            'expenses_month' => Expense::whereBetween('spent_at', [$thisMonth, now()])->sum('amount'),
            'profit_month' => Order::whereBetween('created_at', [$thisMonth, now()])->where('status', 'Selesai')->sum('total') - Expense::whereBetween('spent_at', [$thisMonth, now()])->sum('amount'),
        ];

        // Top Products
        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as qty'), DB::raw('SUM(subtotal) as total'))
            ->groupBy('product_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('items')->latest()->take(10)->get();

        // Low Stock Ingredients
        $lowStockIngredients = Ingredient::whereColumn('stock', '<=', 'minimum_stock')->get();

        // Payment Methods Distribution
        $paymentMethods = DB::table('orders')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->where('status', 'Selesai')
            ->whereBetween('created_at', [$thisMonth, now()])
            ->groupBy('payment_method')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'topProducts',
            'recentOrders',
            'lowStockIngredients',
            'paymentMethods'
        ));
    }

    // Settings Management
    public function settings()
    {
        $settings = [
            'shop_name' => SystemSetting::get('shop_name', 'WM SMOKY'),
            'shop_phone' => SystemSetting::get('shop_phone', '+62 812-3456-7890'),
            'shop_address' => SystemSetting::get('shop_address', 'Warmindo Smokey, Jl. Jend. Achmad Yani, Api-Api, Bontang Utara'),
            'operating_hours' => SystemSetting::get('operating_hours', '19:00 - 00:00'),
            'tax_rate' => SystemSetting::get('tax_rate', 0),
            'service_charge' => SystemSetting::get('service_charge', 0),
            'catalog_label' => SystemSetting::get('catalog_label', 'Katalog Menu'),
            'catalog_title' => SystemSetting::get('catalog_title', 'Pilih jagoanmu malam ini'),
            'catalog_subtitle' => SystemSetting::get('catalog_subtitle', 'Dimasak fresh setelah kamu pesan.'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings()
    {
        $validated = request()->validate([
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'shop_address' => 'required|string|max:500',
            'operating_hours' => 'required|string',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'service_charge' => 'required|numeric|min:0|max:100',
            'catalog_label' => 'required|string|max:80',
            'catalog_title' => 'required|string|max:120',
            'catalog_subtitle' => 'required|string|max:200',
        ]);

        // Simpan ke database
        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return back()->with('status', 'Pengaturan berhasil disimpan.');
    }

    // Analytics
    public function analytics()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Daily Sales (7 hari terakhir)
        $dailySales = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->where('status', 'Selesai')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Category Performance
        $categoryPerformance = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as qty'), DB::raw('SUM(subtotal) as total'))
            ->whereBetween('created_at', [$thisMonth, now()])
            ->groupBy('product_name')
            ->orderByDesc('total')
            ->get();

        // Monthly Comparison (6 bulan terakhir, lintas MySQL/SQLite)
        $monthExpr = DB::getDriverName() === 'sqlite' ? "strftime('%m', created_at)" : 'MONTH(created_at)';
        $monthlyComparison = DB::table('orders')
            ->select(
                DB::raw($monthExpr.' as month'),
                DB::raw('SUM(total) as sales'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('status', 'Selesai')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw($monthExpr))
            ->orderBy('month')
            ->get();

        return view('admin.analytics', compact(
            'dailySales',
            'categoryPerformance',
            'monthlyComparison'
        ));
    }

    // Inventory Management
    public function inventory()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $productionStocks = ProductionStock::latest()->get();

        return view('admin.inventory', compact('ingredients', 'productionStocks'));
    }

    public function addIngredient()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'unit' => 'required|string|max:30',
            'stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
        ]);

        Ingredient::create($validated);

        return back()->with('status', 'Bahan baku berhasil ditambahkan.');
    }

    public function updateIngredient($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $validated = request()->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,'.$id,
            'unit' => 'required|string|max:30',
            'stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
        ]);

        $ingredient->update($validated);

        return back()->with('status', 'Bahan baku berhasil diperbarui.');
    }

    public function deleteIngredient($id)
    {
        Ingredient::destroy($id);

        return back()->with('status', 'Bahan baku berhasil dihapus.');
    }
}
