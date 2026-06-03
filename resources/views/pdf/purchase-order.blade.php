<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order #{{ $po->id }}</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; color: #555; }
        .details { margin-bottom: 30px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th, .details td { padding: 8px; text-align: left; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 10px; }
        .items-table th { background-color: #f2f2f2; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total { margin-top: 20px; float: right; width: 40%; }
        .total table { width: 100%; }
        .total th, .total td { padding: 8px; }
        .total th { text-align: right; }
        .total .grand-total { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Purchase Order</h1>
        <p>PO #{{ $po->id }}</p>
    </div>

    <div class="details">
        <table>
            <tr>
                <td><strong>Toko:</strong></td>
                <td>{{ $po->store->name }}</td>
                <td><strong>Tanggal:</strong></td>
                <td class="text-right">{{ $po->created_at->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <table>
            <tr>
                <th>Grand Total:</th>
                <td class="grand-total text-right">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
