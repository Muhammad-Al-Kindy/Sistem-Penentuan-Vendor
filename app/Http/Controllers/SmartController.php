<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class SmartController extends Controller
{
    public function form()
    {
        return view('smart.form');
    }

    public function process(Request $request)
    {
        try {
            $alternatives = $request->input('alternatives');
            $weights = array_map('floatval', $request->input('weights'));
            $types = array_map('intval', $request->input('types'));

            $matrix = [];
            foreach ($alternatives as $row) {
                $matrix[] = array_map('floatval', $row);
            }

            $data = [
                "matrix" => $matrix,
                "weights" => $weights,
                "types" => $types,
            ];

            // Simpan ke input.json
            $jsonPath = storage_path('app/input.json');
            file_put_contents($jsonPath, json_encode($data));

            // Jalur Python virtualenv dan skrip
            $pythonPath = base_path('resources/python/venv/Scripts/python.exe');
            $scriptPath = base_path('resources/python/smart_from_file.py');
            $scriptDir = dirname($scriptPath);

            // Inject environment agar matplotlib tidak error
            $env = [
                'HOME' => base_path(),
                'USERPROFILE' => base_path(),
            ];

            // Eksekusi proses
            $process = new Process([$pythonPath, $scriptPath, $jsonPath], $scriptDir, $env);
            $process->run();

            // Tangani error
            if (!$process->isSuccessful()) {
                Log::error("Python error:\n" . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }

            // Ambil hasil dan tampilkan
        $result = json_decode($process->getOutput(), true);

        if (is_null($result) || !isset($result['scores'])) {
            return back()->withErrors(['error' => 'Invalid output from SMART calculation.']);
        }

        return view('smart.result', compact('result'));

        } catch (\Throwable $e) {
            Log::error("SMART Processing Error: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses SMART.');
        }
    }
}
