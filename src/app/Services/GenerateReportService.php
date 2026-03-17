<?php

namespace App\Services;

use AllowDynamicProperties;
use App\Repositories\PriceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[AllowDynamicProperties] class GenerateReportService
{
    public function __construct(int                      $categoryId,
                                PriceRepositoryInterface $reportDataRepository,
                                FileHandlerInterface     $fileHandler,
                                ReportLoggerInterface    $reportLogger
    )
    {
        $this->categoryId = $categoryId;
        $this->reportDataRepository = $reportDataRepository;
        $this->fileHandler = $fileHandler;
        $this->reportLogger = $reportLogger;
    }

    public function handle()
    {
        $filePath = null;
        $process = $this->reportLogger->startProcess($this->categoryId);

        try {
            $results = $this->reportDataRepository->getData($this->categoryId);

            if (empty($results)) {
                return 1; // Код ошибки для случая с пустым результатом
            }

            $filePath = $this->fileHandler->saveFile($this->categoryId, $results);
        } catch (\Error $e) {
            $this->reportLogger->logError($process, $e->getMessage());
            return 2; // Код ошибки
        }

        $this->reportLogger->completeProcess($process, $filePath);

        return 0; // Успешное выполнение
    }
}
