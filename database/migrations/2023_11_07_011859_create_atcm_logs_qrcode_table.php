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
        Schema::create('atcm_logs_qrcode', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->unsignedBigInteger('id_model')->nullable();
            $table->ipAddress();
            $table->timestamps();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_logs_qrcode');
    }
};
