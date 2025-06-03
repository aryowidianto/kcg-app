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
        Schema::table('mesin_offsets', function (Blueprint $table) {
            $table->integer('jumlah_operator')->default(1)->after('upah_operator_per_jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mesin_offsets', function (Blueprint $table) {
            $table->dropColumn('jumlah_operator');
        });
    }
};
