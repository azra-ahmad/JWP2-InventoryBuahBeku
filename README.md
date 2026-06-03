# MeyJuice Frozen Fruit Inventory

Sistem inventory buah beku berbasis Laravel 12, Blade, Tailwind CSS, dan MySQL.

Fitur utama:

- Laporan inventory publik tanpa login
- Login pengguna/admin
- Dashboard inventory
- CRUD kategori
- CRUD produk
- CRUD stok masuk
- CRUD stok keluar
- CRUD pengguna

## Requirements

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- MySQL

## Cara Install

Clone repository:

```bash
git clone https://github.com/azra-ahmad/JWP2-InventoryBuahBeku.git
cd JWP2-InventoryBuahBeku
```

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur konfigurasi database di file `.env`:

```env
DB_DATABASE=jwp2-inventory
DB_USERNAME=root
DB_PASSWORD=
```

Import database dari file:

```text
jwp2-inventory.sql
```

## Cara Menjalankan

Jalankan Laravel:

```bash
php artisan serve
```

Jalankan Vite/Tailwind:

```bash
npm run dev
```

Buka aplikasi:

```text
http://127.0.0.1:8000
```

## Akses Halaman

- Laporan publik: `/`
- Login: `/login`
- Dashboard: `/admin/dashboard`

## Catatan

Database menggunakan schema existing dari `jwp2-inventory.sql`, jadi pastikan file SQL tersebut sudah di-import sebelum menjalankan aplikasi.
