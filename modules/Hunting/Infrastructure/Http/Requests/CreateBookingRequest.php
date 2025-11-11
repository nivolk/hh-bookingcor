<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_name' => ['required', 'string', 'max:255'],
            'hunter_name' => ['required', 'string', 'max:255'],
            'guide_id' => ['required', 'integer', 'exists:guides,id'],
            'date' => ['required', 'date:Y-m-d'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
