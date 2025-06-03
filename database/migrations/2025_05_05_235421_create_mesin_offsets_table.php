<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('mesin_offsets', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // nama/jenis mesin
        $table->integer('kecepatan'); // lembar per jam
        $table->integer('min_panjang');
        $table->integer('min_lebar');
        $table->integer('max_panjang');
        $table->integer('max_lebar');
        $table->decimal('harga_ctcp', 12, 2);
        $table->decimal('harga_plate', 12, 2);
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
        Schema::dropIfExists('mesin_offsets');
    }
};
