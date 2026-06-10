<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the fitting_orders table.
     * Fitting orders are custom-stitched garments with measurements.
     */
    public function up(): void
    {
        Schema::create('fitting_orders', function (Blueprint $table) {

            $table->id();

            // Unique order code (e.g. FIT1001)
            $table->string('order_id', 30)->unique();

            // Link to customers table
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->restrictOnDelete();

            // Denormalized customer info (for quick display & history)
            $table->string('customer_name', 100);
            $table->string('mobile', 15);

            // Product / garment details
            $table->string('product_name', 150);
            $table->string('style', 100)->nullable();          // e.g. Narrow, Regular Fit, Comfort
            $table->text('product_description')->nullable();
            $table->string('fabric', 100)->nullable();         // e.g. Cotton, Denim, Silk
            $table->string('color', 80)->nullable();

            // Pricing
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('balance_amount', 10, 2)
                  ->virtualAs('total_amount - advance_paid'); // computed column

            // Important dates
            $table->date('delivery_date');
            $table->date('trial_date')->nullable();            // Fitting trial appointment

            // Order lifecycle status
            $table->enum('status', [
                'pending',
                'cutting',
                'stitching',
                'trial',
                'processing',
                'completed',
                'delivered',
                'cancelled',
            ])->default('pending');

            // Internal notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('customer_id');
            $table->index('status');
            $table->index('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitting_orders');
    }
};