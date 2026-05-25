<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_id', 20)->comment('VietQR BIN code, e.g. 970436');
            $table->string('bank_name', 100)->comment('Display name, e.g. Vietcombank');
            $table->string('account_number', 50);
            $table->string('account_name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
