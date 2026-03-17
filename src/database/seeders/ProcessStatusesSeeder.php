<?php

namespace Database\Seeders;

use App\Models\ProcessStatus;
use Illuminate\Database\Seeder;

class ProcessStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $processStatuses = [
            'Запуск',
            'Завершен',
            'Ошибка'
        ];

        foreach($processStatuses as $processStatus) {
            ProcessStatus::create(['ps_name' => $processStatus]);
        }

    }
}
