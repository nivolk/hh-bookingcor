<?php

declare(strict_types=1);

namespace Modules\Hunting\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ListGuidesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'min_experience' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
