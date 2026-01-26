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
        Schema::create('tx_work_progress', function (Blueprint $table) {
            $table->id();
            $table->string('supplier', 50)->nullable();
            $table->string('item', 50)->nullable();
            $table->string('no_approval', 100)->nullable();
            $table->dateTime('email_received_at')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->decimal('duration')->nullable();
            $table->string('computer_ip', 50)->nullable();
            $table->string('computer_name', 50)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tx_work_progress');
    }
};
