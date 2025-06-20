<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// class VendorController extends Controller
// {
//     public function index(Request $request)
//     {
//         $search = $request->input('search');

//         $vendors = \App\Models\Vendor::when($search, function ($query, $search) {
//             $query->where('namaVendor', 'like', "%{$search}%");
//         })->paginate(10); // Show 10 per page

//         return view('vendor.index', compact('vendors'));
//     }
//     public function create()
//     {
//         return view('vendor.add');
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//         'namaVendor' => 'required|string',
//         'alamatVendor' => 'required|string',
//         'NPWP' => 'required|string',
//         'SPPKP' => 'required|string',
//         'nomorIndukPerusahaan' => 'required|string',
//         'jenisPerusahaan' => 'required|string',
//     ]);


//         $vendor = Vendor::create($validated);

//         Log::info("Added new vendor: ", $vendor->toArray());

//         if ($request->expectsJson()) {
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Vendor berhasil ditambahkan.'
//             ]);
//         }

//         return redirect()->route('vendor.index')->with('status', 'stored');
//     }

//     public function edit($id){
//         $vendor = Vendor::findOrFail($id);
//         return view('vendor.edit', compact('vendor'));
//     }

//     public function update(Request $request, $id)
//     {
//         $vendor = Vendor::findOrFail($id);
//         $data = $request->only(['namaVendor', 'alamatVendor','NPWP','SPPKP','nomorIndukPerusahaan','jenisPerusahaan']);

//         Log::info("Updating Vendor id={$id} with data: ", $data);

//         $vendor->update($data);

//         if ($request->expectsJson()) {
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Sub Kriteria berhasil diperbarui.'
//             ]);
//         }

//         return redirect()->route('vendor.index')->with('status', 'updated');
//     }

//     public function destroy($id)
//     {
//         $vendor = Vendor::findOrFail($id);
//         $vendor->delete();

//         if (request()->expectsJson()) {
//             return response()->json(['message' => 'Deleted successfully']);
//         }

//         return redirect()->route('vendor.index')->with('status', 'deleted');
//     }
// }


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

    public function show(Vendor $vendors)
    {
        return view('vendors.show', compact('vendors'));
    }

    public function edit(Vendor $vendors)
    {
        $vendor = Vendor::findOrFail($vendors);
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendors)
    {
        $vendors->update($request->all());
        return redirect()->route('vendors.index')->with('success', 'Vendors berhasil diperbarui.');
    }

    public function destroy(Vendor $vendors)
    {
        $vendors->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendors berhasil dihapus.');
    }
}
