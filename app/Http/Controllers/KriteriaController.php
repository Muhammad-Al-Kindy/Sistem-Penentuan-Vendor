<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kriterias = \App\Models\Kriteria::when($search, function ($query, $search) {
            $query->where('namaKriteria', 'like', "%{$search}%");
        })->paginate(10); // Show 10 per page

        return view('kriteria.index', compact('kriterias'));
    }

    // public function destroy($id)
    // {
    //     $kriteria = \App\Models\Kriteria::findOrFail($id);
    //     $kriteria->delete();

    //     return redirect()->route('kriteria.index')->with('success', 'Kriteria deleted successfully.');
    // }

    // public function tambah_kriteria()
    // {
    //     return view('kriteria.detail');
    // }
}
