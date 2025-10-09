# Website Đặt Vé Xem Phim

## 1. Giới thiệu

Đây là project **website đặt vé xem phim** được xây dựng bằng **Laravel (PHP)**.  
Website có hai vai trò người dùng:

- **Admin**: quản lý phim, thể loại, phòng chiếu, ghế, suất chiếu.
- **User**: đặt vé, xem lịch sử vé.

Phiên bản hiện tại là **phiên bản đơn giản**, có thể mở rộng thêm: upload hình ảnh, AJAX, API ngoài, responsive mobile.

---

## 2. Chức năng chính

### Admin

- Quản lý phim: thêm, sửa, xóa, hiển thị.
- Quản lý thể loại phim.
- Quản lý phòng chiếu, ghế ngồi.
- Quản lý suất chiếu.

### User

- Đăng ký, đăng nhập.
- Cập nhật thông tin cá nhân.
- Xem danh sách phim.
- Đặt vé và lưu lịch sử đặt vé.
- Xem đánh giá phim và bình luận.

---

## 3. Cấu trúc database

Bảng chính:

| Bảng            | Mô tả                                |
| --------------- | ------------------------------------ |
| `nguoi_dung`    | Thông tin người dùng (admin / khách) |
| `phim`          | Thông tin phim                       |
| `the_loai`      | Danh sách thể loại                   |
| `phim_the_loai` | Liên kết N-N phim và thể loại        |
| `phong_chieu`   | Thông tin phòng chiếu                |
| `ghe_ngoi`      | Thông tin ghế trong phòng chiếu      |
| `suat_chieu`    | Suất chiếu phim                      |
| `ve`            | Vé người dùng đặt                    |
| `chi_tiet_ve`   | Ghế trong vé (chi tiết)              |
| `danh_gia_phim` | Đánh giá và bình luận phim           |

> Project sử dụng **MySQL** với file SQL sẵn có (`database.sql`).

---

## 4. Cấu hình project

1. Clone repo về local:

```bash
git clone https://github.com/USERNAME/website-dat-ve-phim.git
cd website-dat-ve-phim
```

2. Cài dependencies Laravel:

```bash
composer install
```

3. Copy file `.env.example` → `.env` và chỉnh thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_dat_ve_phim
DB_USERNAME=root
DB_PASSWORD=123
```

4. Import database:

- Mở **phpMyAdmin / MySQL Workbench**, import file `db_dat_ve_phim.sql` vào MySQL.

5. Chạy project:

```bash
php artisan serve
```

- Mở trình duyệt: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 5. Route & Controller

- Project sử dụng **MVC của Laravel**: Models, Controllers, Views.
- Route được định nghĩa trong `routes/web.php`.
- Controller xử lý logic chính:
  - `NguoiDungController` → người dùng
  - `PhimController` → phim
  - `SuatChieuController` → suất chiếu
  - `VeController` → vé
  - `TheLoaiController` → thể loại
  - `PhimTheLoaiController` → liên kết phim-thể loại
  - `PhongChieuController` → phòng chiếu
  - `GheNgoiController` → ghế
  - `ChiTietVeController` → chi tiết vé
  - `DanhGiaPhimController` → đánh giá phim

---

## 6. Chú ý

- Không push file `.env` lên GitHub (bảo mật thông tin database).
- Dùng `.env.example` để các thành viên cấu hình local.
- Các thành viên clone về chỉ cần import database SQL và chỉnh `.env` là chạy được project.

---

## 7. Thành viên nhóm

| Họ tên | Công việc                                                            |
| ------ | -------------------------------------------------------------------- |
| Thịnh  | Đăng ký/đăng nhập, phân quyền, đổi mật khẩu, hiển thị danh sách phim |
| Tài    | Quản lý phim, thể loại, phòng chiếu, ghế, suất chiếu (Admin)         |
| Tiến   | Đặt vé, thanh toán, lịch sử vé                                       |
| Tùng   | Vẽ sơ đồ use case, ERD, hoạt động, mô tả cấu trúc bảng               |

---

## 8. Ghi chú thêm

- Project có thể mở rộng: upload hình ảnh, AJAX cho giỏ hàng, tìm kiếm, bình luận, tích hợp API bên ngoài (Google Maps, OpenWeather), responsive mobile.
- Database đã có dữ liệu mẫu, không cần migration hay seeder.
