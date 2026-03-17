<?php

namespace App\Services;

interface FileHandlerInterface
{
    public function saveFile(int $categoryId, array $data): string;
}
