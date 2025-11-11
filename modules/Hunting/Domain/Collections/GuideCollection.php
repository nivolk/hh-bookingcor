<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Collections;

use Modules\Common\Abstractions\AbstractTypedCollection;
use Modules\Hunting\Domain\Entities\Guide;

/**
 * @extends AbstractTypedCollection<Guide>
 */
final class GuideCollection extends AbstractTypedCollection
{
    protected function type(): string
    {
        return Guide::class;
    }
}
