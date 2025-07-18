<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $vendors = Vendor::when($search, function ($query, $search) {
            $query->where('namaVendor', 'like', "%{$search}%")
                ->orWhere('NPWP', 'like', "%{$search}%")
                ->orWhere('jenisPerusahaan', 'like', "%{$search}%")
                ->orWhere('alamatVendor', 'like', "%{$search}%");
        })->paginate(10)->appends(['search' => $search]); // Show 10 per page

        return view('vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendor.add');
    }

    public function store(Request $request)
    {
        // Create new user with role vendor and default password
        $user = \App\Models\User::create([
            'name' => $request->input('namaVendor'),
            'email' => $request->input('email'),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'vendor',
        ]);

        // Create vendor linked to user
        $vendorData = $request->only(['namaVendor', 'alamatVendor', 'NPWP', 'jenisPerusahaan', 'SPPKP', 'nomorIndukPerusahaan']);
        $vendorData['user_id'] = $user->idUser;
        $vendor = Vendor::create($vendorData);
        Log::info("Added new vendor: ", $vendor->toArray());

        $contactData = $request->only(['contactPerson', 'telepon', 'fax', 'email', 'jabatan']);
        if (!empty($contactData['contactPerson'])) {
            $vendor->contacts()->create([
                'contactPerson' => $contactData['contactPerson'],
                'telepon' => $contactData['telepon'] ?? null,
                'fax' => $contactData['fax'] ?? null,
                'email' => $contactData['email'] ?? null,
                'jabatan' => $contactData['jabatan'] ?? null,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vendor berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('vendor.index')->with('status', 'stored');
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        // Update vendor info
        $vendor->update($request->only(['namaVendor', 'alamatVendor', 'NPWP', 'jenisPerusahaan', 'SPPKP', 'nomorIndukPerusahaan']));

        // Update linked user name
        if ($vendor->user) {
            $vendor->user->update([
                'name' => $request->input('namaVendor'),
                'email' => $request->input('email'), // optionally update email if provided
            ]);
        }

        $contactData = $request->only(['contactPerson', 'telepon', 'fax', 'email', 'jabatan']);
        $contact = $vendor->contacts()->first();

        if ($contact) {
            $contact->update([
                'contactPerson' => $contactData['contactPerson'] ?? $contact->contactPerson,
                'telepon' => $contactData['telepon'] ?? $contact->telepon,
                'fax' => $contactData['fax'] ?? $contact->fax,
                'email' => $contactData['email'] ?? $contact->email,
                'jabatan' => $contactData['jabatan'] ?? $contact->jabatan,
            ]);
        } else {
            if (!empty($contactData['contactPerson'])) {
                $vendor->contacts()->create([
                    'contactPerson' => $contactData['contactPerson'],
                    'telepon' => $contactData['telepon'] ?? null,
                    'fax' => $contactData['fax'] ?? null,
                    'email' => $contactData['email'] ?? null,
                    'jabatan' => $contactData['jabatan'] ?? null,
                ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vendor berhasil diperbarui.'
            ]);
        }

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            // Delete related contacts and evaluations first to avoid foreign key constraint errors
            $vendor->contacts()->delete();
            $vendor->evaluations()->delete();

            // Delete linked user account
            if ($vendor->user) {
                $vendor->user->delete();
            }

            $vendor->delete();
            if (request()->ajax()) {
                return response()->json(['success' => 'Vendor berhasil dihapus.']);
            }
            return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting vendor: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete vendor.'], 500);
            }
            return redirect()->route('vendor.index')->with('error', 'Gagal menghapus vendor.');
        }
    }

    public function purchaseOrder()
    {
        return view('vendor.purchase_order');
    }

    public function riwayatEvaluasi()
    {
        return view('vendor.riwayat_evaluasi');
    }

    public function reports()
    {
        $user = auth()->user();

        // Assuming vendor is related to user via user_id
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Unauthorized: No vendor associated with user.');
        }

        $nonConformances = \App\Models\NonConformance::whereHas('goodsReceiptItem.goodsReceipt', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->idVendor);
        })->orderBy('tanggal_ditemukan', 'desc')->paginate(10);

        return view('vendor.reports', compact('nonConformances'));
    }
}