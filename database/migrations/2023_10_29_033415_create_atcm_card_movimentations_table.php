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
        Schema::create('atcm_card_movimentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('atcm_card_id')->constrained();
            $table->string('model_type', 255);
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('action', 255);
            $table->text('details')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_card_movimentations');
    }
};
