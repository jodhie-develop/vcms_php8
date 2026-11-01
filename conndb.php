<?php
// Koneksi database utama (ves_data). Kredensial dibaca dari config di luar webroot
// (lihat _lib/config.sample.php). Pengganti mysql_connect/mysql_select_db.
require_once __DIR__ . '/_lib/bootstrap.php';
$tanggal = ("yyyy-MM-dd");
$jam = date("H:i");
$dbname = "ves_data";
db_use($dbname);
