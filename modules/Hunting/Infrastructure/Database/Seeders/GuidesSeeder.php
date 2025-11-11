<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Hunting\Domain\Entities\Guide;

final class GuidesSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            [
                'name' => 'Иван Иванов',
                'experience_years' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Петр Петров',
                'experience_years' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Александр Александров',
                'experience_years' => 8,
                'is_active' => false,
            ],
            [
                'name' => 'Сергей Сергеев',
                'experience_years' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Сидр Сидоров',
                'experience_years' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Василий Васильев',
                'experience_years' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Николай Николаев',
                'experience_years' => 1,
                'is_active' => false,
            ],
        ];

        foreach ($guides as $guide) {
            Guide::query()->updateOrCreate(
                ['name' => $guide['name']],
                $guide
            );
        }

        $this->command->info('Guides seeded successfully.');
    }
}
