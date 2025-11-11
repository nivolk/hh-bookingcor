<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Persistence\Eloquent;

use DateTimeInterface;
use Modules\Hunting\Domain\Entities\HuntingBooking;
use Modules\Hunting\Domain\Repositories\BookingRepositoryInterface;

final class EloquentBookingRepository implements BookingRepositoryInterface
{
    public function existsForGuideOnDate(int $guideId, DateTimeInterface $date): bool
    {
        return HuntingBooking::query()
            ->where('guide_id', $guideId)
            ->whereDate('date', $date->format('Y-m-d'))
            ->exists();
    }

    public function create(array $attributes): HuntingBooking
    {
        /** @var HuntingBooking $booking */
        $booking = HuntingBooking::query()->create($attributes);
        return $booking->refresh();
    }
}
