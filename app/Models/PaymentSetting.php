<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'bank_name',
        'account_number',
        'account_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the currently active payment setting.
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }

    /**
     * List of supported Vietnamese banks with VietQR BIN codes.
     */
    public static function bankList(): array
    {
        return [
            '970436' => 'Vietcombank (VCB)',
            '970418' => 'BIDV',
            '970415' => 'VietinBank',
            '970422' => 'MB Bank',
            '970416' => 'ACB',
            '970432' => 'VPBank',
            '970423' => 'TPBank',
            '970407' => 'Techcombank',
            '970448' => 'OCB',
            '970431' => 'Eximbank',
            '970426' => 'MSB (Maritime Bank)',
            '970403' => 'Sacombank',
            '970437' => 'HDBank',
            '970441' => 'VIB',
            '970443' => 'SHB',
            '970414' => 'Ví MoMo',
        ];
    }
}
