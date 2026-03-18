# Руководство по запуску и работе с проектом

Этот проект использует Docker Compose для оркестрации сервисов. Ниже приведены инструкции по запуску, настройке базы данных и генерации отчётов.

## Быстрый старт

Чтобы запустить и подготовить проект к работе выполните команды:

```bash
docker compose up -d
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

## Быстрый старт
Чтобы сгенерировать отчет выполните команду:

```bash
docker compose exec app php artisan report:generate {category_id}
```
