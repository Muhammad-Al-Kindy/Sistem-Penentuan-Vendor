<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialVendorPrice;

class MaterialController extends Controller
{
    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodeMaterial' => 'required|string|max:255',
            'namaMaterial' => 'required|string|max:255',
            'satuanMaterial' => 'required|string|max:255',
            'deskripsiMaterial' => 'nullable|string',
            'harga' => 'nullable|numeric',
            'mataUang' => 'nullable|string|max:10',
            'vendorId' => 'required|exists:vendors,idVendor',
        ]);

        $material = new Material();
        $material->kodeMaterial = $validated['kodeMaterial'];
        $material->namaMaterial = $validated['namaMaterial'];
        $material->satuanMaterial = $validated['satuanMaterial'];
        $material->deskripsiMaterial = $validated['deskripsiMaterial'] ?? null;
        $material->save();

        $materialVendorPrice = new MaterialVendorPrice();
        $materialVendorPrice->materialId = $material->idMaterial;
        $materialVendorPrice->vendorId = $validated['vendorId'];
        $materialVendorPrice->harga = $validated['harga'] ?? 0;
        $materialVendorPrice->mataUang = $validated['mataUang'] ?? '';
        $materialVendorPrice->save();

        return response()->json(['material' => $material], 201);
    }

    /**
     * Get materials filtered by vendor ID.
     */
    public function getByVendor(Request $request)
    {
        $vendorId = $request->query('vendorId');
        if (!$vendorId) {
            return response()->json(['error' => 'vendorId query parameter is required'], 400);
        }

        $materials = Material::select('materials.*')
            ->join('material_vendor_prices', 'materials.idMaterial', '=', 'material_vendor_prices.materialId')
            ->where('material_vendor_prices.vendorId', $vendorId)
            ->distinct()
            ->get();

        return response()->json(['materials' => $materials]);
    }
}
