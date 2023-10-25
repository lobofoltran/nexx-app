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
        Schema::create('atcm_product_queues', function (Blueprint $table) {
            $table->id();
            $table->boolean('done')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_product_id')->constrained();
            $table->foreignId('atcm_card_id')->constrained();
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
