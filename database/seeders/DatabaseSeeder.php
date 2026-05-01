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
        $faker = fake('vi_VN');

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
                [
                    'name' => 'Bó Hoa Nắng Sớm',
                    'description' => 'Món quà rực rỡ với sắc hướng dương và cẩm chướng, thay lời chúc tuổi mới đầy năng lượng.',
                ],
                [
                    'name' => 'Giỏ Hoa Tuổi Mới An Vui',
                    'description' => 'Giỏ hoa phối sắc hồng phấn, cam đào và trắng kem, mang đến cảm giác tươi vui và ấm áp cho ngày sinh nhật.',
                ],
                [
                    'name' => 'Hộp Hoa Niềm Vui Rạng Rỡ',
                    'description' => 'Thiết kế tinh gọn nhưng nổi bật, kết hợp hoa hồng pastel và hoa nhỏ điểm sáng, phù hợp cho những lời chúc ngọt lành.',
                ],
                [
                    'name' => 'Bó Tulip Mùa Xuân',
                    'description' => 'Sắc tulip nhẹ nhàng hòa cùng lá phụ mềm mại, tạo nên món quà thanh lịch và đầy sức sống.',
                ],
            ],
            'Hoa Khai Trương' => [
                [
                    'name' => 'Kệ Hoa Khai Trương Hồng Phát',
                    'description' => 'Bố cục sang trọng với sắc đỏ - vàng chủ đạo, tượng trưng cho sự thịnh vượng, may mắn và khởi đầu hanh thông.',
                ],
                [
                    'name' => 'Lẵng Hoa Phúc Lộc Viên Mãn',
                    'description' => 'Lẵng hoa cao cấp kết hợp lan hồ điệp, hồng môn và đồng tiền, gửi gắm lời chúc phát đạt dài lâu.',
                ],
                [
                    'name' => 'Bó Hoa Khởi Sự Thành Công',
                    'description' => 'Thiết kế hiện đại với tone vàng rực và xanh sage, phù hợp tặng đối tác, cửa hàng và sự kiện ra mắt.',
                ],
                [
                    'name' => 'Lẵng Hoa Cát Tường Hưng Thịnh',
                    'description' => 'Sự kết hợp nổi bật giữa hoa lan và hoa mặt trời, giúp không gian khai trương thêm trang trọng và ấn tượng.',
                ],
            ],
            'Hoa Cưới' => [
                [
                    'name' => 'Bó Hoa Tình Yêu Vĩnh Cửu',
                    'description' => 'Sự kết hợp tinh tế giữa hoa hồng trắng và lá bạc, mang lại vẻ đẹp thuần khiết cho ngày trọng đại.',
                ],
                [
                    'name' => 'Hoa Cầm Tay Nàng Dâu',
                    'description' => 'Tông trắng - hồng nhẹ nhàng cùng dáng bó mềm mại, tạo nên điểm nhấn thanh thoát cho cô dâu trong lễ cưới.',
                ],
                [
                    'name' => 'Bó Cưới Tình Xuân Dịu Ngọt',
                    'description' => 'Hoa peony, baby và tulip được phối hài hòa, mang đến vẻ đẹp lãng mạn và tinh tế cho khoảnh khắc trao lời thề.',
                ],
                [
                    'name' => 'Bó Hoa Hạnh Phúc Thuần Khiết',
                    'description' => 'Một thiết kế tối giản nhưng trang nhã, tôn lên nét thanh lịch và cảm xúc dịu dàng của ngày thành hôn.',
                ],
            ],
            'Hoa Chia Buồn' => [
                [
                    'name' => 'Kệ Hoa Tiễn Biệt An Lành',
                    'description' => 'Gam trắng thanh tịnh kết hợp cùng lá xanh trang nhã, thể hiện sự kính trọng và lời chia sẻ chân thành.',
                ],
                [
                    'name' => 'Vòng Hoa Tưởng Niệm',
                    'description' => 'Thiết kế trang nghiêm với hoa trắng và sắc xanh dịu, phù hợp cho không gian tưởng nhớ và tri ân.',
                ],
                [
                    'name' => 'Lẵng Hoa Vĩnh Biệt',
                    'description' => 'Bố cục cân đối, tinh giản và trang trọng, gửi gắm sự sẻ chia sâu sắc đến gia quyến.',
                ],
                [
                    'name' => 'Kệ Hoa Kính Viếng Thanh Nhã',
                    'description' => 'Sự kết hợp của hoa lan trắng, cúc trắng và lá phụ xanh, thể hiện tấm lòng thành kính và an yên.',
                ],
            ],
        ];

        $imageIndex = 1;

        foreach ($categoriesWithProducts as $categoryName => $productsData) {
            $category = Category::create([
                'name' => $categoryName,
            ]);

            foreach ($productsData as $productData) {
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'price' => $faker->randomElement([
                        350000.00,
                        450000.00,
                        500000.00,
                        650000.00,
                        850000.00,
                        1200000.00,
                    ]),
                    'description' => $productData['description'] . ' ' . $faker->sentence(10),
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
