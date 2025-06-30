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
        /*
service_type (practical, online, custom_programs)
description
sessions_per_week
durations (date from, date to)
*/
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_member')->constrained('users')->cascadeOnDelete();
            $table->foreignId('second_member')->constrained('users')->cascadeOnDelete();
            $table->string('service_type');
            $table->longText('description');
            $table->integer('sessions_per_week');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_online');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->unsignedBigInteger('price');
            $table->string('expert_name');
            $table->string('expert_email');
            $table->string('trainee_name');
            $table->string('trainee_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
