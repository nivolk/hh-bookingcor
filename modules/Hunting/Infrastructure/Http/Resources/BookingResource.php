<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Hunting\Domain\Entities\HuntingBooking;

/** @mixin HuntingBooking */
final class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tour_name' => $this->tour_name,
            'hunter_name' => $this->hunter_name,
            'guide_id' => $this->guide_id,
            'date' => $this->date?->format('Y-m-d'),
            'participants_count' => $this->participants_count,
        ];
    }
}
