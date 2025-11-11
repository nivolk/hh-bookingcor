<?php

declare(strict_types=1);

namespace Modules\Hunting\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Guide extends Model
{
    protected $table = 'guides';

    protected $fillable = ['name', 'experience_years', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'experience_years' => 'integer',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(HuntingBooking::class, 'guide_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeMinExperience($q, int $min)
    {
        return $q->where('experience_years', '>=', $min);
    }
}
