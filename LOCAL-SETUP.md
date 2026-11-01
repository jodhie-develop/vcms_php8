# V-CMS lokal

- Jalankan `start-local.ps1` dengan PowerShell. Skrip memulai Docker Desktop dan container PHP 8.4 + MariaDB 11.4.
- Buka http://localhost:8080 setelah impor database pertama selesai. Dump lokal harus tersedia di `fileSql/vcms_db_20261030_141735.sql`.
- Untuk menghentikan aplikasi, jalankan `stop-local.ps1`. Data database tetap tersimpan di volume Docker.
- Kredensial lokal disimpan di `.env` (diabaikan Git) dan `D:\vcms_private\config.php` (di luar webroot). Salin `.env.example` dan samakan `VCMS_DB_PASSWORD` dengan password pada config privat jika menyiapkan laptop lain.
- Dump SQL 393 MB dan folder `vendor` sengaja tidak dimasukkan ke Git; simpan dump secara lokal pada path di atas sebelum menjalankan impor.
- Database lokal hanya dipublikasikan ke laptop (`127.0.0.1:8080`).