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
        Schema::create('expert_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('hospital_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger('work_type');
            $table->longText('content');
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('expert_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_experiences');
    }
};
