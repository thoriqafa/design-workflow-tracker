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
        Schema::dropIfExists('tx_permissions');
        Schema::dropIfExists('tx_roles');
        Schema::dropIfExists('tx_model_has_permissions');
        Schema::dropIfExists('tx_model_has_roles');
        Schema::dropIfExists('tx_role_has_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
