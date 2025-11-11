<?php

declare(strict_types=1);

namespace Modules\Hunting\Application\DTO;

use DateTimeImmutable;
use InvalidArgumentException;
use Modules\Hunting\Domain\Exceptions\ParticipantsLimitExceeded;

final readonly class CreateBookingDTO
{
    public function __construct(
        public string $tourName,
        public string $hunterName,
        public int $guideId,
        public DateTimeImmutable $date,
        public int $participantsCount
    ) {
        if ($this->participantsCount < 1 || $this->participantsCount > 10) {
            throw new ParticipantsLimitExceeded($this->participantsCount);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', (string)$data['date']);
        if (!$date) {
            throw new InvalidArgumentException('Invalid date format');
        }

        return new self(
            tourName: (string)$data['tour_name'],
            hunterName: (string)$data['hunter_name'],
            guideId: (int)$data['guide_id'],
            date: $date,
            participantsCount: (int)$data['participants_count'],
        );
    }
}
