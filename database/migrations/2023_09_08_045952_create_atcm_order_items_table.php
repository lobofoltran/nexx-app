<?php

use App\Enums\OrderItemsStatus;
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
        Schema::create('atcm_order_items', function (Blueprint $table) {
            $table->id();
            $table->string('value', 10);
            $table->string('observations', 512)->nullable();
            $table->enum('status', OrderItemsStatus::options());
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_order_id')->constrained();
            $table->foreignId('atcm_product_id')->nullable()->constrained();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
