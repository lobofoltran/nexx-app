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
        Schema::create('atcm_order_movimentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('atcm_order_id')->constrained();
            $table->string('model_type', 255);
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('action', 255);
            $table->text('details')->nullable();
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_order_movimentations');
    }
};
