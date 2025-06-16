<?php
// app/Http/Controllers/SmartController.php
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
        $request->validate([
            'alternatives' => 'required|array',
            'weights' => 'required|array',
            'subcriteria' => 'required',
        ]);

        $alternatives = $request->input('alternatives');
        $weights = array_map('floatval', $request->input('weights'));
        $subcriteria = json_decode($request->input('subcriteria'), true);

        $matrix = [];
        foreach ($alternatives as $row) {
            $matrix[] = array_map('floatval', $row);
        }

        $types = [1, 1, 1, 1, -1]; // sesuai urutan subkriteria

        $pythonPath = 'C:\\Python312\\python.exe';
        $scriptPath = base_path('resources/python/smart_mode_args.py');
        $scriptDir = dirname($scriptPath);

        $env = [
            'HOME' => base_path(),
            'USERPROFILE' => base_path(),
        ];

        $process = new Process([
            $pythonPath,
            $scriptPath,
            '--matrix', json_encode($matrix),
            '--weights', json_encode($weights),
            '--types', json_encode($types),
            '--subcriteria', json_encode($subcriteria),
        ], $scriptDir, $env);

        Log::info("Starting SMART process with data: matrix=" . json_encode($matrix));
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("Python error: " . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $result = json_decode($process->getOutput(), true);
        $result['matrix'] = $matrix;
        return view('smart.result', compact('result'));
    }
}