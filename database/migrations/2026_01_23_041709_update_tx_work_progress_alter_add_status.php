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
        Schema::table('tx_work_progress', function (Blueprint $table) {
            $table->integer('status_work')->after('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tx_work_progress', function (Blueprint $table) {
             if (Schema::hasColumn('tx_work_progress', 'status_work')) {
                $table->dropColumn('status_work');
            }
        });
    }
};
