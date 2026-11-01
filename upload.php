<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
// Simpan tanda tangan (data URL dari canvas). Versi lama memakai tipe dari teks kiriman browser
// sebagai ekstensi file (bisa menulis file .php); kini tipe ditentukan dari isi file.
$folderPath = "e_sign/";

$file = upload_save_dataurl((string) in_val('signed', 'post'), $folderPath);
if ($file === false) {
    echo "<h3><i>Upload Tanda Tangan Gagal: " . e(upload_error()) . "</i><h3>";
    exit;
}
echo "<h3><i>Upload Tanda Tangan Berhasil..</i><h3>";
?>
