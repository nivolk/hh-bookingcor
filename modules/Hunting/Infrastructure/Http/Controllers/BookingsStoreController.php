<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Modules\Hunting\Application\DTO\CreateBookingDTO;
use Modules\Hunting\Application\Services\BookingService;
use Modules\Hunting\Domain\Exceptions\GuideAlreadyBooked;
use Modules\Hunting\Domain\Exceptions\GuideInactive;
use Modules\Hunting\Domain\Exceptions\GuideNotFound;
use Modules\Hunting\Domain\Exceptions\ParticipantsLimitExceeded;
use Modules\Hunting\Infrastructure\Http\Requests\CreateBookingRequest;
use Modules\Hunting\Infrastructure\Http\Resources\BookingResource;

final class BookingsStoreController extends Controller
{
    public function __construct(private readonly BookingService $service)
    {
    }

    /**
     * @OA\Post(
     *   path="/bookings",
     *   tags={"Bookings"},
     *   summary="Создать бронирование охотничьего тура",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/CreateBookingRequest")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(ref="#/components/schemas/BookingResponse")
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Гид не найден",
     *     @OA\JsonContent(ref="#/components/schemas/SimpleError")
     *   ),
     *   @OA\Response(
     *     response=409,
     *     description="Конфликт: у гида уже есть бронирование на эту дату",
     *     @OA\JsonContent(ref="#/components/schemas/SimpleError")
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Ошибка валидации или неверный формат входных данных / гид неактивен",
     *     @OA\JsonContent(
     *       oneOf={
     *         @OA\Schema(ref="#/components/schemas/ValidationError"),
     *         @OA\Schema(ref="#/components/schemas/SimpleError")
     *       }
     *     )
     *   )
     * )
     */
    public function __invoke(CreateBookingRequest $request): JsonResponse
    {
        try {
            $dto = CreateBookingDTO::fromArray($request->validated());
            $created = $this->service->create($dto);

            return (new BookingResource($created))
                ->response()
                ->setStatusCode(201);
        } catch (InvalidArgumentException|ParticipantsLimitExceeded|GuideInactive $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (GuideNotFound $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (GuideAlreadyBooked $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
