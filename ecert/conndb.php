<?php
// Koneksi database sertifikat (dbsertifikat) untuk modul ecert. Lihat ../conndb.php.
require_once __DIR__ . '/../_lib/bootstrap.php';
$tanggal = ("yyyy-MM-dd");
$jam = date("H:i");
$dbname = "dbsertifikat";
db_use($dbname);
