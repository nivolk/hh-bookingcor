<?php

declare(strict_types=1);

namespace Modules\Hunting\Application\DTO;

final readonly class GuidesFilterDTO
{
    public function __construct(
        public ?int $minExperience
    ) {
    }

    public static function fromArray(array $data): self
    {
        $min = $data['min_experience'] ?? null;
        return new self(
            minExperience: isset($min) ? (int)$min : null
        );
    }
}
