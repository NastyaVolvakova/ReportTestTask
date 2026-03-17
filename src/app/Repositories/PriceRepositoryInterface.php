<?php

namespace App\Repositories;

interface PriceRepositoryInterface
{
    public function getData(int $categoryId): array;
}
