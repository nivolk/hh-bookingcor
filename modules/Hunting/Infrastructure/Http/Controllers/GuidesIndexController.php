<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Hunting\Domain\Repositories\GuideRepositoryInterface;
use Modules\Hunting\Infrastructure\Http\Requests\ListGuidesRequest;
use Modules\Hunting\Infrastructure\Http\Resources\GuideResource;

final class GuidesIndexController extends Controller
{
    public function __construct(
        private readonly GuideRepositoryInterface $guides
    ) {
    }

    /**
     * @OA\Get(
     *   path="/guides",
     *   tags={"Guides"},
     *   summary="Список активных гидов",
     *   @OA\Parameter(
     *     name="min_experience",
     *     in="query",
     *     description="Минимальный стаж (лет)",
     *     required=false,
     *     @OA\Schema(type="integer", minimum=0, example=3)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(ref="#/components/schemas/GuidesResponse")
     *   )
     * )
     */
    public function __invoke(ListGuidesRequest $request): AnonymousResourceCollection
    {
        $minExperience = $request->filled('min_experience')
            ? (int)$request->input('min_experience')
            : null;

        $list = $this->guides->listActive($minExperience);

        return GuideResource::collection($list->all());
    }
}
