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
        Schema::create('pricing_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('unit')->nullable();

            $table->foreignId('related_work_id')
                ->nullable()
                ->constrained('related_works')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_items');
    }
};
