# AL BUILDING.md

## 1. Muc tieu

Tai lieu nay ghi lai cac buoc build va chay project Fresh Flower Selling Website tren moi truong local.

## 2. Yeu cau he thong

- PHP 8.3+
- Composer 2+
- Node.js 20+ va npm
- MySQL 8+
- Git

Luu y:
- Trong file composer hien tai, framework dang la `laravel/framework: ^13.0`.
- Neu team can giu Laravel 11 theo roadmap, can chot version truoc khi release.

## 3. Clone source code

```bash
git clone <repo-url>
cd flower-shop
```

## 4. Cai dat backend dependencies

```bash
composer install
```

## 5. Cau hinh moi truong

### 5.1 Tao file env

```bash
copy .env.example .env
```

Neu dang dung PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5.2 Tao app key

```bash
php artisan key:generate
```

### 5.3 Cau hinh database trong .env

Cap nhat cac bien sau trong `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_shop
DB_USERNAME=root
DB_PASSWORD=
```

## 6. Khoi tao database

### 6.1 Chay migration

```bash
php artisan migrate
```

### 6.2 Seed du lieu mau (khuyen nghi cho QA/UAT)

```bash
php artisan db:seed
```

Hoac reset + seed lai tu dau:

```bash
php artisan migrate:fresh --seed
```

## 7. Cai dat frontend dependencies va build assets

### 7.1 Cai dat npm packages

```bash
npm install
```

### 7.2 Build production assets

```bash
npm run build
```

### 7.3 Chay dev assets (hot reload)

```bash
npm run dev
```

## 8. Chay ung dung local

Co 2 cach pho bien:

### Cach A: Chay tung terminal

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

### Cach B: Chay script tong hop cua Composer

```bash
composer run dev
```

Script nay se chay dong thoi:
- web server
- queue listener
- log tail (pail)
- vite dev server

## 9. Chay test va kiem tra chat luong

### 9.1 Chay test suite

```bash
php artisan test
```

Hoac:

```bash
composer test
```

### 9.2 Kiem tra route

```bash
php artisan route:list
```

## 10. Lenh setup nhanh cho may moi

Project da co script setup trong composer.json:

```bash
composer run setup
```

Script nay se tu dong:
- composer install
- tao `.env` neu chua co
- generate app key
- migrate database
- npm install
- npm run build

Sau do, chi can cau hinh dung DB trong `.env` neu chua khop va chay lai migrate/seed khi can.

## 11. Xu ly su co thuong gap

### 11.1 Loi khong ket noi DB

- Kiem tra MySQL da start.
- Kiem tra DB_* trong `.env`.
- Chay lai:

```bash
php artisan config:clear
php artisan migrate
```

### 11.2 Loi assets khong hien thi

- Dam bao da chay `npm run build` (production) hoac `npm run dev` (development).
- Xoa cache:

```bash
php artisan optimize:clear
```

### 11.3 Loi permission upload/storage

```bash
php artisan storage:link
```

## 12. Checklist build

- [ ] Da cai dat Composer dependencies thanh cong.
- [ ] Da cai dat npm dependencies thanh cong.
- [ ] Da tao file `.env` va generate key.
- [ ] Da cau hinh DB dung cho moi truong local.
- [ ] Da migrate (va seed neu can) thanh cong.
- [ ] Da build frontend assets thanh cong.
- [ ] Da chay duoc website local.
- [ ] Da chay test suite thanh cong.

## 13. Build/Run Log thuc te (Phien hien tai)

Ngay ghi nhan: 2026-04-27

Muc dich: Ghi lai cac lenh da thuc su duoc chay trong phien lam viec de doi chieu voi huong dan build.

| STT | Command | Muc dich | Ket qua |
|---|---|---|---|
| 1 | `php artisan route:list` | Kiem tra route sau khi cap nhat chuc nang admin/orders | Thanh cong |
| 2 | `php artisan test` | Chay regression test sau khi cap nhat code | Thanh cong (25 passed) |

Ghi chu:
- Phien hien tai KHONG chay lai day du chuoi build moi (composer install, npm install, npm run build, php artisan serve).
- Cac buoc tren van la huong dan build chuan cho may moi, con bang log nay la lich su thao tac thuc te trong phien.
