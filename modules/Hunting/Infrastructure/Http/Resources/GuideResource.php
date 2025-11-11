<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Hunting\Domain\Entities\Guide;

/** @mixin Guide */
final class GuideResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'experience_years' => $this->experience_years,
        ];
    }
}
