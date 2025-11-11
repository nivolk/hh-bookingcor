<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Exceptions;

use Modules\Common\Exceptions\DomainError;

final class GuideAlreadyBooked extends DomainError
{
    public function __construct()
    {
        parent::__construct('Guide already has a booking on this date');
    }
}
