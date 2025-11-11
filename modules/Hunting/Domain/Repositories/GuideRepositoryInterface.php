<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Repositories;

use Illuminate\Support\Collection;
use Modules\Hunting\Domain\Entities\Guide;

interface GuideRepositoryInterface
{
    public function getById(int $id): Guide|null;

    /** @return Collection<Guide> */
    public function listActive(?int $minExperience = null): Collection;
}
