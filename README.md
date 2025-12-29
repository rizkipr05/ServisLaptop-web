# 🛠️ ServisLaptop - Aplikasi Booking Servis Laptop

Aplikasi web modern untuk manajemen booking servis laptop yang memudahkan pelanggan untuk memesan layanan perbaikan dan admin untuk mengelola pesanan servis secara efisien.

---

## 🚀 Tech Stack

<p align="center">
  <img src=".github/assets/tech_stack_laravel.png" alt="Laravel" height="60"/>
  <img src=".github/assets/tech_stack_vue.png" alt="Vue.js" height="60"/>
  <img src=".github/assets/tech_stack_inertia.png" alt="Inertia.js" height="60"/>
  <img src=".github/assets/tech_stack_tailwind.png" alt="TailwindCSS" height="60"/>
  <img src=".github/assets/tech_stack_typescript.png" alt="TypeScript" height="60"/>
  <img src=".github/assets/tech_stack_midtrans.png" alt="Midtrans" height="60"/>
</p>

### Backend
- **Laravel 12** - Framework PHP modern dan powerful
- **PHP 8.2+** - Bahasa pemrograman server-side
- **Laravel Sanctum** - Autentikasi API berbasis token
- **SQLite/MySQL** - Database (configurable)

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Inertia.js** - Modern monolith architecture (SPA tanpa API)
- **TypeScript** - JavaScript dengan type safety
- **TailwindCSS 4** - Utility-first CSS framework

### Payment & Real-time
- **Midtrans** - Payment gateway Indonesia
- **Laravel Echo** - Real-time event broadcasting
- **Pusher** - WebSocket service untuk chat real-time

### Development Tools
- **Vite** - Modern build tool & dev server
- **Composer** - PHP dependency manager
- **NPM** - Node package manager

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- **Registrasi & Login** pengguna
- **Role-based Access Control** (Admin & Customer)
- **Token-based Authentication** dengan Laravel Sanctum
- **Protected Routes** untuk keamanan

### 🛠️ Manajemen Layanan Servis
- **CRUD Layanan Servis** (Admin)
- **Daftar Layanan** untuk customer
- **Detail Layanan** dengan harga dan estimasi waktu
- **Status Aktif/Nonaktif** layanan

### 📋 Sistem Booking
- **Buat Booking Baru** dengan form lengkap
- **Generate Kode Booking Unik** otomatis
- **Input Detail Device**:
  - Merk laptop
  - Tipe/model
  - Serial number
  - Catatan kerusakan
- **Penjadwalan** tanggal servis
- **Riwayat Booking** untuk customer

### 📊 Tracking Status Real-time
- **Public Tracking** via kode booking (tanpa login)
- **Status Tracking**:
  - `pending` - Menunggu konfirmasi admin
  - `confirmed` - Dikonfirmasi admin
  - `in_progress` - Sedang dikerjakan
  - `completed` - Selesai
  - `cancelled` - Dibatalkan
- **History Log** perubahan status dengan timestamp

### 💳 Integrasi Pembayaran Midtrans
- **Create Payment** untuk booking yang sudah confirmed
- **Snap Payment Gateway** Midtrans
- **Webhook Handler** untuk update status pembayaran otomatis
- **Payment Status**:
  - `unpaid` - Belum dibayar
  - `pending` - Menunggu pembayaran
  - `paid` - Sudah dibayar
  - `failed` - Gagal

### 💬 Chat Customer-Admin
- **Real-time Messaging** antara customer dan admin
- **Conversation Management** per booking
- **Message History** tersimpan di database
- **Broadcasting** dengan Laravel Echo & Pusher

### 📈 Dashboard Admin
- **Statistik Lengkap**:
  - Total booking
  - Total revenue
  - Booking per status
  - Trend pemesanan
- **Recent Bookings** dengan quick actions
- **Revenue Reports** berdasarkan periode

### 🧾 Laporan Transaksi
- **Transaction History** untuk customer
- **Transaction Reports** untuk admin
- **Filter by Date Range**
- **Export Reports** (future feature)

### 🔔 Notifikasi Real-time
- **Status Update Notifications**
- **Payment Success Notifications**
- **New Message Alerts**
- **Laravel Queue** untuk background jobs

---

## 📂 Struktur Folder

```
servisLaptop-app/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── Admin/               # Controller khusus admin
│   │   │       │   ├── BookingController.php
│   │   │       │   ├── DashboardController.php
│   │   │       │   ├── ReportController.php
│   │   │       │   ├── ServiceController.php
│   │   │       │   └── UserController.php
│   │   │       ├── AuthController.php   # Register, login, logout
│   │   │       ├── BookingController.php # Booking customer
│   │   │       ├── ChatController.php    # Real-time chat
│   │   │       ├── PaymentController.php # Midtrans payment
│   │   │       ├── MidtransWebhookController.php
│   │   │       ├── ServiceController.php # Public services
│   │   │       └── TransactionController.php
│   │   └── Middleware/                  # Custom middleware
│   │
│   ├── Models/                          # Eloquent Models
│   │   ├── Booking.php                  # Model booking
│   │   ├── BookingStatusLog.php         # Log status booking
│   │   ├── Conversation.php             # Chat conversation
│   │   ├── Message.php                  # Chat message
│   │   ├── Payment.php                  # Payment record
│   │   ├── Service.php                  # Service/layanan
│   │   └── User.php                     # User (admin & customer)
│   │
│   └── Events/                          # Laravel Events
│       └── MessageSent.php              # Event untuk broadcasting
│
├── database/
│   ├── migrations/                      # Database schema
│   │   ├── 2025_12_29_*_create_users_table.php
│   │   ├── 2025_12_29_*_create_services_table.php
│   │   ├── 2025_12_29_*_create_bookings_table.php
│   │   ├── 2025_12_29_*_create_booking_status_logs_table.php
│   │   ├── 2025_12_29_*_create_payments_table.php
│   │   ├── 2025_12_29_*_create_conversations_table.php
│   │   └── 2025_12_29_*_create_messages_table.php
│   │
│   ├── seeders/                         # Sample data
│   │   ├── DatabaseSeeder.php
│   │   └── ServiceSeeder.php
│   │
│   └── factories/                       # Model factories untuk testing
│
├── resources/
│   ├── js/
│   │   ├── components/                  # Vue components reusable
│   │   ├── layouts/                     # Layout components
│   │   │   └── MainLayout.vue           # Main app layout
│   │   ├── pages/                       # Inertia pages
│   │   │   ├── Home.vue                 # Customer home
│   │   │   └── Welcome.vue              # Landing page
│   │   ├── types/                       # TypeScript types
│   │   ├── lib/                         # Utility functions
│   │   ├── app.ts                       # Main Vue app
│   │   └── ssr.ts                       # SSR entry point
│   │
│   ├── css/
│   │   └── app.css                      # Main stylesheet
│   │
│   └── views/
│       └── app.blade.php                # Main HTML template
│
├── routes/
│   ├── api.php                          # API routes (REST)
│   ├── web.php                          # Web routes (Inertia)
│   ├── channels.php                     # Broadcasting channels
│   └── console.php                      # Artisan commands
│
├── public/                              # Public assets
│   ├── build/                           # Compiled assets (Vite)
│   └── storage/                         # Public storage link
│
├── storage/
│   ├── app/                             # Application files
│   ├── framework/                       # Framework cache
│   └── logs/                            # Application logs
│
├── config/                              # Configuration files
│   ├── app.php
│   ├── database.php
│   ├── broadcasting.php
│   └── services.php                     # Third-party services (Midtrans)
│
├── tests/                               # Automated tests
│   ├── Feature/
│   └── Unit/
│
├── .env.example                         # Environment template
├── composer.json                        # PHP dependencies
├── package.json                         # Node dependencies
├── vite.config.ts                       # Vite configuration
├── tsconfig.json                        # TypeScript configuration
└── artisan                              # Laravel CLI
```

---

## 🔧 Instalasi Proyek Baru

### Prerequisites

Pastikan sistem Anda sudah terinstall:
- **PHP >= 8.2** ([Download PHP](https://www.php.net/downloads))
- **Composer** ([Download Composer](https://getcomposer.org/download/))
- **Node.js >= 18** dan **NPM** ([Download Node.js](https://nodejs.org/))
- **SQLite** (biasanya sudah include di PHP) atau **MySQL**

### Langkah-langkah Instalasi

#### 1. Clone Repository

```bash
git clone <repository-url> servisLaptop-app
cd servisLaptop-app
```

#### 2. Install PHP Dependencies

```bash
composer install
```

#### 3. Install Node Dependencies

```bash
npm install
```

#### 4. Setup Environment

```bash
# Copy file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Konfigurasi Database

**Opsi A: Menggunakan SQLite (Recommended untuk development)**

File `.env` sudah dikonfigurasi untuk SQLite secara default. Database akan dibuat otomatis saat migrasi.

```env
DB_CONNECTION=sqlite
```

**Opsi B: Menggunakan MySQL**

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servislaptop_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database terlebih dahulu:
```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE servislaptop_db;
exit;
```

#### 6. Jalankan Migrasi Database

```bash
# Buat tabel-tabel database
php artisan migrate
```

#### 7. Seed Data Awal (Opsional)

```bash
# Isi database dengan data sample
php artisan db:seed

# Atau jalankan seeder tertentu
php artisan db:seed --class=ServiceSeeder
```

Data yang di-seed:
- User Admin (email: `admin@example.com`, password: `password`)
- User Customer sample
- Layanan servis sample

#### 8. Build Frontend Assets

**Development Mode:**
```bash
npm run dev
```

**Production Build:**
```bash
npm run build
```

#### 9. Jalankan Aplikasi

**Opsi A: Jalankan server secara terpisah (Manual)**

Terminal 1 - Laravel Server:
```bash
php artisan serve
```

Terminal 2 - Vite Dev Server:
```bash
npm run dev
```

**Opsi B: Jalankan semua sekaligus (Recommended)**

```bash
composer run dev
```

Perintah di atas akan otomatis menjalankan:
- Laravel server (`http://localhost:8000`)
- Queue worker (background jobs)
- Vite dev server (HMR untuk development)

#### 10. Akses Aplikasi

Buka browser dan akses:
```
http://localhost:8000
```

Login sebagai admin:
- **Email:** `admin@example.com`
- **Password:** `password`

---

## 🗄️ Instalasi dengan Database yang Sudah Ada

Jika Anda sudah memiliki database dari sebelumnya (misalnya ekspor dari server production atau dari developer lain):

### Langkah-langkah

#### 1. Clone & Install Dependencies

```bash
git clone <repository-url> servisLaptop-app
cd servisLaptop-app
composer install
npm install
```

#### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

#### 3. Import Database

**Untuk MySQL:**

```bash
# Import file SQL ke database
mysql -u root -p servislaptop_db < database_backup.sql
```

**Untuk SQLite:**

```bash
# Copy file database.sqlite ke folder database/
cp /path/to/your/database.sqlite database/database.sqlite
```

#### 4. Konfigurasi .env

Edit file `.env` sesuai dengan database Anda:

**MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servislaptop_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

**SQLite:**
```env
DB_CONNECTION=sqlite
# Path relatif dari root project: database/database.sqlite
```

#### 5. JANGAN Jalankan Migrasi

⚠️ **PENTING:** Karena database sudah ada, **JANGAN** menjalankan:
```bash
# JANGAN JALANKAN INI!
# php artisan migrate
```

Jika ada perubahan struktur database terbaru yang perlu diterapkan, konsultasikan dengan team terlebih dahulu.

#### 6. Clear Cache (Opsional tapi Recommended)

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 7. Jalankan Aplikasi

```bash
# Jalankan semua services sekaligus
composer run dev

# Atau manual di terminal terpisah
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
```

#### 8. Verifikasi

Buka `http://localhost:8000` dan pastikan:
- ✅ Data lama masih ada
- ✅ Bisa login dengan akun yang ada
- ✅ Semua fitur berfungsi normal

---

## ⚙️ Konfigurasi Tambahan

### 🔑 Midtrans Configuration

Untuk mengaktifkan fitur pembayaran Midtrans:

1. **Daftar di [Midtrans](https://midtrans.com/)**
2. **Dapatkan Server Key dan Client Key** dari dashboard Midtrans
3. **Tambahkan ke file `.env`:**

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 📡 Broadcasting Configuration (Real-time Chat)

Untuk mengaktifkan fitur chat real-time:

1. **Daftar di [Pusher](https://pusher.com/)** (gratis untuk development)
2. **Tambahkan credentials ke `.env`:**

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=ap1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

3. **Jalankan queue worker:**

```bash
php artisan queue:work
```

### 📧 Mail Configuration

Untuk mengaktifkan notifikasi email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 🔄 Queue Worker

Untuk background jobs (notifikasi, email, dll):

```bash
# Development
php artisan queue:work

# Production (dengan supervisor)
php artisan queue:listen --tries=3
```

---

## 🚀 Menjalankan Aplikasi

### Development Mode

**Cara 1: Menggunakan Composer Script (Recommended)**

```bash
composer run dev
```

Ini akan menjalankan secara bersamaan:
- Laravel development server (port 8000)
- Queue worker
- Vite dev server (HMR)

**Cara 2: Manual (3 terminal terpisah)**

Terminal 1 - Laravel:
```bash
php artisan serve
```

Terminal 2 - Vite:
```bash
npm run dev
```

Terminal 3 - Queue Worker (opsional, untuk fitur real-time):
```bash
php artisan queue:work
```

### Production Mode

#### 1. Build Frontend Assets

```bash
npm run build
```

#### 2. Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 3. Setup Web Server

Gunakan web server seperti **Nginx** atau **Apache**:
- Document root: `/path/to/servisLaptop-app/public`
- PHP-FPM untuk menjalankan Laravel

#### 4. Setup Queue Worker dengan Supervisor

```bash
sudo apt install supervisor

# Buat file config: /etc/supervisor/conf.d/servislaptop-worker.conf
[program:servislaptop-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/servisLaptop-app/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/servisLaptop-app/storage/logs/worker.log
```

---

## 🧪 Testing

```bash
# Jalankan semua tests
php artisan test

# Atau menggunakan PHPUnit langsung
./vendor/bin/phpunit

# Run specific test
php artisan test --filter=BookingTest
```

---

## 📡 API Documentation

### Endpoints Utama

#### Authentication
```
POST   /api/auth/register          - Registrasi user baru
POST   /api/auth/login             - Login
POST   /api/auth/logout            - Logout
GET    /api/auth/me                - Get user info
```

#### Services (Public)
```
GET    /api/services               - List semua layanan aktif
GET    /api/services/{id}          - Detail layanan
```

#### Bookings (Customer)
```
POST   /api/bookings               - Buat booking baru
GET    /api/bookings               - List booking user
GET    /api/bookings/{id}          - Detail booking
GET    /api/tracking/{code}        - Track booking (public)
```

#### Bookings (Admin)
```
GET    /api/admin/bookings         - List semua booking
GET    /api/admin/bookings/{id}    - Detail booking
PATCH  /api/admin/bookings/{id}/confirm      - Konfirmasi booking
PATCH  /api/admin/bookings/{id}/status       - Update status
PATCH  /api/admin/bookings/{id}/price        - Set harga final
```

#### Payments (Customer)
```
POST   /api/payments/{booking}/create  - Buat payment
GET    /api/payments/{booking}         - Cek status payment
```

#### Admin Dashboard
```
GET    /api/admin/dashboard        - Dashboard statistics
GET    /api/admin/reports/transactions  - Transaction reports
```

### Authentication Flow

1. **Register/Login** → Dapat token
2. **Set Header** pada request selanjutnya:
   ```
   Authorization: Bearer {token}
   ```
3. **Access Protected Routes**

---

## 🤝 Contributing

Jika Anda ingin berkontribusi pada proyek ini:

1. Fork repository
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 License

Proyek ini menggunakan [MIT License](LICENSE).

---

## 📞 Support

Jika ada pertanyaan atau butuh bantuan:

- **Email:** support@servislaptop.com
- **Issues:** [GitHub Issues](https://github.com/your-repo/issues)
- **Documentation:** [Wiki](https://github.com/your-repo/wiki)

---

## 🙏 Credits

Terima kasih kepada semua kontributor dan pengguna tools open-source berikut:

- [Laravel](https://laravel.com/)
- [Vue.js](https://vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [TailwindCSS](https://tailwindcss.com/)
- [Midtrans](https://midtrans.com/)
- [Pusher](https://pusher.com/)

---


