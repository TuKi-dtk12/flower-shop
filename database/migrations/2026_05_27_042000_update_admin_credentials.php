<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Update admin account credentials.
     */
    public function up(): void
    {
        // Update the admin user (is_admin = 1) or first user
        $admin = DB::table('users')->where('is_admin', 1)->first();

        if ($admin) {
            DB::table('users')->where('id', $admin->id)->update([
                'email'    => 'tukiadmin@freshflower.com',
                'password' => Hash::make('Kietadmin@1212'),
                'updated_at' => now(),
            ]);
        } else {
            // If no admin exists, create one
            DB::table('users')->insert([
                'name'              => 'Tuki Admin',
                'email'             => 'tukiadmin@freshflower.com',
                'password'          => Hash::make('Kietadmin@1212'),
                'is_admin'          => 1,
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed
    }
};
