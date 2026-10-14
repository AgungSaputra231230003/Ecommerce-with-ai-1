# NovaCart

Dibuat oleh: Agung Saputra

NovaCart adalah aplikasi e-commerce berbasis Laravel yang dirancang untuk menjual produk lifestyle dengan gaya modern, cocok untuk brand Gen-Z seperti streetwear, skincare, tech, dan accessories.

Aplikasi ini dibuat dengan pendekatan storefront yang modern, pengalaman belanja cepat, dan manajemen produk yang sederhana untuk admin.

## Deskripsi Aplikasi

NovaCart adalah platform toko online yang memungkinkan:
- pelanggan menjelajahi produk dengan filter kategori dan pencarian
- menambahkan produk ke keranjang secara cepat tanpa reload halaman
- melakukan checkout dengan ringkasan belanja
- melihat popup struk belanja setelah checkout
- melihat riwayat pembelian yang tersimpan per pengguna
- admin menambah, mengedit, dan menghapus produk serta kategori
- pengguna hanya dapat melihat histori pembelian milik mereka sendiri

Aplikasi ini dibuat dengan fokus pada pengalaman pengguna yang simpel, cepat, dan modern, serta tetap menjaga keamanan dan struktur data yang rapi.

## Fitur Utama

### Customer
- Landing page toko yang modern dan responsif
- Filter produk berdasarkan kategori
- Pencarian produk berdasarkan nama atau deskripsi
- Keranjang belanja berbasis session
- Checkout dengan konfirmasi belanja
- Popup struk belanja setelah transaksi
- Riwayat pembelian per pengguna
- Menampilkan gambar produk yang dibeli dalam riwayat

### Admin
- Dashboard admin
- CRUD kategori
- CRUD produk
- Manajemen stok dan harga
- Lihat pelanggan dan statistik produk

### Security / UX
- Validasi stok sebelum checkout
- Rate limiting untuk login dan register
- Akses route admin dibatasi untuk user dengan role admin
- Scroll to top button untuk navigasi yang lebih nyaman

## Stack Teknologi

- Laravel 13
- PHP 8.3
- MySQL
- Vite
- Tailwind CSS
- Pest (testing)

## Struktur Aplikasi

```bash
app/
  Http/
    Controllers/
    Middleware/
  Models/
config/
database/
  migrations/
  seeders/
public/
resources/
  css/
  js/
  views/
routes/
  web.php
tests/
```

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan sudah terinstall:
- PHP 8.3+
- Composer
- Node.js dan NPM
- MySQL

## Setup dan Instalasi

1. Clone repository

```bash
git clone <repository-url>
cd Toko_OnlineKu
```

2. Install dependency PHP

```bash
composer install
```

3. Install dependency frontend

```bash
npm install
```

4. Konfigurasi environment

Pastikan file `.env` sudah dibuat dan database MySQL dikonfigurasi dengan nama database `ecommerce1`.

Contoh konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce1
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate aplikasi key

```bash
php artisan key:generate
```

6. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

7. Jalankan aplikasi

```bash
php artisan serve
```

Untuk frontend asset:

```bash
npm run dev
```

Atau untuk produksi:

```bash
npm run build
```

## Default Admin

Seeder aplikasi sudah membuat user admin default, yaitu:

- Email: admin@novacart.test
- Role: admin

## URL Aplikasi

- Home: http://localhost:8000/
- Login: http://localhost:8000/login
- Register: http://localhost:8000/register
- Cart: http://localhost:8000/cart
- History: http://localhost:8000/history
- Admin: http://localhost:8000/admin

## Testing

Untuk menjalankan test:

```bash
php artisan test
```

## License

Proyek ini dibuat untuk kebutuhan pembelajaran dan pengembangan aplikasi e-commerce modern berbasis Laravel.

## Catatan

Aplikasi ini dapat dikembangkan lebih lanjut dengan fitur seperti:
- halaman detail produk
- sistem pembayaran online
- wishlist
- review produk
- dashboard analitik admin yang lebih lengkap

---

NovaCart siap digunakan sebagai starter project e-commerce modern dengan pendekatan UX yang cepat dan rapi.
