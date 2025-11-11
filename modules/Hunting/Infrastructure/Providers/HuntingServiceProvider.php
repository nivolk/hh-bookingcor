<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Hunting\Domain\Repositories\BookingRepositoryInterface;
use Modules\Hunting\Domain\Repositories\GuideRepositoryInterface;
use Modules\Hunting\Infrastructure\Persistence\Eloquent\EloquentBookingRepository;
use Modules\Hunting\Infrastructure\Persistence\Eloquent\EloquentGuideRepository;

final class HuntingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->app->bind(GuideRepositoryInterface::class, EloquentGuideRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, EloquentBookingRepository::class);
    }

    public function boot(): void
    {
    }
}
