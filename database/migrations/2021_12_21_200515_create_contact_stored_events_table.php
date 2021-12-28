<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('contact_stored_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('aggregate_uuid')->nullable()->unique();
            $table->unsignedBigInteger('aggregate_version')->nullable()->unique();
            $table->integer('event_version')->default(1);
            $table->string('event_class');
            $table->json('event_properties');
            $table->json('meta_data');
            $table->timestamp('created_at');
            $table->index('event_class');
            $table->index('aggregate_uuid');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_stored_events');
    }
};
