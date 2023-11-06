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
        Schema::create('atcm_product_entity_movimentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('atcm_product_entity_id');
            $table->string('model_type', 255);
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('action', 255);
            $table->text('details')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('owner_id')->nullable();

            $table->foreign('atcm_product_entity_id', 'fk_atcm_product_entities_id')->references('id')->on('atcm_product_entities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_product_entity_movimentations');
    }
};
