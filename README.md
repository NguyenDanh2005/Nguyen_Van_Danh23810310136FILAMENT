#  XÂY DỰNG HỆ THỐNG QUẢN TRỊ VỚI LARAVEL FILAMENT
# Nguyễn Văn Danh
# Lớp D18CNPM2
**MSSV:** 23810310136 

## Các bước chính đã thực hiện

### 1. Cài đặt Laravel và Filament 3.2
- Tạo project Laravel, cấu hình database.
- Cài Filament 3.2.15: `composer require filament/filament:"3.2.15" -W`
- Cài đặt panels: `php artisan filament:install --panels`

### 2. Tạo cấu trúc database (prefix MSSV)
- Bảng: [`sv23810310136_categories`](database/migrations) và [`sv23810310136_products`](database/migrations)  
- Model: [`Category.php`](app/Models/Category.php) | [`Product.php`](app/Models/Product.php)

### 3. Tùy chỉnh màu primary
- Đổi màu  trong `AdminPanelProvider.php`
- Cấu hình trong [`AdminPanelProvider.php`](app/Providers/Filament/AdminPanelProvider.php)

### 4. Tạo Filament Resources
- `php artisan make:filament-resource Category --generate`
- `php artisan make:filament-resource Product --generate`
- Điều chỉnh các file resource theo yêu cầu.

### 5. Chi tiết CategoryResource
- Tự động sinh slug từ name (chỉ khi tạo mới).
- Form có RichEditor cho description.
- Bảng hiển thị name, slug, is_visible, có bộ lọc is_visible.
- Xem code: 
- 📄 [CategoryResource.php](app/Filament/Resources/CategoryResource.php)

### 6. Chi tiết ProductResource
- Form dạng Grid (2 cột), có RichEditor, upload 1 ảnh.
- Validation: price >= 0, stock_quantity là số nguyên >= 0.
- Bảng hiển thị giá dạng VND (money), có tìm kiếm theo tên, lọc theo danh mục.
- Trường sáng tạo: `warranty_months` (bảo hành tháng).
- Xem code:
- 📄 [ProductResource.php](app/Filament/Resources/ProductResource.php)

### 7. Tạo user admin và chạy
- `php artisan make:filament-user`
- `php artisan storage:link`
- `php artisan serve`


