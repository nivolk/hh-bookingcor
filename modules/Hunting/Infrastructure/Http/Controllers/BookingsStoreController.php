<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Controllers;

use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Modules\Hunting\Application\DTO\CreateBookingDTO;
use Modules\Hunting\Application\Services\BookingService;
use Modules\Hunting\Infrastructure\Http\Requests\CreateBookingRequest;
use Modules\Hunting\Infrastructure\Http\Resources\BookingResource;

final class BookingsStoreController extends Controller
{
    public function __construct(private readonly BookingService $service)
    {
    }

    public function __invoke(CreateBookingRequest $request): JsonResponse
    {
        try {
            $dto = CreateBookingDTO::fromArray($request->validated());
            $created = $this->service->create($dto);

            return (new BookingResource($created))
                ->response()
                ->setStatusCode(201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
