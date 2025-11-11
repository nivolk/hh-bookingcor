<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\OpenApi;

/**
 * @OA\Schema(
 *   schema="Guide",
 *   type="object",
 *   required={"id","name","experience_years"},
 *   @OA\Property(property="id", type="integer", format="int64", example=1),
 *   @OA\Property(property="name", type="string", example="Иван Иванов"),
 *   @OA\Property(property="experience_years", type="integer", minimum=0, example=5)
 * )
 *
 * @OA\Schema(
 *   schema="Booking",
 *   type="object",
 *   required={"id","tour_name","hunter_name","guide_id","date","participants_count"},
 *   @OA\Property(property="id", type="integer", format="int64", example=10),
 *   @OA\Property(property="tour_name", type="string", example="Охота на комаров"),
 *   @OA\Property(property="hunter_name", type="string", example="Олег"),
 *   @OA\Property(property="guide_id", type="integer", format="int64", example=1),
 *   @OA\Property(property="date", type="string", format="date", example="2025-01-10"),
 *   @OA\Property(property="participants_count", type="integer", minimum=1, maximum=10, example=3)
 * )
 *
 * @OA\Schema(
 *   schema="CreateBookingRequest",
 *   type="object",
 *   required={"tour_name","hunter_name","guide_id","date","participants_count"},
 *   @OA\Property(property="tour_name", type="string", example="Охота на комаров"),
 *   @OA\Property(property="hunter_name", type="string", example="Олег"),
 *   @OA\Property(property="guide_id", type="integer", format="int64", example=1),
 *   @OA\Property(property="date", type="string", format="date", example="2025-01-10"),
 *   @OA\Property(property="participants_count", type="integer", minimum=1, maximum=10, example=3)
 * )
 *
 * @OA\Schema(
 *    schema="GuidesResponse",
 *    type="object",
 *    required={"data"},
 *    @OA\Property(
 *      property="data",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/Guide")
 *    ),
 *    example={
 *      "data": {
 *        {"id": 6, "name": "Василий Васильев", "experience_years": 4},
 *        {"id": 1, "name": "Иван Иванов", "experience_years": 5}
 *      }
 *    }
 *  )
 *
 * @OA\Schema(
 *    schema="BookingResponse",
 *    type="object",
 *    required={"data"},
 *    @OA\Property(property="data", ref="#/components/schemas/Booking"),
 *    example={
 *      "data": {
 *        "id": 10, "tour_name": "Охота на санту", "hunter_name": "Губка боб",
 *        "guide_id": 1, "date": "2025-12-31", "participants_count": 3
 *      }
 *    }
 *  )
 *
 * @OA\Schema(
 *   schema="ValidationError",
 *   type="object",
 *   required={"message","errors"},
 *   @OA\Property(property="message", type="string", example="The given data was invalid."),
 *   @OA\Property(
 *     property="errors",
 *     type="object",
 *     additionalProperties=@OA\Schema(type="array", @OA\Items(type="string")),
 *     example={"date":{"The date field must be a valid date."}}
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="SimpleError",
 *   type="object",
 *   required={"message"},
 *   @OA\Property(property="message", type="string", example="Guide already has a booking on this date")
 * )
 */
final class Schemas
{
}
