<?php

use App\Enums\OrderItemQueueStatus;
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
        Schema::create('atcm_order_item_queues', function (Blueprint $table) {
            $table->id();
            $table->enum('status', OrderItemQueueStatus::options());
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_order_item_id')->constrained();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attraction_queues');
    }
};
