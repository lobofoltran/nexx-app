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
        Schema::create('atcm_group_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atcm_card_id');
            $table->unsignedBigInteger('atcm_card_id_to');
            $table->timestamps();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_group_cards');
    }
};
