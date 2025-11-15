# Hunting Booking Module (Laravel 12)

## Задание

Создать минимальный Laravel-модуль, который реализует:

### Миграции и модели

* `Guide`: (`name`, `experience_years`, `is_active`)
* `HuntingBooking`: (`tour_name`, `hunter_name`, `guide_id`, `date`, `participants_count`)

### API-эндпоинты

* `GET /api/guides`: список активных гидов
* `POST /api/bookings`: создание нового бронирования

### Логика бронирования

* Проверить, что у выбранного гида нет других бронирований на ту же дату.
* Проверить, что `participants_count <= 10`.
* Вернуть осмысленные ответы (`200`, `201`, `400`, `409`, `422` и т.д.).

## Что оценивается

* Корректность и чистота кода.
* Использование Laravel best practices (модели, валидация, контроллеры, ресурсы).
* Структура проекта и понятность решений.
* Минимум "магии" - максимум логики.

## Бонус (по желанию)

* Добавить простейший Unit/Feature-тест.
* Сделать фильтр `GET /api/guides?min_experience=3`.
* Коротко описать в README.

---

## Реализация

Модуль Hunting создан в виде отдельного пакета `modules/Hunting`, подключаемого через `ModulesServiceProvider` 
на базе чистого Laravel 12.
Модуль построен по принципу feature-first и придерживается подхода лайтового DDD, то есть выделены основные
слои (Domain, Application, Infrastructure), но без излишней бюрократии и оверхеда.

Для удобства всё сразу готово под запуск в Laravel Sail с базой SQLite.

---

## Запуск

```bash
composer install
touch database/database.sqlite
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=Modules\\Hunting\\Infrastructure\\Database\\Seeders\\GuidesSeeder
```

## Тесты:
```bash
./vendor/bin/sail a test --filter=HuntingApiTest
```

## Документация API:
```
http://127.0.0.1/api/documentation
```
