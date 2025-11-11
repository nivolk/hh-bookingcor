<?php

declare(strict_types=1);

namespace Modules\Hunting\Application\Services;

use Illuminate\Support\Facades\DB;
use Modules\Hunting\Application\DTO\CreateBookingDTO;
use Modules\Hunting\Domain\Entities\Guide;
use Modules\Hunting\Domain\Entities\HuntingBooking;
use Modules\Hunting\Domain\Exceptions\GuideAlreadyBooked;
use Modules\Hunting\Domain\Exceptions\GuideInactive;
use Modules\Hunting\Domain\Exceptions\GuideNotFound;
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
     * @param CreateBookingDTO $dto
     * @return HuntingBooking
     * @throws Throwable
     */
    public function create(CreateBookingDTO $dto): HuntingBooking
    {
        return DB::transaction(function () use ($dto) {
            /** @var Guide|null $guide */
            $guide = $this->guideRepository->getById($dto->guideId);

            if (!$guide) {
                throw new GuideNotFound();
            }
            if (!$guide->is_active) {
                throw new GuideInactive();
            }

            if ($this->bookingRepository->existsForGuideOnDate($dto->guideId, $dto->date)) {
                throw new GuideAlreadyBooked();
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
