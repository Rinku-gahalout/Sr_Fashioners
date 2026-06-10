<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the customers table for SR Fashioners.
     * Supports both Fitting and Bulk customer types.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            // Linked user account (optional — customer may not have a login)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Unique customer code (e.g. CUST001)
            $table->string('customer_id', 20)->unique();

            // Basic info
            $table->string('name', 100);
            $table->string('company_name', 150)->nullable();   // For bulk/corporate customers
            $table->string('mobile', 15);
            $table->string('email', 100)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('state', 80)->nullable();

            // Customer classification
            $table->enum('type', ['fitting', 'bulk'])->default('fitting');

            // Account status
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');

            // Notes / remarks
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for common lookups
            $table->index('mobile');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};