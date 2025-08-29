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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to')->comment('Recipient phone number');
            $table->text('message')->comment('SMS message content');
            $table->string('provider')->comment('Gateway/provider used');
            $table->string('status')->comment('sent, failed');
            $table->json('response')->nullable()->comment('Raw response from gateway');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
