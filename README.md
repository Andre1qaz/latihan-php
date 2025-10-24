# Latihan PHP: Aplikasi Todo List

Aplikasi Todo List berbasis PHP dengan database PostgreSQL yang dilengkapi fitur-fitur modern.

## 🚀 Fitur Aplikasi

### Fitur Dasar
- ✅ **CRUD Todo** - Create, Read, Update, Delete todo
- 📝 **Judul & Deskripsi** - Setiap todo memiliki judul dan deskripsi detail
- 🎯 **Status Todo** - Tandai todo sebagai selesai atau belum selesai
- 📅 **Timestamp** - Mencatat waktu pembuatan dan update

### Fitur Lanjutan
- 🔍 **Pencarian Todo** - Cari todo berdasarkan judul atau deskripsi
- 🎭 **Filter Status** - Filter todo berdasarkan status (Semua, Selesai, Belum Selesai)
- 🔎 **Pencarian dengan Filter** - Pencarian tetap mempertahankan filter yang aktif
- ✋ **Validasi Judul Unik** - Tidak ada todo dengan judul yang sama
- 👁️ **Detail Todo** - Halaman khusus untuk melihat detail lengkap todo
- 🎪 **Drag & Drop Sorting** - Urutkan todo dengan drag and drop
- 💾 **Persistent Sorting** - Urutan sorting tersimpan di database

### Tampilan
- 🎨 **Modern UI** - Desain modern dengan gradient background
- 📱 **Responsive** - Tampilan optimal di desktop dan mobile
- ⚡ **Smooth Animation** - Animasi halus pada interaksi
- 🎯 **Bootstrap 5** - Menggunakan Bootstrap Icons untuk ikon
- 🌈 **Color Coded** - Status todo dibedakan dengan warna

## 📋 Requirements

- PHP 8.4 (Thread Safe)
- PostgreSQL 18
- Composer
- Bootstrap 5.3.8
- SortableJS 1.15.0

## 🛠️ Instalasi

### 1. Setup Database

Buka pgAdmin dan jalankan query berikut:

```sql
-- Buat database
CREATE DATABASE db_todo;

-- Buat tabel todo
CREATE TABLE todo (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    is_finished BOOLEAN DEFAULT FALSE,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Buat index untuk performa
CREATE INDEX idx_todo_is_finished ON todo(is_finished);
CREATE INDEX idx_todo_sort_order ON todo(sort_order);
```

### 2. Konfigurasi

Edit file `config.php` sesuai dengan konfigurasi PostgreSQL Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'postgres');
define('DB_PASSWORD', 'postgres');
define('DB_NAME', 'db_todo');
define('DB_PORT', '5432');
```

### 3. Setup PHP Extensions

Pastikan extension berikut aktif di `php.ini`:
- extension=curl
- extension=fileinfo
- extension=mbstring
- extension=exif
- extension=openssl
- extension=pdo_pgsql
- extension=pgsql

## 🎯 Menjalankan Aplikasi

Jalankan perintah berikut di terminal:

```bash
php -S localhost:8000 -t public
```

Kemudian buka browser dan akses:
```
http://localhost:8000/
```

## 📁 Struktur Proyek

```
latihan-php/
├── controllers/
│   └── TodoController.php      # Controller untuk handle request
├── models/
│   └── TodoModel.php            # Model untuk database operations
├── views/
│   ├── TodoView.php             # View halaman utama
│   └── TodoDetailView.php       # View halaman detail
├── public/
│   ├── assets/
│   │   └── vendor/
│   │       └── bootstrap-5.3.8-dist/
│   └── index.php                # Entry point aplikasi
├── config.php                   # Konfigurasi database
├── .gitignore                   # Git ignore file
└── README.md                    # Dokumentasi
```

## 🎨 Cara Menggunakan

### Menambah Todo
1. Klik tombol **"Tambah Todo"**
2. Isi judul (wajib) dan deskripsi (opsional)
3. Klik **"Simpan"**

### Filter Todo
- Klik **"Semua"** untuk melihat semua todo
- Klik **"Selesai"** untuk melihat todo yang sudah selesai
- Klik **"Belum Selesai"** untuk melihat todo yang belum selesai

### Mencari Todo
1. Gunakan search box di bagian atas
2. Ketik kata kunci yang ingin dicari
3. Pencarian akan tetap mempertahankan filter yang aktif

### Mengurutkan Todo (Drag & Drop)
1. Hover ke ikon grip (⋮⋮) di sebelah kiri todo
2. Klik dan tahan, lalu drag ke posisi yang diinginkan
3. Lepaskan untuk menyimpan urutan baru
4. Urutan akan otomatis tersimpan ke database

### Melihat Detail Todo
- Klik tombol **mata (👁️)** pada todo yang ingin dilihat detailnya

### Mengedit Todo
- Klik tombol **pensil (✏️)** untuk mengedit todo

### Menghapus Todo
- Klik tombol **trash (🗑️)** untuk menghapus todo

## 🔧 Troubleshooting

### Error "Call to undefined function pg_connect()"
Pastikan extension `pdo_pgsql` dan `pgsql` sudah diaktifkan di `php.ini`

### Error koneksi database
- Periksa username, password, dan port PostgreSQL
- Pastikan PostgreSQL service sedang berjalan
- Cek file `config.php` sudah sesuai

### Todo tidak bisa di-drag
- Pastikan sudah ada data todo di database
- Cek koneksi internet (SortableJS dimuat dari CDN)
- Periksa console browser untuk error JavaScript

## 📝 Logs

- [24/10/2025] Update fitur lengkap: filter, search, validasi, detail, drag & drop
- [14/10/2025] Menginisialisasi proyek

## 📚 Teknologi yang Digunakan

- **Backend**: PHP 8.4
- **Database**: PostgreSQL 18
- **Frontend**: Bootstrap 5.3.8, Bootstrap Icons
- **JavaScript**: SortableJS untuk drag & drop
- **Architecture**: MVC (Model-View-Controller)

## 👨‍💻 Developer Notes

### Database Schema
- Kolom `title` menggunakan constraint UNIQUE untuk validasi
- Kolom `sort_order` digunakan untuk menyimpan urutan drag & drop
- Index ditambahkan pada kolom yang sering di-query

### Security
- Input sanitization menggunakan `htmlspecialchars()`
- Prepared statements untuk mencegah SQL injection
- Session untuk menyimpan pesan flash

### Best Practices
- Kode terorganisir dengan pola MVC
- Komentar pada fungsi-fungsi penting
- Error handling pada setiap operasi database
- Responsive design untuk semua ukuran layar
