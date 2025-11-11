<?php

declare(strict_types=1);

namespace Modules\Hunting\Application\Services;

use DomainException;
use Illuminate\Support\Facades\DB;
use Modules\Hunting\Application\DTO\CreateBookingDTO;
use Modules\Hunting\Domain\Entities\Guide;
use Modules\Hunting\Domain\Entities\HuntingBooking;
use Modules\Hunting\Domain\Repositories\BookingRepositoryInterface;
use Modules\Hunting\Domain\Repositories\GuideRepositoryInterface;
use Throwable;

final readonly class BookingService
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository,
        private GuideRepositoryInterface $guideRepository,
    ) {
    }

    /**
     * @throws DomainException
     * @throws Throwable
     */
    public function create(CreateBookingDTO $dto): HuntingBooking
    {
        return DB::transaction(function () use ($dto) {
            /** @var Guide|null $guide */
            $guide = $this->guideRepository->getById($dto->guideId);

            if (!$guide || !$guide->is_active) {
                throw new DomainException('Guide is inactive or not found');
            }

            if ($this->bookingRepository->existsForGuideOnDate($dto->guideId, $dto->date)) {
                throw new DomainException('Guide already has a booking on this date');
            }

            return $this->bookingRepository->create([
                'tour_name' => $dto->tourName,
                'hunter_name' => $dto->hunterName,
                'guide_id' => $dto->guideId,
                'date' => $dto->date->format('Y-m-d'),
                'participants_count' => $dto->participantsCount,
            ]);
        });
    }
}
