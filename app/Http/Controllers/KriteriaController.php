<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kriterias = Kriteria::when($search, function ($query, $search) {
            $query->where('namaKriteria', 'like', "%{$search}%");
        })->paginate(10); // Show 10 per page

        return view('admin.kriteria.index', compact('kriterias'));
    }
}
