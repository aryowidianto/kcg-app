<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHppTrialPrecisionInFinishingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('finishings', function (Blueprint $table) {
            $table->decimal('hpp_trial', 12, 3)->change();
        });
    }

    public function down(): void
    {
        Schema::table('finishings', function (Blueprint $table) {
            $table->decimal('hpp_trial', 12, 2)->change(); // revert kalau di-rollback
        });
    }
}
