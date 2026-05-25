<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_name', 255)->nullable()->after('status');
            $table->string('shipping_phone', 20)->nullable()->after('shipping_name');
            $table->string('shipping_email', 255)->nullable()->after('shipping_phone');
            $table->text('shipping_address')->nullable()->after('shipping_email');
            $table->text('note')->nullable()->after('shipping_address');
            $table->string('payment_method', 30)->default('cod')->after('note');
            $table->string('payment_status', 30)->default('pending')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_phone',
                'shipping_email',
                'shipping_address',
                'note',
                'payment_method',
                'payment_status',
            ]);
        });
    }
};
