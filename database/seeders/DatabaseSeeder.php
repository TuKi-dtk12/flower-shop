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

        User::create([
            'name' => 'Đinh Tuấn Kiệt (Admin)',
            'email' => 'tukiadmin@freshflower.com',
            'password' => Hash::make('Kietadmin@1212'),
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

        $categoriesConfig = [
            1 => [
                'name' => 'Hoa sinh nhật',
                'items' => [
                    ['name' => 'Hộp Hoa Nắng Mai Rạng Rỡ', 'desc' => 'Sắc vàng hướng dương kết hợp hồng phấn dịu dàng, tạo cảm giác ấm áp và tràn đầy niềm vui ngày mới.'],
                    ['name' => 'Bó Hoa Tuổi Xuân Ngọt Ngào', 'desc' => 'Hoa hồng kem và cẩm chướng hồng phối cùng lá bạc, gửi gắm lời chúc tuổi mới dịu ngọt.'],
                    ['name' => 'Giỏ Hoa Bình An Rực Sáng', 'desc' => 'Hướng dương, đồng tiền và lá phụ xanh tươi tạo nên món quà sinh nhật đầy năng lượng.'],
                    ['name' => 'Bó Hoa Dịu Êm Ban Mai', 'desc' => 'Tone pastel nhẹ nhàng từ hồng phấn và baby, phù hợp cho người yêu sự tinh tế.'],
                    ['name' => 'Hộp Hoa Thanh Xuân Rạng Rỡ', 'desc' => 'Sự kết hợp hồng Ecuador và cẩm tú cầu, tượng trưng cho tuổi trẻ tươi sáng.'],
                    ['name' => 'Giỏ Hoa Nụ Cười An Vui', 'desc' => 'Thiết kế tươi sáng với hồng cam, lan vàng và lá phụ, mang lại cảm giác vui tươi.'],
                    ['name' => 'Bó Hoa Ngày Mới Tỏa Nắng', 'desc' => 'Hướng dương chủ đạo điểm xuyết hoa baby, gửi lời chúc tích cực và lạc quan.'],
                    ['name' => 'Hộp Hoa Ngọt Ngào Bất Tận', 'desc' => 'Hồng pastel, cát tường và lá bạc hòa quyện, tạo nên vẻ đẹp mềm mại, tinh tế.'],
                    ['name' => 'Giỏ Hoa Rạng Rỡ Tuổi Mới', 'desc' => 'Tông hồng - vàng nổi bật, thay lời chúc tuổi mới rực rỡ và trọn vẹn.'],
                    ['name' => 'Bó Hoa Lời Chúc Yêu Thương', 'desc' => 'Hồng sen và cẩm chướng kết hợp tạo sự ấm áp, ngọt ngào cho ngày sinh nhật.'],
                    ['name' => 'Hộp Hoa Dịu Dàng Ngày Vui', 'desc' => 'Thiết kế mềm mại với hồng kem và lan hồ điệp mini, tinh tế và sang trọng.'],
                    ['name' => 'Bó Hoa Hạnh Phúc An Nhiên', 'desc' => 'Hoa hồng trắng, cẩm tú cầu xanh nhạt và lá phụ tạo cảm giác bình yên.'],
                    ['name' => 'Giỏ Hoa Ánh Nắng Dịu Êm', 'desc' => 'Hướng dương và tulip vàng phối cùng lá xanh, mang năng lượng tích cực.'],
                    ['name' => 'Bó Hoa Tươi Vui Rạng Rỡ', 'desc' => 'Hồng đỏ, cúc tana và baby trắng, phù hợp cho lời chúc rực rỡ.'],
                    ['name' => 'Hộp Hoa Khúc Ca Ngày Sinh', 'desc' => 'Hồng phấn, lan trắng và lá bạc tạo nên bản hòa âm dịu dàng.'],
                    ['name' => 'Giỏ Hoa Sắc Màu Yêu Thương', 'desc' => 'Kết hợp hồng, cẩm chướng và đồng tiền, đem lại cảm giác tươi vui.'],
                    ['name' => 'Bó Hoa Hương Thơm Ngày Mới', 'desc' => 'Hoa ly trắng điểm hồng phấn tạo mùi hương dịu nhẹ, thanh lịch.'],
                    ['name' => 'Hộp Hoa Niềm Vui Trọn Vẹn', 'desc' => 'Hồng đào, cẩm tú cầu và lá phụ mềm mại, gửi lời chúc trọn vẹn.'],
                    ['name' => 'Bó Hoa Rạng Ngời Tuổi Mơ', 'desc' => 'Tulip hồng và baby trắng tạo vẻ đẹp trẻ trung, lãng mạn.'],
                    ['name' => 'Giỏ Hoa Lời Chúc Bình An', 'desc' => 'Sắc kem - xanh nhạt thanh thoát, chúc tuổi mới an yên.'],
                ],
            ],
            2 => [
                'name' => 'Hoa khai trương',
                'items' => [
                    ['name' => 'Kệ Hoa Đại Cát Đại Lợi', 'desc' => 'Hướng dương, lan vàng và hồng môn đỏ tạo bố cục rực rỡ, chúc khai trương hanh thông.'],
                    ['name' => 'Lẵng Hoa Hồng Phát Thịnh Vượng', 'desc' => 'Lan hồ điệp, hồng môn và đồng tiền vàng kết hợp, gửi lời chúc phát tài.'],
                    ['name' => 'Kệ Hoa Khởi Đầu Viên Mãn', 'desc' => 'Tone đỏ - vàng chủ đạo, biểu trưng cho khởi đầu thuận lợi và may mắn.'],
                    ['name' => 'Giỏ Hoa Tấn Tài Tấn Lộc', 'desc' => 'Thiết kế nổi bật với hồng môn đỏ, hướng dương và lá xanh tươi.'],
                    ['name' => 'Lẵng Hoa Vạn Sự Thành Công', 'desc' => 'Lan vàng kết hợp đồng tiền cam, sắc màu tươi sáng cho lời chúc thành công.'],
                    ['name' => 'Kệ Hoa Phát Lộc Rạng Danh', 'desc' => 'Hoa ly vàng, lan hồ điệp và cẩm tú cầu tạo vẻ sang trọng, vượng khí.'],
                    ['name' => 'Giỏ Hoa Khai Mở Phú Quý', 'desc' => 'Sự phối hợp giữa hồng đỏ và hướng dương, tượng trưng thịnh vượng.'],
                    ['name' => 'Kệ Hoa Hưng Thịnh Vững Bền', 'desc' => 'Bố cục cao sang với lan hồ điệp và hồng môn, bền vững và rực rỡ.'],
                    ['name' => 'Lẵng Hoa Cát Tường Như Ý', 'desc' => 'Hồng môn, đồng tiền và lan trắng tạo nét trang trọng, chúc như ý.'],
                    ['name' => 'Giỏ Hoa Thịnh Vượng Khai Xuân', 'desc' => 'Hướng dương và hoa vàng chủ đạo, truyền cảm hứng khởi sắc.'],
                    ['name' => 'Kệ Hoa Đại Phát Vinh Hoa', 'desc' => 'Lan hồ điệp trắng phối đỏ, biểu trưng cho thăng hoa và bền vững.'],
                    ['name' => 'Lẵng Hoa Phúc Lộc Tròn Đầy', 'desc' => 'Sắc vàng - đỏ rực rỡ, mang thông điệp phúc lộc viên mãn.'],
                    ['name' => 'Kệ Hoa Vượng Khí Hanh Thông', 'desc' => 'Hồng môn đỏ và hướng dương, tiếp thêm năng lượng khai trương.'],
                    ['name' => 'Giỏ Hoa Khởi Sự Thành Tựu', 'desc' => 'Bố cục tươi sáng, nổi bật với lan vàng và cẩm tú cầu.'],
                    ['name' => 'Lẵng Hoa Tấn Lộc Thành Danh', 'desc' => 'Sự kết hợp rực rỡ giữa đỏ - vàng, chúc thành danh vững vàng.'],
                    ['name' => 'Kệ Hoa Vinh Phát Cát Tường', 'desc' => 'Hướng dương và lan hồ điệp tạo nét sang trọng, đầy vượng khí.'],
                    ['name' => 'Giỏ Hoa Phát Tài Phát Lộc', 'desc' => 'Tông đỏ - vàng tinh tế, lời chúc phát tài phát lộc bền lâu.'],
                    ['name' => 'Lẵng Hoa Khai Trương Hồng Phát', 'desc' => 'Thiết kế rực rỡ với hồng môn, đồng tiền và hướng dương.'],
                    ['name' => 'Kệ Hoa Đắc Lộc Hưng Thịnh', 'desc' => 'Lan vàng phối cúc đại đóa, biểu trưng cho hưng thịnh lâu dài.'],
                    ['name' => 'Giỏ Hoa Phồn Vinh Tỏa Sáng', 'desc' => 'Sắc cam - vàng rạng rỡ, mang thông điệp phồn vinh.'],
                ],
            ],
            3 => [
                'name' => 'Hoa cưới',
                'items' => [
                    ['name' => 'Bó Hoa Cầm Tay Ngày Chung Đôi', 'desc' => 'Hồng pastel và baby trắng kết hợp cùng ruy băng lụa, dịu dàng và trang nhã.'],
                    ['name' => 'Vũ Khúc Linh Lan', 'desc' => 'Linh lan trắng phối hồng phấn, tạo cảm giác tinh khôi và thanh lịch.'],
                    ['name' => 'Duyên Tình Sắc Son', 'desc' => 'Hồng đỏ nhung và lá bạc, biểu trưng cho tình yêu bền chặt.'],
                    ['name' => 'Bó Hoa Tình Yêu Thuần Khiết', 'desc' => 'Hồng trắng phối tulip kem, phong cách tối giản và sang trọng.'],
                    ['name' => 'Bó Hoa Nguyện Ước Trăm Năm', 'desc' => 'Hoa mẫu đơn và hồng phấn tạo vẻ ngọt ngào, lãng mạn.'],
                    ['name' => 'Lời Hẹn Dưới Mưa', 'desc' => 'Hồng pastel và cẩm tú cầu xanh nhạt, mang nét dịu dàng.'],
                    ['name' => 'Bó Hoa Ngày Cưới An Nhiên', 'desc' => 'Sự phối hợp giữa hồng kem và baby trắng, tạo cảm giác an yên.'],
                    ['name' => 'Hạnh Phúc Vĩnh Cửu', 'desc' => 'Hồng nhập khẩu và lan trắng tạo nên vẻ đẹp sang trọng cho cô dâu.'],
                    ['name' => 'Bó Hoa Duyên Dáng Tinh Khôi', 'desc' => 'Tulip trắng và lan hồ điệp mini, tinh khôi và thanh lịch.'],
                    ['name' => 'Bó Hoa Trọn Đời Bên Nhau', 'desc' => 'Hồng phấn, cát tường và lá bạc, biểu trưng cho gắn bó.'],
                    ['name' => 'Bó Hoa Hẹn Ước Ban Mai', 'desc' => 'Mẫu đơn trắng và hồng pastel, tạo cảm giác thuần khiết.'],
                    ['name' => 'Bó Hoa Nụ Cười Cô Dâu', 'desc' => 'Hồng kem phối baby trắng, nhẹ nhàng và tươi sáng.'],
                    ['name' => 'Bó Hoa Sắc Son Chung Thủy', 'desc' => 'Hồng đỏ nhung phối lá bạc, biểu trưng cho lời thề.'],
                    ['name' => 'Bó Hoa Mùa Yêu Duyên Dáng', 'desc' => 'Tulip hồng và baby trắng kết hợp, trẻ trung và tinh tế.'],
                    ['name' => 'Bó Hoa Khúc Ca Hạnh Phúc', 'desc' => 'Cẩm tú cầu xanh nhạt và hồng phấn, tạo cảm giác dịu dàng.'],
                    ['name' => 'Bó Hoa Thanh Âm Vĩnh Cửu', 'desc' => 'Hồng pastel phối lan trắng, sang trọng và mềm mại.'],
                    ['name' => 'Bó Hoa Lời Thề Lấp Lánh', 'desc' => 'Hồng trắng và baby trắng, nhấn bằng ruy băng lụa.'],
                    ['name' => 'Bó Hoa Duyên Tình Bất Tận', 'desc' => 'Hồng kem phối hoa baby và lá bạc, dịu dàng tinh tế.'],
                    ['name' => 'Bó Hoa Ánh Trăng Cưới', 'desc' => 'Tone trắng tinh khôi kết hợp hoa lan, thanh tao và hiện đại.'],
                    ['name' => 'Bó Hoa Giấc Mơ Lụa Trắng', 'desc' => 'Linh lan và hồng trắng tạo vẻ đẹp thuần khiết cho ngày cưới.'],
                ],
            ],
            4 => [
                'name' => 'Hoa chia buồn',
                'items' => [
                    ['name' => 'Kệ Hoa Cõi Vĩnh Hằng', 'desc' => 'Hoa cúc trắng và lan trắng phối lá phụ, trang nghiêm và thành kính.'],
                    ['name' => 'Vòng Hoa Nén Tâm Hương', 'desc' => 'Thiết kế vòng hoa trang trọng với cúc trắng và lan hồ điệp, bày tỏ kính viếng.'],
                    ['name' => 'Lẵng Hoa Giấc Ngủ Ngàn Thu', 'desc' => 'Sắc trắng dịu cùng cẩm tú cầu và ly, gửi lời tiễn biệt sâu lắng.'],
                    ['name' => 'Kệ Hoa Tiễn Biệt An Lành', 'desc' => 'Kết hợp cúc trắng và lan trắng, biểu trưng cho sự an yên vĩnh cửu.'],
                    ['name' => 'Vòng Hoa Tĩnh Lặng Bình An', 'desc' => 'Thiết kế đơn sắc thanh tịnh, lan trắng và lá phụ nhẹ nhàng.'],
                    ['name' => 'Lẵng Hoa Kính Viếng Trang Nghiêm', 'desc' => 'Cúc trắng phối lan hồ điệp tạo vẻ trang nghiêm và sâu lắng.'],
                    ['name' => 'Kệ Hoa Thành Kính Vô Ngôn', 'desc' => 'Hoa ly trắng và cúc trắng, bày tỏ sự kính trọng chân thành.'],
                    ['name' => 'Vòng Hoa Lời Tiễn Biệt', 'desc' => 'Hoa cúc trắng, hồng trắng và lá phụ, gửi lời tiễn biệt nhẹ nhàng.'],
                    ['name' => 'Lẵng Hoa Bình Yên Vĩnh Cửu', 'desc' => 'Sự phối hợp dịu dàng giữa lan trắng và cẩm tú cầu xanh nhạt.'],
                    ['name' => 'Kệ Hoa An Nhiên Tiễn Đưa', 'desc' => 'Cúc trắng, ly trắng và lá bạc tạo cảm giác an yên trang trọng.'],
                    ['name' => 'Vòng Hoa Kính Mộ', 'desc' => 'Vòng hoa trắng trang nghiêm với cúc và lan, thể hiện sự kính viếng.'],
                    ['name' => 'Lẵng Hoa Miền An Lạc', 'desc' => 'Hoa cúc trắng kết hợp lan trắng, gửi gắm lời cầu an.'],
                    ['name' => 'Kệ Hoa Trầm Tư', 'desc' => 'Sắc trắng chủ đạo kết hợp lá xanh, thể hiện nỗi niềm sâu lắng.'],
                    ['name' => 'Vòng Hoa Hư Vô', 'desc' => 'Cúc trắng và ly trắng, bố cục trang nghiêm, tĩnh tại.'],
                    ['name' => 'Lẵng Hoa Dòng Nhớ', 'desc' => 'Cẩm tú cầu trắng, lan trắng và lá phụ, gửi nỗi nhớ sâu sắc.'],
                    ['name' => 'Kệ Hoa Kính Tiễn', 'desc' => 'Hoa ly trắng và cúc trắng, tôn lên vẻ trang trọng.'],
                    ['name' => 'Vòng Hoa Lặng Yên', 'desc' => 'Thiết kế thanh tịnh với cúc trắng và lan trắng, nhẹ nhàng tiễn đưa.'],
                    ['name' => 'Lẵng Hoa Tiếc Thương', 'desc' => 'Cúc trắng phối hoa lan, thể hiện lòng thành kính sâu sắc.'],
                    ['name' => 'Kệ Hoa Tưởng Niệm', 'desc' => 'Hoa cúc trắng và lá phụ, trang nghiêm và trân trọng.'],
                    ['name' => 'Vòng Hoa An Nhiên', 'desc' => 'Sắc trắng tinh khôi kết hợp lan trắng, gửi lời an ủi chân thành.'],
                ],
            ],
            5 => [
                'name' => 'Hoa tốt nghiệp',
                'items' => [
                    ['name' => 'Bó Hoa Khát Vọng Cất Cánh', 'desc' => 'Hướng dương rực rỡ phối baby trắng, biểu trưng cho khát vọng vươn xa.'],
                    ['name' => 'Tương Lai Rực Rỡ', 'desc' => 'Hướng dương và giấy gói hiện đại, tôn vinh hành trình mới.'],
                    ['name' => 'Bước Đường Vinh Quang', 'desc' => 'Hướng dương phối cẩm tú cầu xanh, mang thông điệp tự tin và mạnh mẽ.'],
                    ['name' => 'Bó Hoa Vươn Xa', 'desc' => 'Sắc vàng chủ đạo cùng baby trắng, trẻ trung và tràn đầy năng lượng.'],
                    ['name' => 'Bó Hoa Khai Mở Tri Thức', 'desc' => 'Hướng dương và lá bạc tạo cảm giác hiện đại, tinh tế.'],
                    ['name' => 'Bó Hoa Rạng Ngời Ước Mơ', 'desc' => 'Sự kết hợp tươi sáng giữa hướng dương và tulip vàng, rực rỡ.'],
                    ['name' => 'Tặng Phẩm Thành Công', 'desc' => 'Hướng dương và baby trắng, gửi lời chúc thành công trọn vẹn.'],
                    ['name' => 'Bó Hoa Khởi Đầu Mới', 'desc' => 'Sắc vàng - trắng hài hòa, biểu trưng cho khởi đầu đầy hy vọng.'],
                    ['name' => 'Bó Hoa Vinh Danh', 'desc' => 'Hướng dương phối hoa cúc trắng, trang nhã và tự hào.'],
                    ['name' => 'Bó Hoa Tri Ân Thầy Cô', 'desc' => 'Hướng dương và hồng kem, thể hiện sự biết ơn sâu sắc.'],
                    ['name' => 'Bó Hoa Tuổi Trẻ Tỏa Sáng', 'desc' => 'Hướng dương kết hợp baby trắng, trẻ trung và giàu năng lượng.'],
                    ['name' => 'Bó Hoa Đường Bay Hy Vọng', 'desc' => 'Tone vàng rực rỡ, giấy gói hiện đại, đầy cảm hứng.'],
                    ['name' => 'Bó Hoa Vững Bước Tương Lai', 'desc' => 'Hướng dương phối lan trắng, thanh lịch và mạnh mẽ.'],
                    ['name' => 'Bó Hoa Khởi Sắc', 'desc' => 'Sắc vàng tươi phối lá xanh, tượng trưng cho sự bứt phá.'],
                    ['name' => 'Bó Hoa Vinh Quang Ngày Mới', 'desc' => 'Hướng dương và baby trắng, rực rỡ và trang nhã.'],
                    ['name' => 'Bó Hoa Chạm Tới Ước Mơ', 'desc' => 'Hướng dương và cẩm tú cầu nhạt, trẻ trung và tinh tế.'],
                    ['name' => 'Tặng Phẩm Thành Tựu', 'desc' => 'Hướng dương, lá bạc và giấy gói hiện đại, thể hiện thành tựu.'],
                    ['name' => 'Bó Hoa Vững Vàng', 'desc' => 'Hướng dương và baby trắng, biểu trưng cho sự kiên định.'],
                    ['name' => 'Bó Hoa Ánh Sáng Tương Lai', 'desc' => 'Sắc vàng rực và giấy gói hiện đại, tôn vinh tương lai tươi sáng.'],
                    ['name' => 'Bó Hoa Chúc Mừng Tốt Nghiệp', 'desc' => 'Hướng dương chủ đạo kết hợp baby trắng, chúc mừng hành trình mới.'],
                ],
            ],
        ];

        foreach ($categoriesConfig as $categoryId => $config) {
            $category = Category::query()->find($categoryId);

            if (!$category) {
                $category = Category::query()->create([
                    'name' => $config['name'],
                ]);
            } else {
                $category->update(['name' => $config['name']]);
            }

            foreach ($config['items'] as $index => $item) {
                $name = $item['name'];
                $price = random_int(6, 50) * 50000;
                $imagePath = "products/flower_cat_{$categoryId}_" . ($index + 1) . ".jpg";

                $productData = [
                    'category_id' => $category->id,
                    'name' => $name,
                    'price' => $price,
                    'description' => $item['desc'],
                    'image' => $imagePath,
                ];

                if (Schema::hasColumn('products', 'slug')) {
                    $productData['slug'] = Str::slug($name);
                }

                if (Schema::hasColumn('products', 'stock')) {
                    $productData['stock'] = random_int(5, 30);
                }

                Product::create($productData);
            }
        }
    }
}
