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
    Schema::table('kertas_planos', function (Blueprint $table) {
        $table->enum('jenis_kertas', ['coated', 'uncoated'])->default('coated')->after('lebar');
    });
}

public function down()
{
    Schema::table('kertas_planos', function (Blueprint $table) {
        $table->dropColumn('jenis_kertas');
    });
}
};
