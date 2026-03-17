<?php

namespace App\Console\Commands;

use App\Repositories\PriceDataRepository;
use App\Services\CsvFileHandler;
use App\Services\GenerateReportService;
use App\Services\PriceReportLogger;
use Illuminate\Console\Command;

class GenerateCategoryReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate {category_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерирует CSV-отчёт по категории товаров с min/max ценами за 7 дней';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $processCode = (new GenerateReportService(
            $this->argument('category_id'),
            new PriceDataRepository,
            new CsvFileHandler(),
            new PriceReportLogger()))
            ->handle();

        switch ($processCode) {
            case 0:
                $this->info("Отчёт сгенерирован");
                break;
            case 1:
                $this->error('Для указанной категории нет товаров');
                break;
            case 2:
                $this->error('Произошла ошибка');
                break;
        }
    }

}
