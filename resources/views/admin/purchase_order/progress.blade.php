@extends('layouts.app')

@section('title', 'Progress Purchase Order')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Progress Purchase Order</h1>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-2">Detail PO</h2>
            <p><strong>No PO:</strong> {{ $order->noPO }}</p>
            <p><strong>Tanggal PO:</strong> {{ $order->tanggalPO->format('Y-m-d') }}</p>
            <p><strong>Vendor:</strong> {{ $order->vendor->namaVendor ?? '-' }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Riwayat Update</h2>
            <table class="min-w-full table-auto text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Tanggal</th>
                        <th class="border px-4 py-2 text-left">Jenis Update</th>
                        <th class="border px-4 py-2 text-left">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->vendorUpdates as $update)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ \Carbon\Carbon::parse($update->tanggal_update)->format('d M Y') }}</td>
                            <td class="border px-4 py-2">{{ $update->jenis_update }}</td>
                            <td class="border px-4 py-2">
                                @if ($update->dokumen)
                                    <a href="{{ asset('storage/vendor_updates/' . $update->dokumen) }}" target="_blank"
                                        class="text-blue-600 underline">Lihat Dokumen</a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-2 text-gray-500">Belum ada riwayat update.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (!isset($latestUpdate) || $latestUpdate->jenis_update !== 'Dibatalkan')
                <form action="{{ route('purchase.cancel', $order->idPurchaseOrder) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan purchase order ini?')" class="mt-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Alasan
                            Pembatalan:</label>
                        <textarea id="keterangan" name="keterangan" rows="3" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-red-400"
                            placeholder="Contoh: Vendor tidak bisa memenuhi permintaan tepat waktu..."></textarea>
                    </div>

                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Batalkan Purchase Order
                    </button>
                </form>
            @endif


        </div>
    </div>
@endsection
