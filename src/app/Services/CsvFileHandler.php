<?php

namespace App\Services;
use Carbon\Carbon;

class CsvFileHandler implements FileHandlerInterface
{

    public function saveFile(int $categoryId, array $data): string
    {
        $fileName = $this->getFileName($categoryId, $data[0]->manufacturer_id);

        $filePath = storage_path("app/reports/$fileName");

        $file = fopen($filePath, 'w');

        fputcsv($file, ['manufacturer_name', 'product_name', 'price', 'price_date']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->manufacturer_name,
                $row->product_name,
                $row->price,
                $row->price_date
            ]);
        }

        fclose($file);

        return $filePath;
    }

    private function getFileName(int $categoryId, int $manufacturerId): string
    {
        return "report_{$manufacturerId}_{$categoryId}_" .
            Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
    }
}
