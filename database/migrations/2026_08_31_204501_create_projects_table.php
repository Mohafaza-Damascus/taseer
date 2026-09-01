<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('signing_location')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreignId('incoming_entity_id')
                ->nullable()
                ->constrained('incoming_entities')
                ->nullOnDelete();

            $table->foreignId('contractor_id')
                ->nullable()
                ->constrained('contractors')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
