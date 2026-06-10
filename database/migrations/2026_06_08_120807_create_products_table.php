<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
             // Category Relations
$table->foreignId('category_id')
      ->constrained('categories')
      ->cascadeOnDelete();

$table->foreignId('subcategory_id')
      ->constrained('sub_categories')
      ->cascadeOnDelete();

            // Basic Information
            $table->string('name', 150);
            $table->string('sku')->unique();
            $table->string('short_description', 250)->nullable();
            $table->longText('description')->nullable();

            // Attributes
            $table->string('fabric')->nullable();
            $table->string('season')->nullable();

            // Tags
            $table->text('tags')->nullable();

            // Pricing
            $table->decimal('mrp', 10, 2);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('selling_price', 10, 2);

            // Inventory
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(10);

            // Variants
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();

            // Images
            $table->string('main_image');
            
            // Status
            $table->enum('status', [
                'active',
                'draft',
                'inactive'
            ])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
