# Cara Menjalankan Project Laravel

1. Clone repository dari GitHub:

   ```
   git clone https://github.com/HamedAyani114/RM-DeltaSurya.git
   ```
2. Masuk ke direktori project:

   ```
   cd <NAMA_PROJECT>
   ```
3. Install dependencies menggunakan Composer:

   ```
   composer install
   ```
4. Copy file `.env.example` menjadi `.env`

   ```
   cp .env.example .env
   ```
5. Generate application key:

   ```
   php artisan key:generate
   ```
6. Sesuaikan konfigurasi database ada file `.env`.
7. Jalankan migrasi dan seeder database:

   ```
   php artisan migrate --seed
   ```
8. Jalankan perintah symbolic link untuk menyimpan file storage:

   ```
   php artisan storage:link
   ```
9. Jalankan server lokal:

   ```
   php artisan serve
   ```
10. Buka browser dan akses localhost(sesuaikan port yang digunakan):

    ```
    http://localhost:8000
    ```
