<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Hunting\Application\DTO\GuidesFilterDTO;
use Modules\Hunting\Domain\Repositories\GuideRepositoryInterface;
use Modules\Hunting\Infrastructure\Http\Requests\ListGuidesRequest;
use Modules\Hunting\Infrastructure\Http\Resources\GuideResource;

final class GuidesIndexController extends Controller
{
    public function __construct(
        private readonly GuideRepositoryInterface $guides
    ) {
    }

    public function __invoke(ListGuidesRequest $request): AnonymousResourceCollection
    {
        $filter = GuidesFilterDTO::fromArray($request->validated());
        $list = $this->guides->listActive($filter->minExperience);

        return GuideResource::collection($list);
    }
}
