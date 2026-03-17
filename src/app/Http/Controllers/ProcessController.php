<?php

namespace App\Http\Controllers;

use App\Models\ReportProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessController extends Controller
{
    public function index()
    {
        $processes = ReportProcess::with('status')
            ->orderBy('rp_start_datetime', 'desc')
            ->paginate(20);

        return view('reports.processes', compact('processes'));
    }

    public function downloadFile(string $filePath)
    {
        $filePath = 'reports/' . $filePath;
        try {
            if (!Storage::exists($filePath)) {
                abort(404, 'Файл не найден');
            }

            return Storage::download($filePath);
        } catch (\Exception $e) {
            abort(500, 'Ошибка при загрузке файла');
        }
    }
}
