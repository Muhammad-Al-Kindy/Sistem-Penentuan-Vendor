<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kriteriaId = $request->query('kriteriaId');


        $subkriterias = SubKriteria::when($search, function ($query, $search) {
            $query->where('namaSubKriteria', 'like', "%{$search}%");
        })->when($kriteriaId, function ($query, $kriteriaId) {
            $query->where('kriteriaId', $kriteriaId);
        })->paginate(10);

        return view('sub_kriteria.index', compact('subkriterias'));
    }
    public function create($kriteriaId)
    {
        $kriteria = Kriteria::findOrFail($kriteriaId);
        return view('sub_kriteria.add', compact('kriteria'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kriteriaId' => 'required|exists:kriterias,idKriteria',
            'namaSubKriteria' => 'required|string|max:255',
            'skorSubKriteria' => 'required|numeric',
        ]);

        SubKriteria::create($validated);

        return redirect()->route('subkriteria.index')->with('success', 'SubKriteria created successfully.');
    }
}
