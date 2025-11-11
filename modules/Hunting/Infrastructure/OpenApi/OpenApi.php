<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\OpenApi;

/**
 * @OA\Info(
 *   title="BookingCore",
 *   version="1.0.0",
 *   description="Модуль охотничьих туров"
 * )
 *
 * @OA\Server(
 *   url="/api",
 *   description="API base path"
 * )
 *
 * @OA\Tag(
 *   name="Guides",
 *   description="Справочник активных гидов"
 * )
 *
 * @OA\Tag(
 *   name="Bookings",
 *   description="Бронирования охотничьих туров"
 * )
 */
final class OpenApi
{
}
