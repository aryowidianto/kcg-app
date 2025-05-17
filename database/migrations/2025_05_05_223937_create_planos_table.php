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
        Schema::create('kertas_planos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('panjang'); // dalam mm
            $table->integer('lebar');   // dalam mm
            $table->integer('gramasi'); // dalam gsm
            $table->decimal('harga_per_lembar', 12, 2); // dalam Rupiah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kertas_planos');
    }
};
