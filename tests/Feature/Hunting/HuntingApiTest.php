<?php

declare(strict_types=1);

namespace Tests\Feature\Hunting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Hunting\Domain\Entities\Guide;
use Modules\Hunting\Domain\Entities\HuntingBooking;
use Tests\TestCase;

final class HuntingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guides_endpoint_returns_only_active_guides(): void
    {
        Guide::query()->create([
            'name' => 'Активный 1',
            'experience_years' => 3,
            'is_active' => true,
        ]);

        Guide::query()->create([
            'name' => 'Активный 2',
            'experience_years' => 5,
            'is_active' => true,
        ]);

        Guide::query()->create([
            'name' => 'Неактивный',
            'experience_years' => 10,
            'is_active' => false,
        ]);

        $response = $this->getJson('/api/guides');

        $response
            ->assertOk()
            ->assertJsonMissing(['name' => 'Неактивный'])
            ->assertJsonFragment(['name' => 'Активный 1'])
            ->assertJsonFragment(['name' => 'Активный 2']);
    }

    public function test_guides_endpoint_respects_min_experience_filter(): void
    {
        Guide::query()->create([
            'name' => 'Гид 1 год',
            'experience_years' => 1,
            'is_active' => true,
        ]);

        Guide::query()->create([
            'name' => 'Гид 3 года',
            'experience_years' => 3,
            'is_active' => true,
        ]);

        Guide::query()->create([
            'name' => 'Гид 5 лет',
            'experience_years' => 5,
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/guides?min_experience=3');

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => 'Гид 3 года'])
            ->assertJsonFragment(['name' => 'Гид 5 лет'])
            ->assertJsonMissing(['name' => 'Гид 1 год']);
    }

    public function test_can_create_booking(): void
    {
        $guide = Guide::query()->create([
            'name' => 'Губка Боб',
            'experience_years' => 5,
            'is_active' => true,
        ]);

        $payload = [
            'tour_name' => 'Охота на Санту',
            'hunter_name' => 'Губка Боб',
            'guide_id' => $guide->id,
            'date' => '2025-11-12',
            'participants_count' => 4,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'tour_name' => 'Охота на Санту',
                'hunter_name' => 'Губка Боб',
                'guide_id' => $guide->id,
                'date' => '2025-11-12',
                'participants_count' => 4,
            ]);

        $this->assertDatabaseHas('hunting_bookings', [
            'tour_name' => 'Охота на Санту',
            'hunter_name' => 'Губка Боб',
            'guide_id' => $guide->id,
            'date' => '2025-11-12 00:00:00', // указал тут время потому что sqlite хранит дату как YYYY-MM-DD 00:00:00
            'participants_count' => 4,
        ]);
    }

    public function test_cannot_create_booking_with_invalid_participants_count(): void
    {
        $guide = Guide::query()->create([
            'name' => 'Сквидвард',
            'experience_years' => 3,
            'is_active' => true,
        ]);

        $payload = [
            'tour_name' => 'Охота крепкое',
            'hunter_name' => 'Выживший',
            'guide_id' => $guide->id,
            'date' => '2026-01-01',
            'participants_count' => 11,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('participants_count');

        $this->assertDatabaseMissing('hunting_bookings', [
            'tour_name' => 'Охота крепкое',
            'hunter_name' => 'Выживший',
        ]);
    }

    public function test_cannot_create_booking_for_inactive_guide(): void
    {
        $guide = Guide::query()->create([
            'name' => 'Неактивный гид',
            'experience_years' => 10,
            'is_active' => false,
        ]);

        $payload = [
            'tour_name' => 'Охота на мух',
            'hunter_name' => 'Борис бритва',
            'guide_id' => $guide->id,
            'date' => '2025-11-12',
            'participants_count' => 3,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Guide is inactive',
            ]);

        $this->assertDatabaseMissing('hunting_bookings', [
            'tour_name' => 'Охота на мух',
            'guide_id' => $guide->id,
        ]);
    }

    public function test_cannot_create_booking_if_guide_already_booked_for_that_date(): void
    {
        $guide = Guide::query()->create([
            'name' => 'Гид нарасхват',
            'experience_years' => 7,
            'is_active' => true,
        ]);

        HuntingBooking::query()->create([
            'tour_name' => 'Охота нормальная',
            'hunter_name' => 'Апостол Андрей',
            'guide_id' => $guide->id,
            'date' => '2025-12-12',
            'participants_count' => 4,
        ]);

        $payload = [
            'tour_name' => 'Охота ненормальная',
            'hunter_name' => 'Суицидальный Сергей',
            'guide_id' => $guide->id,
            'date' => '2025-12-12',
            'participants_count' => 2,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response
            ->assertStatus(409)
            ->assertJsonFragment([
                'message' => 'Guide already has a booking on this date',
            ]);

        $this->assertDatabaseMissing('hunting_bookings', [
            'tour_name' => 'Охота ненормальная',
            'hunter_name' => 'Суицидальный Сергей',
            'guide_id' => $guide->id,
            'date' => '2025-12-12',
        ]);
    }
}
