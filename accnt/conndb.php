<?php
// Koneksi database utama (ves_data) untuk modul accnt. Lihat ../conndb.php.
require_once __DIR__ . '/../_lib/bootstrap.php';
$tanggal = ("yyyy-MM-dd");
$jam = date("H:i");
$dbname = "ves_data";
db_use($dbname);
