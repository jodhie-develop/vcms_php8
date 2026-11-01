<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
// Simpan tanda tangan PNG dari canvas; isi diverifikasi sebagai gambar (nama file acak).
define('UPLOAD_DIR', 'gb/');
$file = upload_save_dataurl((string) in_val('imgData', 'post'), UPLOAD_DIR);
$success = $file !== false;
?>
