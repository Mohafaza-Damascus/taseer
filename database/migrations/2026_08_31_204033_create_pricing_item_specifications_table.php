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
        Schema::create('pricing_item_specifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pricing_item_id')
                ->constrained('pricing_items')
                ->cascadeOnDelete();

            $table->string('name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_item_specifications');
    }
};
