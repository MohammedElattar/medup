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
        Schema::create('collaborates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('price')->nullable();
            $table->string('orcid_number')->nullable();
            $table->boolean('status')->default(false);
            $table->longText('description');
            $table->foreignId('expert_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speciality_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
