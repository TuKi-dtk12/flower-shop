🚀 ROADMAP PROJECT WEBSITE BÁN HOA (PHP – Laravel)
🧭 Giai đoạn 1: Phân tích & thiết kế 
1. Xác định chức năng chính
User:
•	Xem danh mục hoa (theo chủ đề: sinh nhật, khai trương,…)
•	Xem chi tiết sản phẩm
•	Thêm vào giỏ hàng
•	Đặt hàng
Admin:
•	CRUD danh mục
•	CRUD sản phẩm
•	Quản lý đơn hàng
•	Upload & quản lý ảnh
Output: 
•	Sơ đồ chức năng (Use Case) 
•	Flow đặt hàng
1.1. Sơ đồ chức năng (Use Case) Hệ thống xoay quanh 2 nhóm đối tượng (Actor) chính là User và Admin với các Use Case cụ thể như sau:
Tác nhân 1: User (Người dùng/Khách hàng)
•	Xem danh mục hoa: Người dùng có thể xem và duyệt các loại hoa theo chủ đề như sinh nhật, khai trương.
•	Xem chi tiết sản phẩm: Xem thông tin cụ thể của từng bó/lẵng hoa.
•	Quản lý giỏ hàng: Thêm sản phẩm vào giỏ hàng (có thể kèm theo các thao tác xóa sản phẩm hoặc cập nhật số lượng),.
•	Đặt hàng: Tiến hành chốt đơn tại trang checkout,.
Tác nhân 2: Admin (Quản trị viên)
•	Quản lý danh mục (CRUD): Thêm mới, đọc, cập nhật và xóa các danh mục sản phẩm.
•	Quản lý sản phẩm (CRUD): Thêm mới, đọc, cập nhật và xóa các sản phẩm hoa.
•	Quản lý ảnh: Upload và quản lý ảnh của sản phẩm (lưu trữ tại storage/app/public),.
•	Quản lý đơn hàng: Xem danh sách các đơn đặt hàng và cập nhật trạng thái đơn hàng (ví dụ: pending, completed)
 
1.2. Flow đặt hàng (Quy trình luồng đặt hàng) Từ các chức năng đã liệt kê và cấu trúc database của hệ thống, luồng đặt hàng sẽ diễn ra theo trình tự sau:
•	Bước 1 (Tìm kiếm & Lựa chọn): Khách hàng duyệt danh mục hoa hoặc trang chủ để tìm kiếm sản phẩm, sau đó click vào để xem chi tiết sản phẩm,.
•	Bước 2 (Giỏ hàng): Khách hàng quyết định mua và thêm sản phẩm vào giỏ hàng. Dữ liệu giỏ hàng lúc này có thể được lưu trữ thông qua Session hoặc Database,.
•	Bước 3 (Checkout): Khách hàng chuyển đến trang Checkout để xác nhận thông tin và tiến hành đặt hàng,.
•	Bước 4 (Hệ thống ghi nhận): Hệ thống backend xử lý tạo đơn hàng mới. Thông tin tổng quan của đơn (như user_id, total_price, status) được lưu vào bảng orders, đồng thời thông tin chi tiết từng loại hoa đã mua (product_id, quantity, price) được lưu vào bảng order_items,.
•	Bước 5 (Cập nhật trạng thái): Giao dịch hoàn tất ở phía khách hàng. Đơn hàng chuyển về Admin Dashboard để quản trị viên theo dõi và cập nhật trạng thái từ chờ xử lý sang hoàn tất
•	Sơ đồ hoạt dộng  (Active diagram)
 
•	Sơ đồ tuần tự  (Sequence diagram) 
________________________________________
2. Thiết kế Database
Các bảng chính:
•	users
•	categories
•	products
•	orders
•	order_items
•	images
Quan hệ:
•	category 1-n product
•	order 1-n order_items
•	product 1-n order_items
Output: ERD (Entity Relationship Diagram)
2.1.	Các thực thể (Bảng) và Thuộc tính chi tiết Dựa trên roadmap, hệ thống bao gồm 6 bảng chính: users, categories, products, orders, order_items, và images. Cấu trúc các bảng được thiết kế như sau:
•	Bảng users (Người dùng): Lưu trữ thông tin khách hàng và quản trị viên với các phân quyền như admin, user.
o	id (Primary Key)
o	name, email, password (Các trường mặc định cho Login/Register)
o	is_admin (Cờ phân quyền quản trị viên)
•	Bảng categories (Danh mục):
o	id (Primary Key)
o	name (Tên danh mục)
•	Bảng products (Sản phẩm):
o	id (Primary Key)
o	category_id (Foreign Key - liên kết tới bảng categories)
o	name, price, description, image (Các thông tin cơ bản của sản phẩm)
•	Bảng orders (Đơn hàng):
o	id (Primary Key)
o	user_id (Foreign Key - liên kết tới bảng users, đại diện cho người đặt hàng)
o	total_price (Tổng tiền)
o	status (Trạng thái đơn hàng: ví dụ pending, completed)
•	Bảng order_items (Chi tiết đơn hàng):
o	id (Primary Key)
o	order_id (Foreign Key - liên kết tới bảng orders)
o	product_id (Foreign Key - liên kết tới bảng products)
o	quantity (Số lượng)
o	price (Giá tại thời điểm mua)
•	Bảng images (Hình ảnh bổ sung): Hỗ trợ chức năng nâng cao như upload nhiều ảnh cho một sản phẩm.
o	id (Primary Key)
o	product_id (Foreign Key - liên kết tới bảng products)
o	image_path (Đường dẫn lưu trữ ảnh)
2.2.	Mối quan hệ (Relationships) Theo định nghĩa từ roadmap, các bảng có mối quan hệ chuẩn như sau:
•	Category 1-N Product: Một danh mục (categories) có thể chứa nhiều sản phẩm (products), nhưng một sản phẩm chỉ thuộc một danh mục.
•	Order 1-N Order_Items: Một đơn hàng (orders) bao gồm nhiều chi tiết đơn hàng (order_items).
•	Product 1-N Order_Items: Một sản phẩm (products) có thể xuất hiện trong nhiều chi tiết đơn hàng (order_items) khác nhau.
•	User 1-N Order (Suy luận từ cấu trúc): Một người dùng (users) có thể tạo ra nhiều đơn hàng (orders), thể hiện qua trường user_id lưu trong lúc tạo đơn.
•	Product 1-N Image (Suy luận từ cấu trúc): Một sản phẩm (products) có thể có nhiều hình ảnh bổ sung (images).

 
________________________________________
🏗️ Giai đoạn 2: Setup môi trường 
1. Cài đặt môi trường
•	Cài Laragon
2. Tạo project Laravel
composer create-project laravel/laravel flower-shop
3. Cấu hình
•	File .env:
o	DB_DATABASE
o	DB_USERNAME
o	DB_PASSWORD
•	Generate key:
php artisan key:generate
•	Migration:
php artisan migrate
Output:
•	Project chạy được trên localhost
________________________________________
🧱 Giai đoạn 3: Xây dựng Backend (Core) 
1. Authentication
•	Laravel Breeze hoặc Laravel UI
•	Chức năng:
o	Login
o	Register
•	Phân quyền:
o	admin
o	user
________________________________________
2. Module Category
•	CRUD danh mục
•	Validation:
$request->validate([
    'name' => 'required|unique:categories|max:255',
]);
________________________________________
3. Module Product
•	CRUD sản phẩm:
o	name
o	price
o	description
o	image
o	category_id
Upload ảnh:
•	Lưu tại:
storage/app/public
________________________________________
4. Giỏ hàng (Cart)
•	Lưu bằng Session hoặc Database
•	Chức năng:
o	Thêm sản phẩm
o	Xóa sản phẩm
o	Cập nhật số lượng
________________________________________
5. Đặt hàng (Order)
•	Tạo đơn hàng:
o	user_id
o	total_price
o	status
•	Bảng order_items:
o	product_id
o	quantity
o	price
________________________________________
6. Admin Dashboard
•	Xem danh sách đơn hàng
•	Cập nhật trạng thái:
o	pending
o	completed
________________________________________
🎨 Giai đoạn 4: Frontend 
Công nghệ:
•	Blade template
•	Bootstrap hoặc Tailwind
Các trang:
•	Home
•	Product list
•	Product detail
•	Cart
•	Checkout
________________________________________
🔐 Giai đoạn 5: Bảo mật
1. CSRF Protection
•	Sử dụng:
@csrf
________________________________________
2. XSS (Cross-site scripting)
•	Escape output:
{{ $product->name }}
________________________________________
3. SQL Injection
•	Sử dụng Eloquent ORM
•	Không viết raw query không kiểm soát
________________________________________
4. Validation
$request->validate([
    'name' => 'required|max:255',
]);
________________________________________
5. Authentication & Authorization
•	Middleware:
->middleware('auth')
•	Kiểm tra quyền:
if(auth()->user()->is_admin)
________________________________________
6. File Upload Security
•	Kiểm tra file:
'image' => 'image|mimes:jpeg,png|max:2048'
________________________________________
7. Password Hashing
•	Laravel sử dụng bcrypt mặc định
________________________________________
8. Tổng hợp bảo mật
Các lỗ hổng đã phòng tránh:
•	XSS
•	CSRF
•	SQL Injection
•	Upload file độc hại
•	Truy cập trái phép
________________________________________
🧪 Giai đoạn 6: Testing 
Kiểm thử chức năng:
•	Login / Register
•	Đặt hàng
•	Upload ảnh
Kiểm thử bảo mật:
•	Nhập:
<script>alert(1)</script>
•	Test bypass form
•	Test quyền truy cập
________________________________________
📄 Giai đoạn 7: Hoàn thiện & báo cáo
1. Nội dung báo cáo:
•	Giới thiệu đề tài
•	Kiến trúc hệ thống
•	Thiết kế database
•	Chức năng hệ thống
•	Các cơ chế bảo mật
________________________________________
2. Demo
Chuẩn bị:
•	1 tài khoản admin
•	1 tài khoản user
________________________________________
⚡ Timeline tổng thể (10–14 ngày)
Giai đoạn	Thời gian
Phân tích	1–2 ngày
Setup	1 ngày
Backend	4–5 ngày
Frontend	2–3 ngày
Security	2 ngày
Testing	1 ngày
Report	1 ngày
________________________________________
🎯 Gợi ý nâng cao (tuỳ chọn)
•	Tìm kiếm sản phẩm
•	Phân trang (pagination)
•	Xây dựng API (Laravel API)
•	Thanh toán giả lập
•	Log hoạt động admin
•	Soft delete
•	Upload nhiều ảnh cho sản phẩm
________________________________________
✅ Kết luận
Roadmap này đảm bảo:
•	Đầy đủ chức năng hệ thống bán hàng
•	Có phân quyền rõ ràng
•	Có triển khai các cơ chế bảo mật quan trọng
•	Phù hợp yêu cầu môn học lập trình mã nguồn mở
________________________________________

