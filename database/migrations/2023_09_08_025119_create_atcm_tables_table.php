<?php

use App\Enums\TableStatus;
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
        Schema::create('atcm_tables', function (Blueprint $table) {
            $table->id();
            $table->string('identity', 256)->nullable();
            $table->enum('status', TableStatus::options());
            $table->integer('cards_quantity')->default(0);
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
        Schema::dropIfExists('tables');
    }
};
