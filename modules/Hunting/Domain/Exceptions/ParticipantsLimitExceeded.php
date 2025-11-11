<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Exceptions;

use Modules\Common\Exceptions\DomainError;

final class ParticipantsLimitExceeded extends DomainError
{
    public function __construct(int $count)
    {
        parent::__construct("participants_count must be between 1 and 10, got {$count}");
    }
}
