<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'User One',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        $categoriesWithProducts = [
            'Hoa Sinh Nhật' => [
                'Bó Hồng Ecuador',
                'Hộp Hoa Ngọt Ngào',
                'Giỏ Hoa Chúc Mừng',
                'Bó Tulip Tươi Sáng',
            ],
            'Hoa Khai Trương' => [
                'Lẵng Hoa Hướng Dương',
                'Kệ Hoa Phát Tài',
                'Lẵng Hoa Lan Vàng',
                'Kệ Hoa Hồng Môn Đỏ',
            ],
            'Hoa Cưới' => [
                'Bó Cưới Baby Trắng',
                'Bó Cưới Peony Hồng',
                'Hoa Cầm Tay Cô Dâu',
                'Bó Cưới Tulip Kem',
            ],
            'Hoa Chia Buồn' => [
                'Kệ Hoa Tưởng Niệm',
                'Vòng Hoa Trang Nghiêm',
                'Kệ Hoa Trắng Tiễn Biệt',
                'Lẵng Hoa Chia Buồn',
            ],
        ];

        $faker = fake('vi_VN');
        $imageIndex = 1;

        foreach ($categoriesWithProducts as $categoryName => $productNames) {
            $category = Category::create([
                'name' => $categoryName,
            ]);

            foreach ($productNames as $productName) {
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $productName,
                    'price' => fake()->randomElement([
                        350000.00,
                        450000.00,
                        500000.00,
                        650000.00,
                        850000.00,
                        1200000.00,
                    ]),
                    'description' => $faker->paragraph(),
                    'image' => 'products/flower' . $imageIndex . '.jpg',
                ]);

                $imageIndex++;

                for ($i = 0; $i < 2; $i++) {
                    Image::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/flower' . $imageIndex . '.jpg',
                    ]);

                    $imageIndex++;
                }
            }
        }
    }
}
