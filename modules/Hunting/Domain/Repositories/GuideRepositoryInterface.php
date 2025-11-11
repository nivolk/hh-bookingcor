<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Repositories;

use Modules\Hunting\Domain\Collections\GuideCollection;
use Modules\Hunting\Domain\Entities\Guide;

interface GuideRepositoryInterface
{
    public function getById(int $id): Guide|null;

    public function listActive(?int $minExperience = null): GuideCollection;
}
