<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTintaTable extends Migration
{
    public function up()
    {
        Schema::create('tintas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['warna proses', 'warna khusus']);
            $table->decimal('bobot_coated', 2, 1);
            $table->decimal('bobot_uncoated', 2, 1);
            $table->decimal('harga', 12, 2); // per kg
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tinta');
    }
}