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
        Schema::create('mesin_finishings', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // nama/jenis mesin
            $table->integer('kecepatan'); // lembar per jam
            $table->decimal('daya_listrik'); // dalam watt
            $table->decimal('upah_operator_per_jam', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesin_finishings');
    }
};
