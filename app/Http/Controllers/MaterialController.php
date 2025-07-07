<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

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
        ]);

        $material = new Material();
        $material->kodeMaterial = $validated['kodeMaterial'];
        $material->namaMaterial = $validated['namaMaterial'];
        $material->satuanMaterial = $validated['satuanMaterial'];
        $material->deskripsiMaterial = $validated['deskripsiMaterial'] ?? null;
        $material->save();

        return response()->json(['material' => $material], 201);
    }
}
