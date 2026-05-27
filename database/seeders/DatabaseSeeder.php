<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = fake('vi_VN');
        User::updateOrCreate(
                    ['email' => 'tukiadmin@freshflower.com'],
                    [
                        'name' => 'Đinh Tuấn Kiệt (Admin)',
                        'password' => Hash::make('Kietadmin@1212'),
                        'is_admin' => true,
                    ]
                );  
    }
}
