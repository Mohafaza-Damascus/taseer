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
        Schema::create('project_pricing_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            $table->foreignId('pricing_item_id')
                ->constrained('pricing_items')
                ->restrictOnDelete();

            $table->decimal('quantity', 15, 3)->default(0);

            $table->decimal('unit_price_syp', 20, 2)->default(0);

            $table->decimal('unit_price_usd', 20, 2)->default(0);

            $table->json('specifications')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_pricing_items');
    }
};
