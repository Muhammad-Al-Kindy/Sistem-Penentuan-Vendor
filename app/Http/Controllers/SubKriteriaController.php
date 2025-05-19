<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $subkriteria = SubKriteria::create($validated);

        Log::info("Added new SubKriteria: ", $subkriteria->toArray());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sub Kriteria berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('subkriteria.index', ['kriteriaId' => $validated['kriteriaId']])->with('status', 'stored');
    }

    public function edit($id){
        $subkriteria = SubKriteria::findOrFail($id);
        return view('sub_kriteria.edit', compact('subkriteria'));
    }

    public function update(Request $request, $id)
    {
        $sub = SubKriteria::findOrFail($id);

        $data = $request->only(['namaSubKriteria', 'skorSubKriteria']);

        Log::info("Updating SubKriteria id={$id} with data: ", $data);

        $sub->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sub Kriteria berhasil diperbarui.'
            ]);
        }

        return redirect()->route('subkriteria.index')->with('status', 'updated');
    }


    public function destroy($id)
    {
        $sub = SubKriteria::findOrFail($id);
        $sub->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Deleted successfully']);
        }

        return redirect()->route('subkriteria.index')->with('status', 'deleted');
    }

}
