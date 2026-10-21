<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Pesanan - {{ $order->order_code }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: white;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 1px solid #ddd;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #FF5E00;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 12px;
        }

        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .info-group {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
        }

        .info-group label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .info-group p {
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background-color: #FF5E00;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .summary-box {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-row.total {
            border-top: 2px solid #FF5E00;
            padding-top: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #FF5E00;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-selesai {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-batal {
            background-color: #fee2e2;
            color: #991b1b;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                border: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            padding: 10px 30px;
            background-color: #FF5E00;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .print-button button:hover {
            background-color: #E64A00;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button onclick="window.print()">🖨️ Print Pesanan</button>
        <button onclick="window.history.back()" style="background-color: #999; margin-left: 10px;">← Kembali</button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔥 WM SMOKY</h1>
            <p>Tempat Nongkrong Hits Bontang</p>
            <p style="margin-top: 10px; font-weight: bold;">STRUK PESANAN</p>
        </div>

        <!-- Order Info -->
        <div class="order-info">
            <div class="info-group">
                <label>No. Pesanan</label>
                <p>{{ $order->order_code }}</p>
            </div>
            <div class="info-group">
                <label>Tanggal & Waktu</label>
                <p>{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="info-group">
                <label>Nama Pelanggan</label>
                <p>{{ $order->customer_name ?? 'Guest' }}</p>
            </div>
            <div class="info-group">
                <label>Metode Pembayaran</label>
                <p>{{ $order->payment_method }}</p>
            </div>
            <div class="info-group">
                <label>Status</label>
                <p>
                    @if($order->status === 'Selesai')
                        <span class="status status-selesai">Selesai</span>
                    @elseif($order->status === 'Pending')
                        <span class="status status-pending">Pending</span>
                    @else
                        <span class="status status-batal">Batal</span>
                    @endif
                </p>
            </div>
            <div class="info-group">
                <label>Kasir</label>
                <p>{{ $order->cashier?->name ?? 'Sistem' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Item</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 20%; text-align: right;">Harga</th>
                    <th style="width: 25%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">Tidak ada item</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-box">
                <div class="summary-row">
                    <span>Total Item:</span>
                    <span>{{ $order->items->count() }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        @if($order->notes)
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 4px; margin-bottom: 30px;">
                <label style="font-weight: bold; display: block; margin-bottom: 10px;">Catatan Pesanan:</label>
                <p style="color: #666; font-size: 14px;">{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas pesanan Anda! 🔥</p>
            <p>Jl. Ahmad Yani No. 88, Bontang | 19:00 - 00:00 WITA</p>
            <p style="margin-top: 20px; font-size: 10px; color: #999;">
                Dicetak pada: {{ now()->format('d M Y H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html>
