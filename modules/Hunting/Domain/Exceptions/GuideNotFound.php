<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Exceptions;

use Modules\Common\Exceptions\DomainError;

final class GuideNotFound extends DomainError
{
    public function __construct()
    {
        parent::__construct('Guide not found');
    }
}
