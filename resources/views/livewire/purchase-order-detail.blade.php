<div class="max-w-4xl mx-auto my-10 px-4">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800">Detail Purchase Order</h2>
                <p class="text-sm text-gray-500">PO #{{ $po->id }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-gray-700">{{ $po->store->name }}</p>
                <p class="text-sm text-gray-500">{{ $po->created_at->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="p-5 bg-gray-50 border-b border-gray-100">
            <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">Items</h3>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100/50 text-gray-500 text-xs font-bold uppercase border-b border-gray-100">
                    <th class="p-4">Nama Barang</th>
                    <th class="p-4 text-right">Harga</th>
                    <th class="p-4 text-center">Qty</th>
                    <th class="p-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($po->items as $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 font-medium text-gray-800">{{ $item->name }}</td>
                        <td class="p-4 text-right font-mono text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-4 text-center font-mono text-gray-600">{{ $item->quantity }}</td>
                        <td class="p-4 text-right font-mono text-gray-600">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100/50 font-bold">
                    <td colspan="3" class="p-4 text-right text-gray-700">Grand Total</td>
                    <td class="p-4 text-right font-mono text-gray-800">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="mt-6 text-center">
        <a href="{{ route('purchase-orders.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            &larr; Kembali ke Daftar PO
        </a>
    </div>
</div>
