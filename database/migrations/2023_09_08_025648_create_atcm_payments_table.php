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
        Schema::create('atcm_payments', function (Blueprint $table) {
            $table->id();
            $table->string('value', 10);
            $table->string('transshipment', 10);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_card_id')->constrained();
            $table->foreignId('atcm_payment_method_id')->constrained();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
