<?php

namespace App\Http\Controllers;

use App\Models\NonConformance;
use Illuminate\Http\Request;

class NonConformanceController extends Controller
{
    public function index(Request $request)
    {
        $nonConformances = NonConformance::orderBy('tanggal_ditemukan', 'desc')->paginate(10);
        return view('vendor.reports', compact('nonConformances'));
    }
}
