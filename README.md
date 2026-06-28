# 🏨 Hotel Ilham - Sistem Pemesanan Hotel
> Dibuat dengan **CodeIgniter 4** + **Bootstrap 5** untuk memenuhi Syarat UAS Mata Kuliah Pemrograman Web

---

## ✅ Syarat UAS yang Terpenuhi

| Syarat | Status |
|--------|--------|
| CodeIgniter 4 | ✅ |
| Routing | ✅ 38 routes terdaftar |
| Filter/Middleware Login | ✅ AuthFilter, AdminFilter, CustomerFilter |
| 2 Role (Admin & Customer) | ✅ |
| Minimal 1 Resource API | ✅ `GET /api/rooms` |
| Minimal 1 Fitur AJAX | ✅ Pencarian & filter kamar real-time |
| Localhost XAMPP/Laragon | ✅ |

---

## 🚀 Cara Menjalankan di Localhost

### Langkah 1 — Aktifkan XAMPP / Laragon
- Jalankan **Apache** dan **MySQL** pada XAMPP atau Laragon

### Langkah 2 — Import Database
1. Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
2. Klik **Import** → pilih file: `hotel_booking_db.sql` (ada di folder project ini)
3. Klik **Go** / Import

> Alternatif via command line:
> ```bash
> mysql -u root -p < hotel_booking_db.sql
> ```

### Langkah 3 — Konfigurasi Database
Buka file `.env` dan sesuaikan jika perlu:
```env
database.default.hostname = localhost
database.default.database = hotel_booking_db
database.default.username = root
database.default.password =          ← kosongkan jika tidak ada password
database.default.port     = 3306
```

### Langkah 4 — Jalankan Server
```bash
php spark serve
```
Buka browser: **http://localhost:8080**

---

## 🔐 Akun Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Customer | `customer` | `customer123` |

---

## 📁 Struktur Folder Penting

```
hotel ilham/
├── app/
│   ├── Config/
│   │   ├── Routes.php          ← Semua routing (Admin, Customer, API)
│   │   └── Filters.php         ← Registrasi filter middleware
│   ├── Controllers/
│   │   ├── AuthController.php  ← Login, Register, Logout
│   │   ├── HomeController.php  ← Home & Daftar Kamar
│   │   ├── RoomApiController.php ← API /api/rooms (JSON)
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── RoomController.php
│   │   │   ├── FacilityController.php
│   │   │   └── BookingController.php
│   │   └── Customer/
│   │       ├── DashboardController.php
│   │       └── BookingController.php
│   ├── Filters/
│   │   ├── AuthFilter.php      ← Cek login
│   │   ├── AdminFilter.php     ← Cek role admin
│   │   └── CustomerFilter.php  ← Cek role customer
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── CategoryModel.php
│   │   ├── RoomModel.php
│   │   ├── FacilityModel.php
│   │   ├── BookingModel.php
│   │   └── PaymentModel.php
│   ├── Database/
│   │   ├── Migrations/         ← Semua file migrasi tabel
│   │   └── Seeds/              ← Seeder admin, customer, rooms, dll
│   └── Views/
│       ├── layout/main.php     ← Template utama Bootstrap 5
│       ├── auth/               ← Login & Register
│       ├── home.php            ← Halaman utama
│       ├── rooms/              ← Daftar & detail kamar (AJAX)
│       ├── admin/              ← Semua views admin
│       └── customer/           ← Semua views customer
├── public/
│   └── uploads/
│       ├── rooms/              ← Foto kamar di-upload ke sini
│       └── payments/           ← Bukti pembayaran di-upload ke sini
├── hotel_booking_db.sql        ← File SQL untuk import database
└── .env                        ← Konfigurasi environment
```

---

## 🌐 Halaman & URL

| Halaman | URL |
|---------|-----|
| Home | `/` |
| Daftar Kamar (AJAX) | `/rooms` |
| Detail Kamar | `/rooms/{id}` |
| Login | `/login` |
| Register | `/register` |
| **API Kamar (JSON)** | `/api/rooms` |
| Dashboard Admin | `/admin/dashboard` |
| Manajemen Kategori | `/admin/categories` |
| Manajemen Kamar | `/admin/rooms` |
| Manajemen Fasilitas | `/admin/facilities` |
| Seluruh Pemesanan | `/admin/bookings` |
| Laporan Keuangan | `/admin/reports` |
| Dashboard Customer | `/customer/dashboard` |
| Edit Profil | `/customer/profile` |

---

## 🔄 Alternatif: Menggunakan Spark Migration & Seeder

Jika ingin menggunakan migration bawaan CodeIgniter (MySQL harus aktif):
```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

---

## 🛠️ Teknologi yang Digunakan

- **CodeIgniter 4.7.3** — PHP Framework
- **Bootstrap 5.3** — CSS UI Framework
- **Bootstrap Icons** — Icon Library
- **jQuery 3.7.1** — AJAX & DOM Manipulation
- **MySQL** — Database
- **Google Fonts (Outfit)** — Typography
