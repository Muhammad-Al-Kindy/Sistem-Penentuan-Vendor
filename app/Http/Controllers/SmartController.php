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
            $request->validate([
                'alternatives' => 'required|array',
                'weights' => 'required|array',
                'types' => 'required|array',
            ]);

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

            $jsonString = escapeshellarg(json_encode($data));


            $pythonPath = base_path('resources/python/venv/Scripts/python.exe');
            $scriptPath = base_path('resources/python/smart_from_json.py');
            $scriptDir = dirname($scriptPath);

            $env = [
                'HOME' => base_path(),
                'USERPROFILE' => base_path(),
                'PYTHONASYNCIODEBUG' => '1',
                'JOBLIB_TEMP_FOLDER' => storage_path(),
            ];

$process = new Process([
    $pythonPath,
    $scriptPath,
    '--jsondata=' . json_encode($data)
], $scriptDir, $env);


            Log::info("Starting SMART process with data: " . $jsonString);
            $process->run();
            Log::info("SMART process completed with output: " . $process->getOutput());

            if (!$process->isSuccessful()) {
                Log::error("Python error:\n" . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }

            $result = json_decode($process->getOutput(), true);
            return view('smart.result', compact('result'));

        } catch (\Throwable $e) {
            Log::error("SMART Processing Error: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses SMART.');
        }
    }
}