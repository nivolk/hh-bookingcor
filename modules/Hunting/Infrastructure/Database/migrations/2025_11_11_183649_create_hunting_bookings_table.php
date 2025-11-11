<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hunting_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('tour_name', 255);
            $table->string('hunter_name', 255);
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('participants_count');
            $table->timestamps();

            $table->unique(['guide_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunting_bookings');
    }
};
