<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the measurements table for fitting orders.
     * All measurement values are stored in centimeters (cm).
     */
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {

            $table->id();

            // One-to-one with fitting_orders
            $table->foreignId('fitting_order_id')
                  ->unique()
                  ->constrained('fitting_orders')
                  ->cascadeOnDelete();

            // ── Upper Body ─────────────────────────────────────────────
            $table->decimal('chest', 5, 1)->nullable();         // Chest / Bust (cm)
            $table->decimal('waist', 5, 1)->nullable();         // Waist (cm)
            $table->decimal('hips', 5, 1)->nullable();          // Hips / Seat (cm)
            $table->decimal('shoulder', 5, 1)->nullable();      // Shoulder width (cm)
            $table->decimal('neck', 5, 1)->nullable();          // Neck circumference (cm)

            // ── Shirt / Kurta ──────────────────────────────────────────
            $table->decimal('shirt_length', 5, 1)->nullable();  // Full shirt/kurta length (cm)
            $table->decimal('sleeve_length', 5, 1)->nullable(); // Sleeve length (cm)
            $table->decimal('sleeve_width', 5, 1)->nullable();  // Bicep / sleeve width (cm)
            $table->decimal('wrist', 5, 1)->nullable();         // Wrist circumference (cm)

            // ── Lower Body / Trousers ──────────────────────────────────
            $table->decimal('pant_length', 5, 1)->nullable();   // Full trouser length (cm)
            $table->decimal('inseam', 5, 1)->nullable();        // Inseam / inside leg (cm)
            $table->decimal('thigh', 5, 1)->nullable();         // Thigh circumference (cm)
            $table->decimal('knee', 5, 1)->nullable();          // Knee circumference (cm)
            $table->decimal('ankle', 5, 1)->nullable();         // Bottom opening / ankle (cm)
            $table->decimal('rise', 5, 1)->nullable();          // Crotch rise (cm)

            // ── Unit & Notes ───────────────────────────────────────────
            $table->enum('unit', ['cm', 'inch'])->default('cm');
            $table->text('notes')->nullable();                   // Tailor's special instructions

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};