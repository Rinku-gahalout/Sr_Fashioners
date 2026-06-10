<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the bulk_orders table.
     * Bulk orders are wholesale / corporate / large-quantity garment orders.
     */
    public function up(): void
    {
        Schema::create('bulk_orders', function (Blueprint $table) {

            $table->id();

            // Unique order code (e.g. BLK2001)
            $table->string('order_id', 30)->unique();

            // Link to customers table
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->restrictOnDelete();

            // Denormalized customer info (for quick display & history)
            $table->string('customer_name', 100);
            $table->string('company_name', 150)->nullable();   // e.g. Kumar Textiles Pvt Ltd
            $table->string('mobile', 15);

            // Product details
            $table->string('product_name', 150);               // e.g. Plain Kurta, School Uniform Set
            $table->text('product_description')->nullable();
            $table->string('fabric', 100)->nullable();
            $table->string('color', 80)->nullable();
            $table->text('size_breakdown')->nullable();        // JSON string for size-wise split
                                                               // e.g. {"S":100,"M":200,"L":150,"XL":50}

            // Quantity & Pricing
            $table->unsignedInteger('quantity');               // Total number of pieces
            $table->decimal('unit_price', 10, 2);             // Price per piece
            $table->decimal('total_amount', 10, 2)
                  ->storedAs('quantity * unit_price');         // Auto-computed
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);

            // Delivery
            $table->date('delivery_date');
            $table->string('delivery_address', 255)->nullable();

            // Order lifecycle status
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'quality_check',
                'dispatched',
                'completed',
                'cancelled',
            ])->default('pending');

            // GST / Invoice
            $table->string('invoice_number', 50)->nullable();
            $table->decimal('gst_percent', 4, 2)->default(0.00);

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
        Schema::dropIfExists('bulk_orders');
    }
};