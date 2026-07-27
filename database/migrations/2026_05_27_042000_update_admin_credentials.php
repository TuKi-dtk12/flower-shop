<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Update admin account credentials.
     * Handles case where email already exists on another user.
     */
    public function up(): void
    {
        $newEmail = '';
        $newPassword = Hash::make('');

        // Find the admin user
        $admin = DB::table('users')->where('is_admin', 1)->first();

        if ($admin) {
            // Remove any non-admin user that already has this email
            DB::table('users')
                ->where('email', $newEmail)
                ->where('id', '!=', $admin->id)
                ->delete();

            // Update admin credentials
            DB::table('users')->where('id', $admin->id)->update([
                'email'      => $newEmail,
                'password'   => $newPassword,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // No reversal needed
    }
};
