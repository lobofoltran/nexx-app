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
        Schema::create('atcm_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
            $table->string('value', 10);
            $table->string('image_url', 256);
            $table->boolean('show_to_waiter')->default(false);
            $table->boolean('show_to_kitchen')->default(false);
            $table->boolean('show_to_cashier')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_products_categories_id')->constrained();
            $table->unsignedBigInteger('owner_id')->nullable();
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
