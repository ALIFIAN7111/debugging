<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    // List semua pesanan
    public function index()
    {
        $orders = Order::with('items', 'cashier')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_pending' => Order::whereIn('status', ['Pending', 'Menunggu', 'Diproses', 'Siap'])->count(),
            'total_completed' => Order::where('status', 'Selesai')->count(),
            'total_cancelled' => Order::where('status', 'Batal')->count(),
        ];

        return view('admin.order-management.index', compact('orders', 'stats'));
    }

    // Filter pesanan
    public function filter(Request $request)
    {
        $query = Order::with('items', 'cashier');

        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->payment_method && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by customer name atau order code
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%'.$request->search.'%')
                    ->orWhere('order_code', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->latest()->paginate(20);

        $stats = [
            'total_pending' => Order::whereIn('status', ['Pending', 'Menunggu', 'Diproses', 'Siap'])->count(),
            'total_completed' => Order::where('status', 'Selesai')->count(),
            'total_cancelled' => Order::where('status', 'Batal')->count(),
        ];

        return view('admin.order-management.index', compact('orders', 'stats'));
    }

    // Detail pesanan
    public function show($id)
    {
        $order = Order::with('items', 'cashier')->findOrFail($id);

        return view('admin.order-management.show', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Pending,Diproses,Siap,Selesai,Batal',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return back()->with('status', 'Status pesanan berhasil diubah menjadi '.$validated['status']);
    }

    // Update catatan pesanan
    public function updateNotes(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['notes' => $validated['notes']]);

        return back()->with('status', 'Catatan pesanan berhasil diperbarui.');
    }

    // Buat pesanan baru
    public function create()
    {
        $products = Product::all();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('admin.order-management.create', compact('products', 'paymentMethods'));
    }

    // Store pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|exists:payment_methods,name',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))->get()->keyBy('id');

            $order = Order::create([
                'cashier_id' => $request->user()->id,
                'order_code' => 'ORD-'.now()->format('ymdHis').'-'.random_int(100, 999),
                'customer_name' => $validated['customer_name'] ?? 'Guest',
                'total' => 0,
                'payment_method' => $validated['payment_method'],
                'status' => 'Menunggu',
                'notes' => $validated['notes'] ?? null,
            ]);

            $total = 0;
            foreach ($validated['items'] as $item) {
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

        return redirect()->route('order-management.index')->with('status', 'Pesanan berhasil dibuat.');
    }

    // Hapus pesanan
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Hanya bisa hapus jika status masih antre (belum diproses kasir)
        if (! in_array($order->status, ['Pending', 'Menunggu'], true)) {
            return back()->with('error', 'Hanya pesanan Menunggu/Pending yang bisa dihapus.');
        }

        $order->items()->delete();
        $order->delete();

        return back()->with('status', 'Pesanan berhasil dihapus.');
    }

    // Print pesanan
    public function print($id)
    {
        $order = Order::with('items', 'cashier')->findOrFail($id);

        return view('admin.order-management.print', compact('order'));
    }

    // Export ke PDF
    public function exportPdf($id)
    {
        $order = Order::with('items', 'cashier')->findOrFail($id);

        // Simpan PDF menggunakan DOMPDF atau library lain
        // Untuk saat ini return view, nanti bisa integrate DOMPDF
        return view('admin.order-management.print', compact('order'));
    }
}
