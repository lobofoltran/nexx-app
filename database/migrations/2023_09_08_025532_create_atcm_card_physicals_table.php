<?php

use App\Enums\CardPhysicalStatus;
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
        Schema::create('atcm_card_physicals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('code', 10)->nullable();
            $table->enum('status', CardPhysicalStatus::options());
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atcm_card_physicals');
    }
};
