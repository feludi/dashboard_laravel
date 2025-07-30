# 🌍 SIMWNA - Sistem Pemetaan WNA

**Sistem Informasi Manajemen Warga Negara Asing**  
Dashboard komprehensif berbasis Laravel untuk pelacakan dan visualisasi data WNA dengan kemampuan pemetaan geografis khusus untuk **Kantor Imigrasi Kelas I TPI Cirebon**.

## 🚀 **Akses Cepat**

**📱 Dashboard Live:**
- **Dashboard Utama**: http://localhost:8002/dashboard
- **Manajemen WNA**: http://localhost:8002/foreigners
- **Peta Interaktif**: http://localhost:8002/dashboard/map
- **Analitik**: http://localhost:8002/dashboard/analytics
- **Login Sistem**: http://localhost:8002/login

## 🎯 **Manajemen Server**

```powershell
# Start server
php artisan serve --port=8002

# Database commands
php artisan migrate
php artisan db:seed

# Clear cache
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 🎨 **Fitur Utama**

### 📊 Dashboard Analitik
- **Peta Interaktif** dengan marker lokasi WNA (Leaflet.js)
- **Analitik Real-time** dengan grafik dinamis (Chart.js)
- **Statistik Populasi** berdasarkan kewarganegaraan, jenis visa, usia
- **Distribusi Geografis** fokus wilayah Cirebon
- **Bendera Negara** untuk identifikasi visual kewarganegaraan

### 👥 Manajemen Data WNA
- **Operasi CRUD lengkap** (Create, Read, Update, Delete)
- **Upload Foto WNA** dengan preview dan validasi format
- **Pencarian dan filter** berdasarkan berbagai kriteria
- **Dropdown Bertingkat** untuk wilayah (Kota/Kabupaten → Kecamatan → Desa/Kelurahan)
- **Generate Koordinat Otomatis** berdasarkan data administratif
- **Validasi Data** dan penanganan error
- **Tampilan Responsif** dengan Bootstrap 5.3
- **Interface Bahasa Indonesia** lengkap

### �️ Sistem Pemetaan Khusus Cirebon
- **Fokus Regional**: Cirebon, Indramayu, Majalengka, Kuningan
- **Koordinat Otomatis**: Generate koordinat dari data Kota/Kecamatan/Desa
- **Fallback System**: Database koordinat lokal jika API gagal
- **Marker Interaktif**: Popup informasi lengkap dengan bendera negara

### 🏛️ Khusus Imigrasi
- **195+ Kewarganegaraan** lengkap dengan bendera
- **Status Visa**: Tracking masa berlaku dan kedaluwarsa
- **Pelaporan**: Data analitik untuk keperluan administrasi
- **Lokalisasi Indonesia**: Seluruh interface dalam Bahasa Indonesia

## 🗄️ **Database**

**Setup Saat Ini:**
- **Database**: MySQL via XAMPP
- **Nama Database**: `foreigner_dashboard`
- **Data Sample**: 50+ record WNA realistis
- **Tabel Utama**: `foreigners`, `regions`, `migrations`
- **Seed Data**: Region Cirebon lengkap (8 wilayah administratif)

**Field Database Utama:**
- Data Personal: Nama, Paspor, Kewarganegaraan, Foto
- Data Visa: Jenis, Tanggal masuk, Kedaluwarsa
- Data Lokasi: Kota/Kabupaten, Kecamatan, Desa/Kelurahan
- Koordinat: Latitude, Longitude (auto-generated)
- Status: Aktif, Kedaluwarsa, dll.

## 🛠️ **Stack Teknologi**

**Backend:**
- **Laravel 11** dengan Eloquent ORM
- **MySQL** database via XAMPP
- **PHP 8.4**
- **Session Authentication** sistem login
- **CountryHelper Class** untuk mapping bendera negara

**Frontend:**
- **Bootstrap 5.3** framework responsif
- **Leaflet.js** pemetaan interaktif
- **Chart.js** visualisasi data
- **FontAwesome 6** icons
- **FlagCDN API** untuk bendera negara real
- **OpenStreetMap Nominatim** untuk geocoding

**Fitur Khusus:**
- **Bahasa Indonesia** interface lengkap
- **Tema Emas-Putih-Biru Tua** sesuai identitas imigrasi
- **Responsive Design** mobile-friendly
- **Real-time Charts** dengan animasi

## 📁 **Struktur Proyek**

```
dashboard_laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php     # Logic dashboard & analitik
│   │   ├── ForeignerController.php     # CRUD operations WNA
│   │   └── AuthController.php          # Sistem autentikasi
│   ├── Models/
│   │   ├── Foreigner.php               # Model utama data WNA
│   │   └── Region.php                  # Model wilayah geografis
│   └── Helpers/
│       └── CountryHelper.php           # Helper bendera & kewarganegaraan
├── database/
│   ├── migrations/                     # Schema database
│   └── seeders/                        # Data sample & region Cirebon
├── resources/views/
│   ├── layouts/app.blade.php          # Layout utama
│   ├── login.blade.php                # Halaman login
│   ├── dashboard/                     # Views dashboard
│   │   ├── index.blade.php           # Dashboard utama
│   │   ├── map.blade.php             # Peta interaktif
│   │   └── analytics.blade.php        # Halaman analitik
│   └── foreigners/                    # Views manajemen WNA
│       ├── index.blade.php           # Daftar WNA
│       ├── show.blade.php            # Detail WNA
│       ├── create.blade.php          # Tambah WNA
│       └── edit.blade.php            # Edit WNA
├── routes/web.php                     # Routing aplikasi
└── public/index.php                   # Entry point web
```

## 🔧 **Konfigurasi**

**Environment (.env):**
```env
DB_CONNECTION=mysql
DB_DATABASE=foreigner_dashboard
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
CACHE_STORE=file
APP_LOCALE=id
APP_TIMEZONE=Asia/Jakarta
```

**Kredensial Login:**
- **Username**: `admin`
- **Password**: `password123`

## 🌟 **Fitur Unggulan**

### 🇮🇩 Lokalisasi Indonesia Lengkap
- Seluruh interface dalam Bahasa Indonesia
- Format tanggal dan waktu lokal Indonesia
- Terminologi sesuai standar imigrasi Indonesia

### 🏆 Sistem Bendera Negara
- 195+ bendera negara real-time dari FlagCDN
- Fallback emoji Unicode untuk reliability
- Mapping otomatis kewarganegaraan ke kode negara ISO

### 📍 Sistem Koordinat Otomatis
- Generate koordinat dari data administratif
- Integrasi OpenStreetMap Nominatim API
- Database koordinat fallback offline
- Akurasi tingkat desa/kelurahan

### 🎨 Tema Visual Khusus
- Skema warna: Emas (#FFD700), Putih (#FFFFFF), Biru Tua (#1A237E)
- Desain solid tanpa gradient
- Konsisten dengan identitas visual pemerintahan

## 🛠️ **Troubleshooting**

**Masalah Umum:**

1. **Halaman Tidak Ditemukan**: Pastikan routes sudah aktif di `routes/web.php`
2. **Error Database**: Cek service MySQL XAMPP sudah berjalan
3. **Cache Issues**: Jalankan `php artisan config:clear`
4. **Koordinat Tidak Muncul**: Cek koneksi internet untuk API Nominatim
5. **Bendera Tidak Tampil**: Fallback emoji akan muncul otomatis

**Command Berguna:**
```powershell
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Cek routes
php artisan route:list

# Update composer autoload (setelah menambah Helper)
composer dump-autoload
```

## ✨ **Status: Siap Produksi**

✅ **CRUD Operations Lengkap** - Tambah, lihat, edit, hapus data WNA dengan foto  
✅ **Upload Foto WNA** - Sistem upload foto dengan preview dan validasi  
✅ **Peta Interaktif** - Visualisasi geografis dengan marker dinamis  
✅ **Interface Bahasa Indonesia** - Seluruh teks sudah diterjemahkan  
✅ **195+ Kewarganegaraan** - Database lengkap dengan bendera real  
✅ **Koordinat Otomatis** - Generate dari data administratif  
✅ **Sistem Login** - Autentikasi berbasis session  
✅ **Responsive Design** - Mobile dan desktop friendly  
✅ **Regional Focus Cirebon** - Data wilayah administratif lengkap  
✅ **Real Country Flags** - Bendera negara asli dengan fallback emoji  
✅ **Clean Production Code** - File development sudah dibersihkan  

## 🎯 **Khusus untuk Kantor Imigrasi Kelas I TPI Cirebon**

**Wilayah Cakupan:**
- Kota Cirebon
- Kabupaten Cirebon  
- Kabupaten Indramayu
- Kabupaten Majalengka
- Kabupaten Kuningan

**Akses Dashboard:** http://localhost:8002/dashboard

---

**© 2025 SIMWNA - Sistem Informasi Manajemen Warga Negara Asing**  
*Kantor Imigrasi Kelas I TPI Cirebon*
