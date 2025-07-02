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
        $vendor = Vendor::create($request->all());
        Log::info("Added new vendor: ", $vendor->toArray());

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
        $vendor->update($request->all());

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
}