<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Persistence\Eloquent;

use Illuminate\Support\Collection;
use Modules\Hunting\Domain\Entities\Guide;
use Modules\Hunting\Domain\Repositories\GuideRepositoryInterface;

final class EloquentGuideRepository implements GuideRepositoryInterface
{

    public function getById(int $id): Guide|null
    {
        return Guide::query()->whereKey($id)->first();
    }

    public function listActive(?int $minExperience = null): Collection
    {
        $q = Guide::query()->active()->orderBy('name');

        if ($minExperience !== null) {
            $q->minExperience($minExperience);
        }

        return $q->get();
    }
}
