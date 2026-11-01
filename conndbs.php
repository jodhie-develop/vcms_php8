<?php
// Koneksi database absensi (data_absen). Lihat conndb.php.
require_once __DIR__ . '/_lib/bootstrap.php';
$tanggal = ("yyyy-MM-dd");
$jam = date("H:i");
$dbname = "data_absen";
db_use($dbname);
