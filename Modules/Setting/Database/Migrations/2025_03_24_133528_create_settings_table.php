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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_from');
            $table->string('mail_username');
            $table->string('mail_password');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_encryption');
            $table->string('mail_protocol');
            $table->string('stripe_secret_key');
            $table->unsignedBigInteger('subscription_price')->default(200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
