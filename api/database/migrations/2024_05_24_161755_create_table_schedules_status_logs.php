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
        Schema::create('schedules_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('service_appointments');
            $table->string('description');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('notify_client')->default(false);
            $table->boolean('notify_admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules_status_logs');
    }
};
