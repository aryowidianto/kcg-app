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
        Schema::create('finishings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_finishing');
            $table->decimal('hpp_trial', 12, 2); // HPP berdasarkan trial
            $table->foreignId('mesin_finishing_id')->constrained('mesin_finishings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishings');
    }
};
