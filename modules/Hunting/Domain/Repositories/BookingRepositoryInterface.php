<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Repositories;

use Modules\Hunting\Domain\Entities\HuntingBooking;

interface BookingRepositoryInterface
{
    public function existsForGuideOnDate(int $guideId, \DateTimeInterface $date): bool;

    public function create(array $attributes): HuntingBooking;
}
