<?php

namespace App\Services;

use App\Models\ReportProcess;

interface ReportLoggerInterface
{
    public function startProcess(int $categoryId): ReportProcess;

    public function completeProcess(ReportProcess $process, string $filePath = null): void;

    public function logError(ReportProcess $process, string $error): void;
}
