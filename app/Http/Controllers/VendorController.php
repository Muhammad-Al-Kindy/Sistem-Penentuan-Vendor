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

        $vendors = \App\Models\Vendor::when($search, function ($query, $search) {
            $query->where('namaVendor', 'like', "%{$search}%");
        })->paginate(10); // Show 10 per page

        return view('vendor.index', compact('vendors'));
    }
    public function create()
    {
        return view('vendor.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'namaVendor' => 'required|string',
        'alamatVendor' => 'required|string',
        'NPWP' => 'required|string',
        'SPPKP' => 'required|string',
        'nomorIndukPerusahaan' => 'required|string',
        'jenisPerusahaan' => 'required|string',
    ]);


        $vendor = Vendor::create($validated);

        Log::info("Added new vendor: ", $vendor->toArray());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vendor berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('vendor.index')->with('status', 'stored');
    }

    public function edit($id){
        $vendor = Vendor::findOrFail($id);
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $data = $request->only(['namaVendor', 'alamatVendor','NPWP','SPPKP','nomorIndukPerusahaan','jenisPerusahaan']);

        Log::info("Updating Vendor id={$id} with data: ", $data);

        $vendor->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sub Kriteria berhasil diperbarui.'
            ]);
        }

        return redirect()->route('vendor.index')->with('status', 'updated');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Deleted successfully']);
        }

        return redirect()->route('vendor.index')->with('status', 'deleted');
    }
}