# Hunting

Особенности:
- Код реализован как отдельный модуль и подключён через ModulesServiceProvider.
- По умолчанию все настроено на Sail и SQLite.

## Запуск с Sail
`composer install`
`touch database/database.sqlite`
`./vendor/bin/sail up -d`
`./vendor/bin/sail artisan migrate`
`./vendor/bin/sail artisan db:seed --class=Modules\Hunting\Infrastructure\Database\Seeders\GuidesSeeder`

Документация доступна по адресу: http://localhost/api/documentation
Генерация документации: `./vendor/bin/sail artisan l5-swagger:generate`

Прогон теста: `./vendor/bin/sail a test --filter=HuntingApiTest`


## Встроить модуль в существующее ядро BookingCore можно так:

1. Скопировать каталог `modules/Hunting` в корень проекта.
2. В `composer.json` в секции `"psr-4"` добавить `"Modules\\": "modules/"` и выполнить `composer dump-autoload`.
3. Зарегистрировать провайдер модуля.
4. Запустить миграции и сиды гидов `artisan db:seed --class=Modules\Hunting\Infrastructure\Database\Seeders\GuidesSeeder`.

