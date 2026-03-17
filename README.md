docker compose up -d
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed 
Чтобы сгенерировать отчет: docker compose exec app php artisan report:generate {category_id}
