<?php

use App\Enums\CardStatus;
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
        Schema::create('atcm_cards', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('identity', 256)->nullable();
            $table->enum('status', CardStatus::options());
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atcm_table_id')->nullable()->constrained();
            $table->foreignId('atcm_card_physical_id')->nullable()->constrained();
            $table->unsignedBigInteger('owner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
