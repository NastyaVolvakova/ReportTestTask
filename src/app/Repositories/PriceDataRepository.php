<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PriceDataRepository implements PriceRepositoryInterface
{

    public function getData(int $categoryId): array
    {
        $weekAgo = Carbon::now()->subDays(7)->format('Y-m-d');

        return DB::select(
            '
            WITH recent_prices AS (
                SELECT
                    p.product_id,
                    p.price,
                    p.price_date,
            ROW_NUMBER() OVER (PARTITION BY p.product_id ORDER BY p.price ASC) as min_rank,
            ROW_NUMBER() OVER (PARTITION BY p.product_id ORDER BY p.price DESC) as max_rank
                FROM prices p
                WHERE p.price_date >= ?
            ),
            min_max_prices AS (
                SELECT
                    rp.product_id,
            MIN(CASE WHEN rp.min_rank = 1 THEN rp.price END) as min_price,
            MAX(CASE WHEN rp.max_rank = 1 THEN rp.price END) as max_price,
            MIN(CASE WHEN rp.min_rank = 1 THEN rp.price_date END) as min_price_date,
            MAX(CASE WHEN rp.max_rank = 1 THEN rp.price_date END) as max_price_date
                FROM recent_prices rp
                GROUP BY rp.product_id
            )
            -- Формируем две строки на товар: минимальная и максимальная цена
            SELECT
                m.manufacturer_name,
                m.manufacturer_id,
                pr.product_name,
                ROUND(mm.min_price::numeric, 2) as price,
                mm.min_price_date as price_date
            FROM min_max_prices mm
            JOIN products pr ON mm.product_id = pr.product_id
            JOIN manufacturers m ON pr.manufacturer_id = m.manufacturer_id
            WHERE pr.category_id = ?

            UNION ALL

            SELECT
                m.manufacturer_name,
                m.manufacturer_id,
                pr.product_name,
                ROUND(mm.max_price::numeric, 2) as price,
                mm.max_price_date as price_date
            FROM min_max_prices mm
            JOIN products pr ON mm.product_id = pr.product_id
            JOIN manufacturers m ON pr.manufacturer_id = m.manufacturer_id
            WHERE pr.category_id = ? AND mm.max_price IS NOT NULL
            ORDER BY manufacturer_name, product_name, price', [$weekAgo, $categoryId, $categoryId]);
    }
}
