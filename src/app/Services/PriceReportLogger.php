<?php

namespace App\Services;

use App\Models\ProcessStatus;
use App\Models\ReportProcess;
use Carbon\Carbon;

class PriceReportLogger implements ReportLoggerInterface
{
    public function startProcess(int $categoryId): ReportProcess
    {
        return ReportProcess::create([
            'rp_pid' => uniqid('report_', true),
            'rp_start_datetime' => Carbon::now(),
            'ps_id' => ProcessStatus::STATUS_STARTING,
            'category_id' => $categoryId
        ]);
    }

    public function completeProcess(ReportProcess $process, string $filePath = null): void
    {
        $endTime = Carbon::now();
        $executionTime = $endTime->diffInSeconds($process->rp_start_datetime, true) +
            ($endTime->micro / 1000000 - $process->rp_start_datetime->micro / 1000000);

        $process->update([
            'rp_exec_time' => round($executionTime, 4),
            'ps_id' => is_null($filePath) ? ProcessStatus::STATUS_ERROR : ProcessStatus::STATUS_COMPLETED,
            'rp_file_save_path' => $filePath
        ]);
    }

    public function logError(ReportProcess $process, string $error): void
    {
        $this->completeProcess($process);
        \Log::error('Report generation error: ' . $error, [
            'process_id' => $process->rp_pid,
            'category_id' => $process->category_id
        ]);
    }
}
