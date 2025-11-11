<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class ModulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach (config('modules.enabled', []) as $name) {
            $provider = "Modules\\{$name}\\Infrastructure\\Providers\\{$name}ServiceProvider";
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }
}
